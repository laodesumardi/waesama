<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penduduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PendudukController extends Controller
{
    public function index(Request $request)
    {
        $query = Penduduk::query();
        
        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nik', 'like', "%{$search}%")
                  ->orWhere('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('alamat', 'like', "%{$search}%");
            });
        }
        
        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status_penduduk', $request->status);
        }
        
        $penduduk = $query->orderBy('created_at', 'desc')->paginate(10);
        
        return view('admin.penduduk.index', compact('penduduk'));
    }
    
    public function create()
    {
        return view('admin.penduduk.create');
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nik' => 'required|string|size:16|unique:penduduk,nik',
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'agama' => 'required|string|max:50',
            'pendidikan' => 'required|string|max:100',
            'pekerjaan' => 'required|string|max:100',
            'status_perkawinan' => 'required|in:Belum Kawin,Kawin,Cerai Hidup,Cerai Mati',
            'kewarganegaraan' => 'required|in:WNI,WNA',
            'no_kk' => 'required|string|size:16',
            'hubungan_keluarga' => 'required|string|max:50',
            'alamat' => 'required|string',
            'rt' => 'required|string|max:3',
            'rw' => 'required|string|max:3',
            'desa_kelurahan' => 'required|string|max:100',
            'kecamatan' => 'required|string|max:100',
            'kabupaten_kota' => 'required|string|max:100',
            'provinsi' => 'required|string|max:100',
            'kode_pos' => 'required|string|size:5',
            'status_penduduk' => 'required|in:Tetap,Pindah,Meninggal',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        $data = $request->all();
        
        // Convert jenis_kelamin to database enum format
        if ($data['jenis_kelamin'] === 'Laki-laki') {
            $data['jenis_kelamin'] = 'L';
        } elseif ($data['jenis_kelamin'] === 'Perempuan') {
            $data['jenis_kelamin'] = 'P';
        }
        
        Penduduk::create($data);
        
        return redirect()->route('admin.penduduk.index')
            ->with('success', 'Data penduduk berhasil ditambahkan.');
    }
    
    public function show(Penduduk $penduduk)
    {
        return view('admin.penduduk.show', compact('penduduk'));
    }
    
    public function edit(Penduduk $penduduk)
    {
        return view('admin.penduduk.edit', compact('penduduk'));
    }
    
    public function update(Request $request, Penduduk $penduduk)
    {
        $validator = Validator::make($request->all(), [
            'nik' => 'required|string|size:16|unique:penduduk,nik,' . $penduduk->id,
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'agama' => 'required|string|max:50',
            'pendidikan' => 'required|string|max:100',
            'pekerjaan' => 'required|string|max:100',
            'status_perkawinan' => 'required|in:Belum Kawin,Kawin,Cerai Hidup,Cerai Mati',
            'kewarganegaraan' => 'required|in:WNI,WNA',
            'no_kk' => 'required|string|size:16',
            'hubungan_keluarga' => 'required|string|max:50',
            'alamat' => 'required|string',
            'rt' => 'required|string|max:3',
            'rw' => 'required|string|max:3',
            'desa_kelurahan' => 'required|string|max:100',
            'kecamatan' => 'required|string|max:100',
            'kabupaten_kota' => 'required|string|max:100',
            'provinsi' => 'required|string|max:100',
            'kode_pos' => 'required|string|size:5',
            'status_penduduk' => 'required|in:Tetap,Pindah,Meninggal',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        $data = $request->all();
        
        // Convert jenis_kelamin to database enum format
        if ($data['jenis_kelamin'] === 'Laki-laki') {
            $data['jenis_kelamin'] = 'L';
        } elseif ($data['jenis_kelamin'] === 'Perempuan') {
            $data['jenis_kelamin'] = 'P';
        }
        
        $penduduk->update($data);
        
        return redirect()->route('admin.penduduk.index')
            ->with('success', 'Data penduduk berhasil diperbarui.');
    }
    
    public function destroy(Penduduk $penduduk)
    {
        $penduduk->delete();
        
        return redirect()->route('admin.penduduk.index')
            ->with('success', 'Data penduduk berhasil dihapus.');
    }
    
    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'excel_file' => 'required|file|mimes:xlsx,xls|max:10240', // Max 10MB
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->with('error', 'File tidak valid. Pastikan file berformat Excel (.xlsx/.xls) dan ukuran maksimal 10MB.');
        }
        
        try {
            $file = $request->file('excel_file');
            $path = $file->getRealPath();
            
            // Load Excel file
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($path);
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();
            
            $imported = 0;
            $errors = [];
            
            // Skip header row (index 0)
            for ($i = 1; $i < count($rows); $i++) {
                $row = $rows[$i];
                
                // Skip empty rows
                if (empty(array_filter($row))) {
                    continue;
                }
                
                // Validate required fields
                if (empty($row[0]) || empty($row[1])) {
                    $errors[] = "Baris " . ($i + 1) . ": NIK dan Nama Lengkap wajib diisi";
                    continue;
                }
                
                // Check if NIK already exists
                if (Penduduk::where('nik', $row[0])->exists()) {
                    $errors[] = "Baris " . ($i + 1) . ": NIK {$row[0]} sudah terdaftar";
                    continue;
                }
                
                try {
                    Penduduk::create([
                        'nik' => $row[0],
                        'nama_lengkap' => $row[1],
                        'tempat_lahir' => $row[2] ?? '',
                        'tanggal_lahir' => !empty($row[3]) ? date('Y-m-d', strtotime($row[3])) : null,
                        'jenis_kelamin' => $row[4] == 'Laki-laki' ? 'L' : ($row[4] == 'Perempuan' ? 'P' : ($row[4] == 'L' ? 'L' : 'L')),
                        'alamat' => $row[5] ?? '',
                        'rt' => $row[6] ?? '001',
                        'rw' => $row[7] ?? '001',
                        'agama' => $row[8] ?? 'Islam',
                        'status_perkawinan' => $row[9] ?? 'Belum Kawin',
                        'pekerjaan' => $row[10] ?? '',
                        'kewarganegaraan' => $row[11] ?? 'WNI',
                        'no_kk' => $row[12] ?? '0000000000000000',
                        'hubungan_keluarga' => $row[13] ?? 'Kepala Keluarga',
                        'desa_kelurahan' => $row[14] ?? 'Waesama',
                        'kecamatan' => $row[15] ?? 'Waesama',
                        'kabupaten_kota' => $row[16] ?? 'Buru',
                        'provinsi' => $row[17] ?? 'Maluku',
                        'status_penduduk' => 'Tetap',
                        'pendidikan' => 'Tidak/Belum Sekolah',
                    ]);
                    
                    $imported++;
                } catch (\Exception $e) {
                    $errors[] = "Baris " . ($i + 1) . ": " . $e->getMessage();
                }
            }
            
            $message = "Berhasil mengimpor {$imported} data penduduk.";
            if (!empty($errors)) {
                $message .= " Terdapat " . count($errors) . " error: " . implode(', ', array_slice($errors, 0, 3));
                if (count($errors) > 3) {
                    $message .= " dan " . (count($errors) - 3) . " error lainnya.";
                }
            }
            
            return redirect()->route('admin.penduduk.index')
                ->with('success', $message);
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat mengimpor file: ' . $e->getMessage());
        }
    }
}