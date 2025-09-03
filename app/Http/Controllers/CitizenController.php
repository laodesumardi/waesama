<?php

namespace App\Http\Controllers;

use App\Models\Citizen;
use App\Models\Village;
use App\Models\ActivityLog;
use App\Exports\CitizensExport;
use App\Imports\CitizensImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class CitizenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Citizen::with('village');
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('occupation', 'like', "%{$search}%");
            });
        }
        
        // Filter by village
        if ($request->filled('village_id')) {
            $query->where('village_id', $request->village_id);
        }
        
        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'Aktif') {
                $query->where('is_active', true);
            } else {
                $query->where('is_active', false);
            }
        }
        
        // Filter by gender
        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }
        
        // Filter by marital status
        if ($request->filled('marital_status')) {
            $query->where('marital_status', $request->marital_status);
        }
        
        // Filter by religion
        if ($request->filled('religion')) {
            $query->where('religion', $request->religion);
        }
        
        // Filter by age range
        if ($request->filled('age_from') || $request->filled('age_to')) {
            $ageFrom = $request->age_from;
            $ageTo = $request->age_to;
            
            if ($ageFrom) {
                $dateFrom = now()->subYears($ageFrom)->format('Y-m-d');
                $query->where('birth_date', '<=', $dateFrom);
            }
            
            if ($ageTo) {
                $dateTo = now()->subYears($ageTo)->format('Y-m-d');
                $query->where('birth_date', '>=', $dateTo);
            }
        }
        
        // Sorting
        $sortBy = $request->get('sort_by', 'name');
        $sortOrder = $request->get('sort_order', 'asc');
        $query->orderBy($sortBy, $sortOrder);
        
        $citizens = $query->paginate(15)->withQueryString();
        $villages = Village::all();
        
        // Statistics for dashboard
        $stats = [
            'total' => Citizen::count(),
            'male' => Citizen::where('gender', 'L')->count(),
            'female' => Citizen::where('gender', 'P')->count(),
            'active' => Citizen::where('is_active', true)->count(),
            'inactive' => Citizen::where('is_active', false)->count(),
        ];
        
        return view('admin.citizens.index', compact('citizens', 'villages', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $villages = Village::all();
        return view('admin.citizens.create', compact('villages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nik' => 'required|string|size:16|unique:citizens,nik',
            'name' => 'required|string|max:255',
            'birth_place' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'gender' => 'required|in:L,P',
            'address' => 'required|string',
            'village_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'occupation' => 'nullable|string|max:255',
            'marital_status' => 'required|in:Belum Kawin,Kawin,Cerai Hidup,Cerai Mati',
            'religion' => 'required|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu',
            'education' => 'nullable|string|max:255',
            'is_active' => 'required|boolean'
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        // Handle village creation or find existing
        $village = Village::firstOrCreate(
            ['name' => $request->village_name],
            [
                'name' => $request->village_name,
                'code' => 'V' . str_pad(Village::count() + 1, 3, '0', STR_PAD_LEFT)
            ]
        );
        
        // Prepare data for citizen creation
        $citizenData = $request->except('village_name');
        $citizenData['village_id'] = $village->id;
        
        $citizen = Citizen::create($citizenData);
        
        // Log activity
        ActivityLog::log(
            'citizen_created',
            "Menambahkan data penduduk: {$citizen->name} (NIK: {$citizen->nik})",
            $citizen,
            ['village' => $citizen->village->name ?? 'Unknown']
        );
        
        return redirect()->route('admin.citizens.index')
                        ->with('success', 'Data penduduk berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Citizen $citizen)
    {
        $citizen->load('village');
        return view('admin.citizens.show', compact('citizen'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Citizen $citizen)
    {
        $villages = Village::all();
        return view('admin.citizens.edit', compact('citizen', 'villages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Citizen $citizen)
    {
        $validator = Validator::make($request->all(), [
            'nik' => 'required|string|size:16|unique:citizens,nik,' . $citizen->id,
            'name' => 'required|string|max:255',
            'birth_place' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'gender' => 'required|in:L,P',
            'address' => 'required|string',
            'village_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'occupation' => 'nullable|string|max:255',
            'marital_status' => 'required|in:Belum Kawin,Kawin,Cerai Hidup,Cerai Mati',
            'religion' => 'required|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu',
            'education' => 'nullable|string|max:255',
            'is_active' => 'required|boolean'
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        $oldData = $citizen->only(['name', 'nik', 'status']);
        
        // Handle village creation or find existing
        $village = Village::firstOrCreate(
            ['name' => $request->village_name],
            [
                'name' => $request->village_name,
                'code' => 'V' . str_pad(Village::count() + 1, 3, '0', STR_PAD_LEFT)
            ]
        );
        
        // Prepare data for citizen update
        $citizenData = $request->except('village_name');
        $citizenData['village_id'] = $village->id;
        
        $citizen->update($citizenData);
        
        // Log activity
        ActivityLog::log(
            'citizen_updated',
            "Memperbarui data penduduk: {$citizen->name} (NIK: {$citizen->nik})",
            $citizen,
            ['old_data' => $oldData, 'new_data' => $citizen->only(['name', 'nik', 'status'])]
        );
        
        return redirect()->route('admin.citizens.index')
                        ->with('success', 'Data penduduk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Citizen $citizen)
    {
        // Log activity before deletion
        ActivityLog::log(
            'citizen_deleted',
            "Menghapus data penduduk: {$citizen->name} (NIK: {$citizen->nik})",
            null,
            ['deleted_citizen' => $citizen->only(['name', 'nik', 'village_id'])]
        );
        
        $citizen->delete();
        
        return redirect()->route('admin.citizens.index')
                        ->with('success', 'Data penduduk berhasil dihapus.');
    }

    /**
     * Export citizens data to Excel
     */
    public function export(Request $request)
    {
        $filters = $request->only(['search', 'village_id', 'status']);
        
        return Excel::download(
            new CitizensExport($filters), 
            'data-penduduk-' . date('Y-m-d') . '.xlsx'
        );
    }

    /**
     * Import citizens data from Excel
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048'
        ]);

        try {
            $import = new CitizensImport();
            Excel::import($import, $request->file('file'));
            
            $failures = $import->failures();
            $errors = $import->errors();
            
            if (count($failures) > 0 || count($errors) > 0) {
                $errorMessages = [];
                
                foreach ($failures as $failure) {
                    $errorMessages[] = "Baris {$failure->row()}: " . implode(', ', $failure->errors());
                }
                
                foreach ($errors as $error) {
                    $errorMessages[] = $error->getMessage();
                }
                
                return redirect()->back()
                    ->with('error', 'Import gagal: ' . implode(' | ', $errorMessages));
            }
            
            // Log activity
            ActivityLog::log(
                'citizens_imported',
                "Mengimpor data penduduk dari file Excel: {$request->file('file')->getClientOriginalName()}",
                null,
                ['file_name' => $request->file('file')->getClientOriginalName()]
            );
            
            return redirect()->route('admin.citizens.index')
                ->with('success', 'Data penduduk berhasil diimport.');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Import gagal: ' . $e->getMessage());
        }
    }

    /**
     * Download template for import
     */
    public function downloadTemplate()
    {
        $headers = [
            'NIK',
            'Nama', 
            'Tempat Lahir',
            'Tanggal Lahir',
            'Jenis Kelamin',
            'Alamat',
            'Desa',
            'Telepon',
            'Email',
            'Pekerjaan',
            'Status Perkawinan',
            'Agama',
            'Pendidikan',
            'Status'
        ];
        
        $sampleData = [
            [
                '1234567890123456',
                'John Doe',
                'Jakarta',
                '1990-01-01',
                'Laki-laki',
                'Jl. Contoh No. 123',
                'Desa Contoh',
                '081234567890',
                'john@example.com',
                'Pegawai Swasta',
                'Belum Kawin',
                'Islam',
                'S1',
                'Aktif'
            ]
        ];
        
        $data = array_merge([$headers], $sampleData);
        
        $callback = function() use ($data) {
            $file = fopen('php://output', 'w');
            foreach ($data as $row) {
                fputcsv($file, $row);
            }
            fclose($file);
        };
        
        return response()->stream($callback, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="template-import-penduduk.csv"'
        ]);
    }
}
