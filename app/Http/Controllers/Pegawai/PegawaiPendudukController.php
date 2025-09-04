<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\Penduduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PegawaiPendudukController extends Controller
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
                  ->orWhere('alamat', 'like', "%{$search}%")
                  ->orWhere('no_kk', 'like', "%{$search}%");
            });
        }
        
        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status_penduduk', $request->status);
        }
        
        // Filter by gender
        if ($request->has('gender') && $request->gender) {
            $query->where('jenis_kelamin', $request->gender);
        }
        
        // Filter by RT
        if ($request->has('rt') && $request->rt) {
            $query->where('rt', $request->rt);
        }
        
        // Filter by RW
        if ($request->has('rw') && $request->rw) {
            $query->where('rw', $request->rw);
        }
        
        $penduduk = $query->orderBy('nama_lengkap', 'asc')->paginate(15);
        
        // Get filter options
        $rtOptions = Penduduk::select('rt')->distinct()->orderBy('rt')->pluck('rt');
        $rwOptions = Penduduk::select('rw')->distinct()->orderBy('rw')->pluck('rw');
        
        return view('pegawai.penduduk.index', compact('penduduk', 'rtOptions', 'rwOptions'));
    }
    
    public function show(Penduduk $penduduk)
    {
        return view('pegawai.penduduk.show', compact('penduduk'));
    }
    
    public function search(Request $request)
    {
        $query = $request->get('q');
        
        if (!$query) {
            return response()->json([]);
        }
        
        $penduduk = Penduduk::where(function($q) use ($query) {
            $q->where('nik', 'like', "%{$query}%")
              ->orWhere('nama_lengkap', 'like', "%{$query}%")
              ->orWhere('no_kk', 'like', "%{$query}%");
        })
        ->select('id', 'nik', 'nama_lengkap', 'alamat', 'rt', 'rw')
        ->limit(10)
        ->get();
        
        return response()->json($penduduk);
    }
    
    public function stats()
    {
        $stats = [
            'total' => Penduduk::count(),
            'male' => Penduduk::where('jenis_kelamin', 'L')->count(),
            'female' => Penduduk::where('jenis_kelamin', 'P')->count(),
            'by_status' => Penduduk::select('status_penduduk', DB::raw('count(*) as total'))
                ->groupBy('status_penduduk')
                ->get(),
            'by_rt' => Penduduk::select('rt', DB::raw('count(*) as total'))
                ->groupBy('rt')
                ->orderBy('rt')
                ->get(),
            'by_rw' => Penduduk::select('rw', DB::raw('count(*) as total'))
                ->groupBy('rw')
                ->orderBy('rw')
                ->get(),
        ];
        
        return response()->json($stats);
    }

    public function import(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls|max:10240', // 10MB max
        ]);

        try {
            $file = $request->file('excel_file');
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($file->getPathname());
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();

            // Skip header row
            array_shift($rows);

            $imported = 0;
            $errors = [];

            foreach ($rows as $index => $row) {
                $rowNumber = $index + 2; // +2 because we skipped header and array is 0-indexed
                
                // Skip empty rows
                if (empty(array_filter($row))) {
                    continue;
                }

                // Validate required fields
                if (empty($row[0]) || empty($row[1])) {
                    $errors[] = "Baris {$rowNumber}: NIK dan Nama Lengkap wajib diisi";
                    continue;
                }

                // Check if NIK already exists
                if (Penduduk::where('nik', $row[0])->exists()) {
                    $errors[] = "Baris {$rowNumber}: NIK {$row[0]} sudah ada dalam database";
                    continue;
                }

                try {
                    Penduduk::create([
                        'nik' => $row[0],
                        'nama_lengkap' => $row[1],
                        'tempat_lahir' => $row[2] ?? '',
                        'tanggal_lahir' => !empty($row[3]) ? date('Y-m-d', strtotime($row[3])) : null,
                        'jenis_kelamin' => $row[4] ?? 'L',
                        'alamat' => $row[5] ?? '',
                        'rt' => $row[6] ?? '001',
                        'rw' => $row[7] ?? '001',
                        'agama' => $row[8] ?? 'Islam',
                        'status_perkawinan' => $row[9] ?? 'Belum Kawin',
                        'pekerjaan' => $row[10] ?? '',
                        'kewarganegaraan' => $row[11] ?? 'WNI',
                        'no_kk' => $row[12] ?? '0000000000000000',
                        'hubungan_keluarga' => $row[13] ?? 'Kepala Keluarga',
                        'status_penduduk' => 'Tetap',
                        'desa_kelurahan' => 'Waesama',
                        'kecamatan' => 'Waesama',
                        'kabupaten_kota' => 'Buru',
                        'provinsi' => 'Maluku',
                        'kode_pos' => '97571',
                    ]);
                    $imported++;
                } catch (\Exception $e) {
                    $errors[] = "Baris {$rowNumber}: Error saat menyimpan data - " . $e->getMessage();
                }
            }

            $message = "Berhasil mengimpor {$imported} data penduduk.";
            if (!empty($errors)) {
                $message .= " Terdapat " . count($errors) . " error: " . implode(', ', array_slice($errors, 0, 3));
                if (count($errors) > 3) {
                    $message .= " dan " . (count($errors) - 3) . " error lainnya.";
                }
            }

            return redirect()->route('pegawai.penduduk.index')->with('success', $message);

        } catch (\Exception $e) {
            return redirect()->route('pegawai.penduduk.index')->with('error', 'Error saat mengimpor file: ' . $e->getMessage());
        }
    }
}