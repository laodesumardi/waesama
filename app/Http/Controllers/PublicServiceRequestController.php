<?php

namespace App\Http\Controllers;

use App\Models\ServiceRequest;
use App\Models\Citizen;
use App\Models\Notification;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PublicServiceRequestController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Store a newly created service request from public form.
     */
    public function store(Request $request)
    {
        // Handle both old form (layanan page) and new form (welcome page)
        $validationRules = [
            'nik' => 'required|string|size:16',
            'priority' => 'nullable|string|in:normal,high,urgent'
        ];
        
        // Check if it's from welcome page or layanan page
        if ($request->has('name')) {
            // Welcome page form (updated field names)
            $validationRules = array_merge($validationRules, [
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'required|string|max:20',
                'service_type' => 'required|string',
                'address' => 'required|string|max:500',
                'purpose' => 'required|string|max:1000',
                'birth_place' => 'nullable|string|max:255',
                'birth_date' => 'nullable|date',
                'gender' => 'nullable|string|in:L,P',
                'religion' => 'nullable|string|max:100',
                'marital_status' => 'nullable|string|max:100',
                'occupation' => 'nullable|string|max:255',
                'rt' => 'nullable|string|max:3',
                'rw' => 'nullable|string|max:3',
                'uploaded_files.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120'
            ]);
        } else {
            // Layanan page form
            $validationRules = array_merge($validationRules, [
                'service_type' => 'required|string|in:surat_keterangan_domisili,surat_keterangan_tidak_mampu,surat_keterangan_usaha,surat_pengantar_nikah,surat_keterangan_kelahiran,surat_keterangan_kematian,surat_keterangan_belum_menikah,surat_keterangan_ahli_waris,surat_rekomendasi',
                'name' => 'required|string|max:255',
                'phone' => 'required|string|max:20',
                'address' => 'required|string|max:500',
                'purpose' => 'required|string|max:1000'
            ]);
        }
        
        $validator = Validator::make($request->all(), $validationRules);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validasi gagal',
                    'errors' => $validator->errors()
                ], 422);
            }
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        try {
            DB::beginTransaction();

            $validated = $validator->validated();
            
            // Normalize data based on form type
            if ($request->has('name') && $request->has('email')) {
                // Welcome page form (updated field names)
                $name = $validated['name'];
                $phone = $validated['phone'];
                $address = $validated['address'];
                $purpose = $validated['purpose'];
                $serviceType = $validated['service_type'];
                $email = $validated['email'];
                $birthPlace = $validated['birth_place'] ?? 'Tidak Diketahui';
                $birthDate = $validated['birth_date'] ?? '1900-01-01';
                $gender = $validated['gender'] ?? 'L';
                $religion = $validated['religion'] ?? 'Tidak Diketahui';
                $maritalStatus = $validated['marital_status'] ?? 'Tidak Diketahui';
                $occupation = $validated['occupation'] ?? 'Tidak Diketahui';
                $rt = $validated['rt'] ?? null;
                $rw = $validated['rw'] ?? null;
            } else {
                // Layanan page form
                $name = $validated['name'];
                $phone = $validated['phone'];
                $address = $validated['address'];
                $purpose = $validated['purpose'];
                $serviceType = $validated['service_type'];
                $email = null;
                $birthPlace = 'Tidak Diketahui';
                $birthDate = '1900-01-01';
                $gender = 'L';
                $religion = 'Tidak Diketahui';
                $maritalStatus = 'Tidak Diketahui';
                $occupation = 'Tidak Diketahui';
                $rt = null;
                $rw = null;
            }

            // Check if citizen exists, if not create new one
            $citizen = Citizen::where('nik', $validated['nik'])->first();
            
            if (!$citizen) {
                $citizenData = [
                    'nik' => $validated['nik'],
                    'name' => $name,
                    'phone' => $phone,
                    'address' => $address,
                    'birth_date' => $birthDate,
                    'birth_place' => $birthPlace,
                    'gender' => $gender,
                    'religion' => $religion,
                    'marital_status' => $maritalStatus,
                    'occupation' => $occupation,
                    'rt' => $rt,
                    'rw' => $rw,
                    'is_active' => true
                ];
                
                if ($email) {
                    $citizenData['email'] = $email;
                }
                
                $citizen = Citizen::create($citizenData);
            } else {
                // Update citizen data if exists
                $updateData = [
                    'name' => $name,
                    'phone' => $phone,
                    'address' => $address,
                    'birth_place' => $birthPlace,
                    'birth_date' => $birthDate,
                    'gender' => $gender,
                    'religion' => $religion,
                    'marital_status' => $maritalStatus,
                    'occupation' => $occupation,
                    'rt' => $rt,
                    'rw' => $rw
                ];
                
                if ($email) {
                    $updateData['email'] = $email;
                }
                
                $citizen->update($updateData);
            }
            
            // Handle file uploads
            $documentPaths = [];
            $fileFieldName = $request->hasFile('uploaded_files') ? 'uploaded_files' : 'dokumen_pendukung';
            if ($request->hasFile($fileFieldName)) {
                foreach ($request->file($fileFieldName) as $file) {
                    $path = $file->store('service-requests', 'public');
                    $documentPaths[] = $path;
                }
            }

            // Create service request
            $serviceRequest = ServiceRequest::create([
                'citizen_id' => $citizen->id,
                'service_type' => $serviceType,
                'purpose' => $purpose,
                'priority' => $validated['priority'] ?? 'normal',
                'status' => 'pending',
                'requested_at' => now(),
                'documents' => !empty($documentPaths) ? json_encode($documentPaths) : null
            ]);

            // Create notifications for admin and camat users
            $this->createNewRequestNotification($serviceRequest);

            // Log the creation
            Log::info('Public service request created', [
                'service_request_id' => $serviceRequest->id,
                'citizen_id' => $citizen->id,
                'service_type' => $serviceRequest->service_type,
                'request_number' => $serviceRequest->request_number
            ]);

            DB::commit();
            
            $successMessage = "Permohonan surat berhasil diajukan dengan nomor: {$serviceRequest->request_number}. "
                . "Anda akan dihubungi melalui nomor HP yang terdaftar untuk proses selanjutnya.";
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => $successMessage,
                    'ticket_number' => $serviceRequest->request_number
                ]);
            }

            return redirect()->back()->with('success', $successMessage);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Failed to create public service request', [
                'error' => $e->getMessage(),
                'data' => $request->all()
            ]);
            
            $errorMessage = 'Terjadi kesalahan saat mengajukan permohonan. Silakan coba lagi.';
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $errorMessage
                ], 500);
            }

            return redirect()->back()
                           ->with('error', $errorMessage)
                           ->withInput();
        }
    }

    /**
     * Create notification for new service request
     */
    private function createNewRequestNotification(ServiceRequest $serviceRequest)
    {
        // Get admin and camat users (camat has role 'admin' based on UserSeeder)
        $adminUsers = User::where('role', 'admin')->get();
        $pegawaiUsers = User::where('role', 'pegawai')->get();
        
        $title = 'Pengajuan Surat Baru';
        $message = "Pengajuan surat baru dengan nomor {$serviceRequest->request_number} dari {$serviceRequest->citizen->name} untuk layanan {$serviceRequest->service_type}";
        
        $notificationData = [
            'service_request_id' => $serviceRequest->id,
            'request_number' => $serviceRequest->request_number,
            'citizen_name' => $serviceRequest->citizen->name,
            'service_type' => $serviceRequest->service_type,
            'priority' => $serviceRequest->priority,
            'requested_at' => $serviceRequest->requested_at->format('Y-m-d H:i:s')
        ];
        
        // Create notifications for admin users (including camat)
        foreach ($adminUsers as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'title' => $title,
                'message' => $message,
                'type' => 'service_request',
                'data' => json_encode($notificationData),
                'is_read' => false,
                'created_at' => now()
            ]);
        }
        
        // Create notifications for pegawai users
        foreach ($pegawaiUsers as $pegawai) {
            Notification::create([
                'user_id' => $pegawai->id,
                'title' => $title,
                'message' => $message,
                'type' => 'service_request',
                'data' => json_encode($notificationData),
                'is_read' => false,
                'created_at' => now()
            ]);
        }
    }
}