<?php

namespace App\Http\Controllers;

use App\Models\ServiceRequest;
use App\Models\Citizen;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ServiceRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin,pegawai']);
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
        $availableTemplates = Document::getAvailableTemplates();
        
        return view('admin.service-requests.index', compact('serviceRequests', 'availableTemplates'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $citizens = Citizen::active()->orderBy('name')->get();
        $availableTemplates = Document::getAvailableTemplates();
        
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
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'citizen_id' => 'required|exists:citizens,id',
            'service_type' => 'required|string|max:100',
            'purpose' => 'required|string',
            'priority' => 'required|in:low,normal,high,urgent',
            'notes' => 'nullable|string',
            'template_variables' => 'nullable|array',
            'fee_amount' => 'nullable|numeric|min:0'
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }
        
        try {
            DB::beginTransaction();
            
            $serviceRequestData = $request->only([
                'citizen_id', 'service_type', 'purpose', 'priority', 'notes', 'fee_amount'
            ]);
            
            $serviceRequestData['status'] = 'pending';
            $serviceRequestData['requested_at'] = now();
            
            $serviceRequest = ServiceRequest::create($serviceRequestData);
            
            DB::commit();
            
            return redirect()->route('admin.service-requests.show', $serviceRequest)
                           ->with('success', 'Permohonan layanan berhasil dibuat.');
                           
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                           ->with('error', 'Terjadi kesalahan saat membuat permohonan: ' . $e->getMessage())
                           ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ServiceRequest $serviceRequest)
    {
        $serviceRequest->load(['citizen.village', 'processedBy', 'approvedBy', 'documents.generatedBy']);
        $availableTemplates = Document::getAvailableTemplates();
        
        return view('admin.service-requests.show', compact('serviceRequest', 'availableTemplates'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ServiceRequest $serviceRequest)
    {
        // Hanya bisa edit jika status masih pending atau processing
        if (!in_array($serviceRequest->status, ['pending', 'processing'])) {
            return redirect()->route('admin.service-requests.show', $serviceRequest)
                           ->with('error', 'Permohonan dengan status ' . $serviceRequest->status . ' tidak dapat diedit.');
        }
        
        $citizens = Citizen::active()->orderBy('name')->get();
        $availableTemplates = Document::getAvailableTemplates();
        
        return view('admin.service-requests.edit', compact('serviceRequest', 'citizens', 'availableTemplates'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ServiceRequest $serviceRequest)
    {
        // Hanya bisa update jika status masih pending atau processing
        if (!in_array($serviceRequest->status, ['pending', 'processing'])) {
            return redirect()->route('admin.service-requests.show', $serviceRequest)
                           ->with('error', 'Permohonan dengan status ' . $serviceRequest->status . ' tidak dapat diubah.');
        }
        
        $validator = Validator::make($request->all(), [
            'citizen_id' => 'required|exists:citizens,id',
            'service_type' => 'required|string|max:100',
            'purpose' => 'required|string',
            'priority' => 'required|in:low,normal,high,urgent',
            'notes' => 'nullable|string',
            'fee_amount' => 'nullable|numeric|min:0'
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }
        
        try {
            $updateData = $request->only([
                'citizen_id', 'service_type', 'purpose', 'priority', 'notes', 'fee_amount'
            ]);
            
            $serviceRequest->update($updateData);
            
            return redirect()->route('admin.service-requests.show', $serviceRequest)
                           ->with('success', 'Permohonan layanan berhasil diperbarui.');
                           
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Terjadi kesalahan saat memperbarui permohonan: ' . $e->getMessage())
                           ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ServiceRequest $serviceRequest)
    {
        // Hanya bisa hapus jika status draft atau pending
        if (!in_array($serviceRequest->status, ['draft', 'pending'])) {
            return redirect()->route('admin.service-requests.index')
                           ->with('error', 'Permohonan dengan status ' . $serviceRequest->status . ' tidak dapat dihapus.');
        }
        
        try {
            DB::beginTransaction();
            
            // Hapus dokumen terkait jika ada
            foreach ($serviceRequest->documents as $document) {
                $document->deleteFile();
                $document->delete();
            }
            
            $serviceRequest->delete();
            
            DB::commit();
            
            return redirect()->route('admin.service-requests.index')
                           ->with('success', 'Permohonan layanan berhasil dihapus.');
                           
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
            return redirect()->back()
                           ->with('error', 'Permohonan tidak dapat diproses.');
        }
        
        $serviceRequest->markAsProcessing();
        
        return redirect()->back()
                       ->with('success', 'Permohonan berhasil diproses.');
    }

    /**
     * Approve the service request
     */
    public function approve(ServiceRequest $serviceRequest)
    {
        if (!$serviceRequest->canBeApproved()) {
            return redirect()->back()
                           ->with('error', 'Permohonan tidak dapat disetujui.');
        }
        
        $serviceRequest->markAsApproved();
        
        return redirect()->back()
                       ->with('success', 'Permohonan berhasil disetujui.');
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
            return redirect()->back()
                           ->with('error', 'Permohonan tidak dapat ditolak.');
        }
        
        $serviceRequest->markAsRejected($request->rejection_reason);
        
        return redirect()->back()
                       ->with('success', 'Permohonan berhasil ditolak.');
    }

    /**
     * Complete the service request
     */
    public function complete(ServiceRequest $serviceRequest)
    {
        if ($serviceRequest->status !== 'approved') {
            return redirect()->back()
                           ->with('error', 'Hanya permohonan yang sudah disetujui yang dapat diselesaikan.');
        }
        
        $serviceRequest->markAsCompleted();
        
        return redirect()->back()
                       ->with('success', 'Permohonan berhasil diselesaikan.');
    }
}
