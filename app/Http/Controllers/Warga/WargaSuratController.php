<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\Surat;
use App\Models\User;
use App\Models\Notification;
use App\Models\ServiceRequest;
use App\Models\Citizen;
use App\Helpers\NotificationHelper;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class WargaSuratController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Get dashboard statistics
        $stats = $this->getDashboardStats();
        
        // Get recent surat for activities
        $recentSurat = Surat::with('processor')
                           ->where('nik_pemohon', $user->nik)
                           ->orderBy('created_at', 'desc')
                           ->limit(5)
                           ->get();
        
        return view('warga.surat.index', compact('stats', 'recentSurat'));
    }
    
    /**
     * Display surat list with filters
     */
    public function list(Request $request)
    {
        $user = Auth::user();
        $query = Surat::with('processor')
                     ->where('nik_pemohon', $user->nik);
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nomor_surat', 'like', "%{$search}%")
                  ->orWhere('keperluan', 'like', "%{$search}%")
                  ->orWhere('jenis_surat', 'like', "%{$search}%");
            });
        }
        
        // Filter by jenis surat
        if ($request->filled('jenis_surat')) {
            $query->where('jenis_surat', $request->jenis_surat);
        }
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter by date range
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        
        $surat = $query->orderBy('created_at', 'desc')->paginate(10);
        
        return view('warga.surat.list', compact('surat'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $jenisSurat = $request->get('jenis_surat');
        return view('warga.surat.create', compact('jenisSurat'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nik' => 'required|string|size:16|regex:/^[0-9]{16}$/',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'birth_place' => 'required|string|max:255',
            'birth_date' => 'required|date',
            'gender' => 'required|in:L,P',
            'religion' => 'required|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu',
            'marital_status' => 'required|in:Belum Kawin,Kawin,Cerai Hidup,Cerai Mati',
            'occupation' => 'nullable|string|max:255',
            'rt' => 'nullable|string|max:3',
            'rw' => 'nullable|string|max:3',
            'address' => 'required|string|max:1000',
            'service_type' => 'required|string|max:255',
            'purpose' => 'required|string|max:1000',
            'notes' => 'nullable|string|max:1000',
            'uploaded_files.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);
        
        // Use service_type directly as it comes from the form
        $serviceType = $validated['service_type'];
        
        try {
            DB::beginTransaction();
            
            // Handle multiple file uploads if exists
            $documentPaths = [];
            if ($request->hasFile('uploaded_files')) {
                foreach ($request->file('uploaded_files') as $file) {
                    $fileName = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
                    $documentPath = $file->storeAs('documents/service-requests', $fileName, 'public');
                    $documentPaths[] = $documentPath;
                }
            }
            
            // Check if citizen exists, if not create new one
            $citizen = Citizen::where('nik', $validated['nik'])->first();
            
            if (!$citizen) {
                $citizen = Citizen::create([
                    'nik' => $validated['nik'],
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'phone' => $validated['phone'],
                    'birth_place' => $validated['birth_place'],
                    'birth_date' => $validated['birth_date'],
                    'gender' => $validated['gender'],
                    'religion' => $validated['religion'],
                    'marital_status' => $validated['marital_status'],
                    'occupation' => $validated['occupation'],
                    'rt' => $validated['rt'],
                    'rw' => $validated['rw'],
                    'address' => $validated['address'],
                    'is_active' => true
                ]);
            } else {
                // Update citizen data if exists
                $citizen->update([
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'phone' => $validated['phone'],
                    'birth_place' => $validated['birth_place'],
                    'birth_date' => $validated['birth_date'],
                    'gender' => $validated['gender'],
                    'religion' => $validated['religion'],
                    'marital_status' => $validated['marital_status'],
                    'occupation' => $validated['occupation'],
                    'rt' => $validated['rt'],
                    'rw' => $validated['rw'],
                    'address' => $validated['address']
                ]);
            }
            
            // Create service request
            $serviceRequest = ServiceRequest::create([
                'citizen_id' => $citizen->id,
                'service_type' => $serviceType,
                'purpose' => $validated['purpose'],
                'notes' => $validated['notes'],
                'document_path' => !empty($documentPaths) ? json_encode($documentPaths) : null,
                'priority' => 'normal',
                'status' => 'pending',
                'requested_at' => now()
            ]);
            
            // Create notification for all staff using NotificationService
            $this->notificationService->createNewServiceRequestNotification($serviceRequest);
            
            DB::commit();
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => "Pengajuan surat berhasil dibuat dengan nomor: {$serviceRequest->request_number}",
                    'data' => [
                        'request_number' => $serviceRequest->request_number,
                        'service_type' => $serviceRequest->service_type,
                        'status' => $serviceRequest->status
                    ]
                ]);
            }
            
            return redirect()->route('warga.dashboard')
                            ->with('success', "Pengajuan surat berhasil dibuat dengan nomor: {$serviceRequest->request_number}. Silakan pantau status pengajuan Anda di dashboard.");
                            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to create warga service request', [
                'error' => $e->getMessage(),
                'user_id' => $user->id,
                'data' => $validated
            ]);
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat mengajukan surat. Silakan coba lagi.'
                ], 500);
            }
            
            return redirect()->back()
                           ->with('error', 'Terjadi kesalahan saat mengajukan surat. Silakan coba lagi.')
                           ->withInput();
        }
    }
    


    /**
     * Display the specified resource.
     */
    public function show(Surat $surat)
    {
        $user = Auth::user();
        
        // Ensure user can only view their own surat
        if ($surat->nik_pemohon !== $user->nik) {
            abort(403, 'Anda tidak memiliki akses untuk melihat surat ini.');
        }
        
        $surat->load('processor');
        return view('warga.surat.show', compact('surat'));
    }

    /**
     * Download surat file
     */
    public function download(Surat $surat)
    {
        $user = Auth::user();
        
        // Ensure user can only download their own surat
        if ($surat->nik_pemohon !== $user->nik) {
            abort(403, 'Anda tidak memiliki akses untuk mengunduh surat ini.');
        }
        
        if (!$surat->file_surat || !Storage::disk('public')->exists($surat->file_surat)) {
            return redirect()->back()->with('error', 'File surat tidak ditemukan atau belum tersedia.');
        }
        
        return Storage::disk('public')->download($surat->file_surat, $surat->nomor_surat . '.pdf');
    }

    /**
     * Generate nomor surat
     */
    private function generateNomorSurat($jenisSurat)
    {
        $prefix = match($jenisSurat) {
            'Domisili' => 'DOM',
            'SKTM' => 'SKTM',
            'Usaha' => 'USH',
            'Pengantar' => 'PNG',
            'Kematian' => 'KMT',
            'Kelahiran' => 'KLH',
            'Pindah' => 'PND',
            default => 'SRT'
        };
        
        $year = date('Y');
        $month = date('m');
        
        // Get last number for this month and year
        $lastSurat = Surat::where('nomor_surat', 'like', "{$prefix}/{$month}/{$year}/%")
                          ->orderBy('nomor_surat', 'desc')
                          ->first();
        
        $number = 1;
        if ($lastSurat) {
            $parts = explode('/', $lastSurat->nomor_surat);
            $number = (int)end($parts) + 1;
        }
        
        return sprintf('%s/%s/%s/%04d', $prefix, $month, $year, $number);
    }

    /**
     * Export surat to PDF
     */
    public function exportPdf(Surat $surat)
    {
        // Check if user owns this surat
        if ($surat->nik_pemohon !== Auth::user()->nik) {
            abort(403, 'Unauthorized access to this surat.');
        }

        $pdf = PDF::loadView('warga.surat.pdf', compact('surat'));
        return $pdf->download('surat-' . $surat->nomor_surat . '.pdf');
    }

    /**
     * Get dashboard statistics for warga
     */
    public function getDashboardStats()
    {
        $user = Auth::user();
        
        $stats = [
            'total' => Surat::where('nik_pemohon', $user->nik)->count(),
            'pending' => Surat::where('nik_pemohon', $user->nik)->where('status', 'Pending')->count(),
            'diproses' => Surat::where('nik_pemohon', $user->nik)->where('status', 'Diproses')->count(),
            'selesai' => Surat::where('nik_pemohon', $user->nik)->where('status', 'Selesai')->count(),
            'ditolak' => Surat::where('nik_pemohon', $user->nik)->where('status', 'Ditolak')->count(),
        ];
        
        return $stats;
    }
}