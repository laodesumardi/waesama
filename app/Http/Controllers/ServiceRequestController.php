<?php

namespace App\Http\Controllers;

use App\Models\ServiceRequest;
use App\Models\Citizen;
use App\Models\Notification;
use App\Models\User;
use App\Exports\ServiceRequestsExport;
use App\Http\Requests\StoreServiceRequestRequest;
use App\Http\Requests\UpdateServiceRequestRequest;
use App\Http\Requests\UpdateStatusRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Traits\HandlesServiceRequestExceptions;
use App\Exceptions\ServiceRequestException;
use App\Services\NotificationService;

class ServiceRequestController extends Controller
{
    use HandlesServiceRequestExceptions;
    
    protected $notificationService;
    
    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
        $this->middleware(['auth', 'role:admin,pegawai']);
        $this->middleware('service.request.validation')->only(['store', 'update', 'updateStatus']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ServiceRequest::with(['citizen', 'processedBy', 'approvedBy']);
        
        // Filter berdasarkan pencarian
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('request_number', 'like', "%{$search}%")
                  ->orWhere('service_type', 'like', "%{$search}%")
                  ->orWhereHas('citizen', function($citizenQuery) use ($search) {
                      $citizenQuery->where('name', 'like', "%{$search}%")
                                   ->orWhere('nik', 'like', "%{$search}%");
                  });
            });
        }
        
        // Filter berdasarkan status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }
        
        // Filter berdasarkan jenis layanan
        if ($request->has('service_type') && $request->service_type) {
            $query->where('service_type', $request->service_type);
        }
        
        // Filter berdasarkan prioritas
        if ($request->has('priority') && $request->priority) {
            $query->where('priority', $request->priority);
        }
        
        $serviceRequests = $query->orderBy('created_at', 'desc')->paginate(10);
        // $availableTemplates = Document::getAvailableTemplates(); // Disabled - Document model not available
        $availableTemplates = [];
        
        return view('admin.service-requests.index', compact('serviceRequests', 'availableTemplates'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $citizens = Citizen::active()->orderBy('name')->get();
        // $availableTemplates = Document::getAvailableTemplates(); // Disabled - Document model not available
        $availableTemplates = [];
        
        // Jika ada citizen_id dari parameter, pre-select citizen
        $selectedCitizen = null;
        if ($request->has('citizen_id')) {
            $selectedCitizen = Citizen::find($request->citizen_id);
        }
        
        return view('admin.service-requests.create', compact('citizens', 'availableTemplates', 'selectedCitizen'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreServiceRequestRequest $request)
    {
        try {
            DB::beginTransaction();
            
            // Get validated data
            $validatedData = $request->validated();
            
            // Prepare service request data
            $serviceRequestData = [
                'citizen_id' => $validatedData['citizen_id'],
                'service_type' => $validatedData['service_type'],
                'purpose' => $validatedData['purpose'],
                'priority' => $validatedData['priority'],
                'notes' => $validatedData['notes'] ?? null,
                'fee_amount' => $validatedData['fee_amount'] ?? null,
                'required_date' => $validatedData['required_date'] ?? null,
                'status' => 'pending',
                'requested_at' => now(),
                'created_by' => auth()->id()
            ];
            
            // Handle template variables if provided
            if (isset($validatedData['template_variables'])) {
                $serviceRequestData['template_variables'] = json_encode($validatedData['template_variables']);
            }
            
            $serviceRequest = ServiceRequest::create($serviceRequestData);
            
            // Create notification for new request to all staff
            $this->notificationService->createNewServiceRequestNotification($serviceRequest);
            
            // Log the creation
            Log::info('Service request created', [
                'service_request_id' => $serviceRequest->id,
                'citizen_id' => $serviceRequest->citizen_id,
                'service_type' => $serviceRequest->service_type,
                'created_by' => auth()->id()
            ]);
            
            DB::commit();
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Permohonan layanan berhasil dibuat.',
                    'data' => $serviceRequest->load('citizen')
                ], 201);
            }
            
            return redirect()->route('admin.service-requests.show', $serviceRequest)
                           ->with('success', 'Permohonan layanan berhasil dibuat.');
                           
        } catch (\App\Exceptions\ServiceRequestException $e) {
            DB::rollback();
            return $this->handleServiceRequestException($e, $request, 'admin.service-requests.index');
        } catch (\Exception $e) {
            DB::rollback();
            return $this->handleGeneralException($e, $request, 'creation', 'admin.service-requests.index');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ServiceRequest $serviceRequest)
    {
        $serviceRequest->load(['citizen.village', 'processedBy', 'approvedBy']); // Removed 'documents.generatedBy' - Document model not available
        // $availableTemplates = Document::getAvailableTemplates(); // Disabled - Document model not available
        $availableTemplates = [];
        
        return view('admin.service-requests.show', compact('serviceRequest', 'availableTemplates'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ServiceRequest $serviceRequest)
    {
        try {
            // Hanya bisa edit jika status masih pending atau processing
            if (!in_array($serviceRequest->status, ['pending', 'processing'])) {
                throw ServiceRequestException::invalidStatusTransition(
                    $serviceRequest->status, 
                    'edit', 
                    'Permohonan dengan status ' . $serviceRequest->status . ' tidak dapat diedit.'
                );
            }
            
            $citizens = Citizen::active()->orderBy('name')->get();
            // $availableTemplates = Document::getAvailableTemplates(); // Disabled - Document model not available
            $availableTemplates = [];
            
            return view('admin.service-requests.edit', compact('serviceRequest', 'citizens', 'availableTemplates'));
        } catch (ServiceRequestException $e) {
            return redirect()->route('admin.service-requests.show', $serviceRequest)
                           ->with('error', $e->getMessage());
        } catch (\Exception $e) {
            return redirect()->route('admin.service-requests.index')
                           ->with('error', 'Terjadi kesalahan saat mengakses halaman edit.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateServiceRequestRequest $request, ServiceRequest $serviceRequest)
    {
        // Authorization is handled in the request class
        
        try {
            DB::beginTransaction();
            
            // Get validated data
            $validatedData = $request->validated();
            
            // Store original data for logging
            $originalData = $serviceRequest->toArray();
            
            // Prepare update data
            $updateData = [
                'citizen_id' => $validatedData['citizen_id'],
                'service_type' => $validatedData['service_type'],
                'purpose' => $validatedData['purpose'],
                'priority' => $validatedData['priority'],
                'notes' => $validatedData['notes'] ?? null,
                'fee_amount' => $validatedData['fee_amount'] ?? null,
                'required_date' => $validatedData['required_date'] ?? null,
                'updated_by' => auth()->id()
            ];
            
            $serviceRequest->update($updateData);
            
            // Log the update
            Log::info('Service request updated', [
                'service_request_id' => $serviceRequest->id,
                'original_data' => $originalData,
                'updated_data' => $updateData,
                'updated_by' => auth()->id()
            ]);
            
            DB::commit();
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Permohonan layanan berhasil diperbarui.',
                    'data' => $serviceRequest->fresh()->load('citizen')
                ]);
            }
            
            return redirect()->route('admin.service-requests.show', $serviceRequest)
                           ->with('success', 'Permohonan layanan berhasil diperbarui.');
                           
        } catch (\App\Exceptions\ServiceRequestException $e) {
            DB::rollback();
            return $this->handleServiceRequestException($e, $request, 'admin.service-requests.show');
        } catch (\Exception $e) {
            DB::rollback();
            return $this->handleGeneralException($e, $request, 'update', 'admin.service-requests.show');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServiceRequest $serviceRequest)
    {
        // Hanya bisa hapus jika status draft atau pending
        if (!in_array($serviceRequest->status, ['draft', 'pending'])) {
            throw ServiceRequestException::invalidStatusTransition(
                $serviceRequest->status, 
                'deleted', 
                'Permohonan dengan status ' . $serviceRequest->status . ' tidak dapat dihapus.'
            );
        }
        
        try {
            DB::beginTransaction();
            
            // Hapus dokumen terkait jika ada (disabled - Document model not available)
            // foreach ($serviceRequest->documents as $document) {
            //     $document->deleteFile();
            //     $document->delete();
            // }
            
            $serviceRequest->delete();
            
            DB::commit();
            
            return redirect()->route('admin.service-requests.index')
                           ->with('success', 'Permohonan layanan berhasil dihapus.');
                           
        } catch (ServiceRequestException $e) {
            DB::rollback();
            return redirect()->route('admin.service-requests.index')
                           ->with('error', $e->getMessage());
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('admin.service-requests.index')
                           ->with('error', 'Terjadi kesalahan saat menghapus permohonan: ' . $e->getMessage());
        }
    }

    /**
     * Process the service request
     */
    public function process(ServiceRequest $serviceRequest)
    {
        if (!$serviceRequest->canBeProcessed()) {
            throw ServiceRequestException::invalidStatusTransition(
                $serviceRequest->status, 
                'processing', 
                'Permohonan tidak dapat diproses.'
            );
        }
        
        try {
            $serviceRequest->markAsProcessing();
            
            return redirect()->back()
                           ->with('success', 'Permohonan berhasil diproses.');
        } catch (ServiceRequestException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses permohonan.');
        }
    }

    /**
     * Approve the service request
     */
    public function approve(ServiceRequest $serviceRequest)
    {
        if (!$serviceRequest->canBeApproved()) {
            throw ServiceRequestException::invalidStatusTransition(
                $serviceRequest->status, 
                'approved', 
                'Permohonan tidak dapat disetujui.'
            );
        }
        
        try {
            $serviceRequest->markAsApproved();
            
            return redirect()->back()
                           ->with('success', 'Permohonan berhasil disetujui.');
        } catch (ServiceRequestException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyetujui permohonan.');
        }
    }

    /**
     * Reject the service request
     */
    public function reject(Request $request, ServiceRequest $serviceRequest)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500'
        ]);
        
        if (!$serviceRequest->canBeRejected()) {
            throw ServiceRequestException::invalidStatusTransition(
                $serviceRequest->status, 
                'rejected', 
                'Permohonan tidak dapat ditolak.'
            );
        }
        
        try {
            $serviceRequest->markAsRejected($request->rejection_reason);
            
            return redirect()->back()
                           ->with('success', 'Permohonan berhasil ditolak.');
        } catch (ServiceRequestException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menolak permohonan.');
        }
    }

    /**
     * Complete the service request
     */
    public function complete(ServiceRequest $serviceRequest)
    {
        if ($serviceRequest->status !== 'approved') {
            throw ServiceRequestException::invalidStatusTransition(
                $serviceRequest->status, 
                'completed', 
                'Hanya permohonan yang sudah disetujui yang dapat diselesaikan.'
            );
        }
        
        try {
            $serviceRequest->markAsCompleted();
            
            return redirect()->back()
                           ->with('success', 'Permohonan berhasil diselesaikan.');
        } catch (ServiceRequestException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyelesaikan permohonan.');
        }
    }

    /**
     * Export service requests data to Excel
     */
    public function export(Request $request)
    {
        $filters = $request->only(['search', 'status', 'service_type', 'priority']);
        
        return Excel::download(
            new ServiceRequestsExport($filters), 
            'data-permintaan-layanan-' . date('Y-m-d') . '.xlsx'
        );
    }

    /**
     * Bulk approve service requests
     */
    public function bulkApprove(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:service_requests,id'
        ]);

        try {
            $updated = 0;
            foreach ($request->ids as $id) {
                $serviceRequest = ServiceRequest::find($id);
                if ($serviceRequest && $serviceRequest->canBeApproved()) {
                    $serviceRequest->markAsApproved();
                    $updated++;
                }
            }

            return redirect()->back()
                           ->with('success', "Berhasil menyetujui {$updated} permintaan layanan.");
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Terjadi kesalahan saat memproses permintaan: ' . $e->getMessage());
        }
    }

    /**
     * Bulk process service requests
     */
    public function bulkProcess(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:service_requests,id'
        ]);

        try {
            $updated = 0;
            foreach ($request->ids as $id) {
                $serviceRequest = ServiceRequest::find($id);
                if ($serviceRequest && $serviceRequest->canBeProcessed()) {
                    $serviceRequest->markAsProcessing();
                    $updated++;
                }
            }

            return redirect()->back()
                           ->with('success', "Berhasil memproses {$updated} permintaan layanan.");
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Terjadi kesalahan saat memproses permintaan: ' . $e->getMessage());
        }
    }

    /**
     * Bulk reject service requests
     */
    public function bulkReject(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:service_requests,id',
            'reason' => 'required|string|max:500'
        ]);

        try {
            $updated = 0;
            foreach ($request->ids as $id) {
                $serviceRequest = ServiceRequest::find($id);
                if ($serviceRequest && $serviceRequest->canBeRejected()) {
                    $serviceRequest->markAsRejected($request->reason);
                    $updated++;
                }
            }

            return redirect()->back()
                           ->with('success', "Berhasil menolak {$updated} permintaan layanan.");
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Terjadi kesalahan saat memproses permintaan: ' . $e->getMessage());
        }
    }

    /**
     * Bulk delete service requests
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:service_requests,id'
        ]);

        try {
            DB::beginTransaction();
            
            $deleted = 0;
            foreach ($request->ids as $id) {
                $serviceRequest = ServiceRequest::find($id);
                if ($serviceRequest && in_array($serviceRequest->status, ['draft', 'pending'])) {
                    // Hapus dokumen terkait jika ada (disabled - Document model not available)
                    // foreach ($serviceRequest->documents as $document) {
                    //     $document->deleteFile();
                    //     $document->delete();
                    // }
                    
                    $serviceRequest->delete();
                    $deleted++;
                }
            }
            
            DB::commit();

            return redirect()->back()
                           ->with('success', "Berhasil menghapus {$deleted} permintaan layanan.");
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                           ->with('error', 'Terjadi kesalahan saat menghapus permintaan: ' . $e->getMessage());
        }
    }

    public function updateStatus(UpdateStatusRequest $request, ServiceRequest $serviceRequest)
    {
        try {
            DB::beginTransaction();
            
            // Get validated data
            $validatedData = $request->validated();
            
            $oldStatus = $serviceRequest->status;
            $newStatus = $validatedData['status'];
            
            // Prepare update data
            $updateData = [
                'status' => $newStatus,
                'admin_notes' => $validatedData['admin_notes'] ?? null,
                'rejection_reason' => $newStatus === 'rejected' ? $validatedData['reason'] : null,
                'fee_amount' => $validatedData['fee_amount'] ?? $serviceRequest->fee_amount,
                'estimated_completion' => $validatedData['estimated_completion'] ?? null,
                'processed_by' => auth()->id(),
                'processed_at' => now()
            ];
            
            // Set completion date if status is completed
            if ($newStatus === 'completed') {
                $updateData['completed_at'] = now();
                $updateData['approved_by'] = auth()->id();
            }
            
            $serviceRequest->update($updateData);
            
            // Create notification for status change if requested
            if ($validatedData['notify_citizen'] ?? true) {
                $this->notificationService->createServiceRequestProcessNotification(
                    $serviceRequest, 
                    $oldStatus, 
                    $newStatus, 
                    auth()->user()
                );
            }
            
            // Log the status change
            Log::info('Service request status updated', [
                'service_request_id' => $serviceRequest->id,
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
                'updated_by' => auth()->id(),
                'reason' => $validatedData['reason'] ?? null,
                'admin_notes' => $validatedData['admin_notes'] ?? null
            ]);
            
            DB::commit();

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Status berhasil diubah.',
                    'data' => [
                        'old_status' => $oldStatus,
                        'new_status' => $newStatus,
                        'service_request' => $serviceRequest->fresh()->load('citizen')
                    ]
                ]);
            }

            return redirect()->route('admin.service-requests.index')
                            ->with('success', 'Status berhasil diubah dari ' . $oldStatus . ' menjadi ' . $newStatus . '.');
                            
        } catch (\App\Exceptions\ServiceRequestException $e) {
            DB::rollback();
            return $this->handleServiceRequestException($e, $request, 'admin.service-requests.index');
        } catch (\Exception $e) {
            DB::rollback();
            return $this->handleGeneralException($e, $request, 'status update', 'admin.service-requests.index');
        }
    }





    /**
     * Create notification for status change
     */
    private function createStatusChangeNotification(ServiceRequest $serviceRequest, $oldStatus, $newStatus)
    {
        $statusLabels = [
            'pending' => 'Menunggu',
            'processing' => 'Diproses',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            'completed' => 'Selesai'
        ];

        $priority = 'medium';
        if ($newStatus === 'approved' || $newStatus === 'completed') {
            $priority = 'high';
        } elseif ($newStatus === 'rejected') {
            $priority = 'high';
        }

        $title = "Status Permintaan Diperbarui";
        $message = "Permintaan #{$serviceRequest->request_number} telah diubah dari {$statusLabels[$oldStatus]} menjadi {$statusLabels[$newStatus]}";

        // Create notification for the citizen who made the request
        if ($serviceRequest->citizen_id) {
            Notification::create([
                'user_id' => $serviceRequest->citizen_id,
                'sender_id' => auth()->id(),
                'type' => 'status_change',
                'priority' => $priority,
                'title' => $title,
                'message' => $message,
                'data' => [
                    'service_request_id' => $serviceRequest->id,
                    'old_status' => $oldStatus,
                    'new_status' => $newStatus,
                    'request_number' => $serviceRequest->request_number
                ],
                'action_url' => route('citizen.service-requests.show', $serviceRequest->id)
            ]);
        }

        // Create notification for admins (except the one who made the change)
        $adminUsers = User::where('role', 'admin')
            ->where('id', '!=', auth()->id())
            ->get();

        foreach ($adminUsers as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'sender_id' => auth()->id(),
                'type' => 'status_change',
                'priority' => 'low',
                'title' => $title,
                'message' => $message,
                'data' => [
                    'service_request_id' => $serviceRequest->id,
                    'old_status' => $oldStatus,
                    'new_status' => $newStatus,
                    'request_number' => $serviceRequest->request_number
                ],
                'action_url' => route('admin.service-requests.show', $serviceRequest->id)
            ]);
        }
    }



    /**
     * Create notification for document generation
     */
    private function createDocumentNotification(ServiceRequest $serviceRequest, $documentTitle)
    {
        $title = "Dokumen Siap Diunduh";
        $message = "Dokumen '{$documentTitle}' untuk permintaan #{$serviceRequest->request_number} telah siap untuk diunduh";

        // Create notification for the citizen
        if ($serviceRequest->citizen_id) {
            Notification::create([
                'user_id' => $serviceRequest->citizen_id,
                'sender_id' => auth()->id(),
                'type' => 'document_ready',
                'priority' => 'high',
                'title' => $title,
                'message' => $message,
                'data' => [
                    'service_request_id' => $serviceRequest->id,
                    'request_number' => $serviceRequest->request_number,
                    'document_title' => $documentTitle
                ],
                'action_url' => route('citizen.service-requests.show', $serviceRequest->id)
            ]);
        }
    }
}
