<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use App\Exceptions\ServiceRequestException;
use App\Models\ServiceRequest;
use App\Models\Citizen;

class ServiceRequestValidation
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Skip validation for GET requests
        if ($request->isMethod('GET')) {
            return $next($request);
        }
        
        try {
            // Rate limiting for service request creation
            if ($request->routeIs('admin.service-requests.store')) {
                $this->checkRateLimit($request);
                $this->validateCitizenEligibility($request);
            }
            
            // Validate status transitions
            if ($request->routeIs('admin.service-requests.update-status')) {
                $this->validateStatusTransition($request);
            }
            
            // Validate business hours for urgent requests
            if ($request->input('priority') === 'urgent') {
                $this->validateBusinessHours($request);
            }
            
            return $next($request);
            
        } catch (ServiceRequestException $e) {
            throw $e;
        } catch (\Exception $e) {
            Log::error('Service request validation middleware error', [
                'error' => $e->getMessage(),
                'request_data' => $request->except(['_token', 'password'])
            ]);
            
            throw ServiceRequestException::validation(
                'Terjadi kesalahan validasi. Silakan coba lagi.',
                ['original_error' => $e->getMessage()]
            );
        }
    }
    
    /**
     * Check rate limiting for service request creation.
     */
    protected function checkRateLimit(Request $request): void
    {
        $citizenId = $request->input('citizen_id');
        $userId = auth()->id();
        
        if (!$citizenId || !$userId) {
            return;
        }
        
        // Rate limit: max 5 requests per citizen per day
        $citizenKey = "service_requests_citizen_{$citizenId}_" . now()->format('Y-m-d');
        $citizenCount = Cache::get($citizenKey, 0);
        
        if ($citizenCount >= 5) {
            throw ServiceRequestException::validation(
                'Batas maksimal 5 permohonan per hari untuk warga ini telah tercapai.',
                ['citizen_id' => $citizenId, 'daily_count' => $citizenCount]
            );
        }
        
        // Rate limit: max 20 requests per user per hour
        $userKey = "service_requests_user_{$userId}_" . now()->format('Y-m-d-H');
        $userCount = Cache::get($userKey, 0);
        
        if ($userCount >= 20) {
            throw ServiceRequestException::validation(
                'Batas maksimal 20 permohonan per jam telah tercapai. Silakan tunggu beberapa saat.',
                ['user_id' => $userId, 'hourly_count' => $userCount]
            );
        }
        
        // Increment counters
        Cache::put($citizenKey, $citizenCount + 1, now()->endOfDay());
        Cache::put($userKey, $userCount + 1, now()->endOfHour());
    }
    
    /**
     * Validate citizen eligibility for service requests.
     */
    protected function validateCitizenEligibility(Request $request): void
    {
        $citizenId = $request->input('citizen_id');
        
        if (!$citizenId) {
            return;
        }
        
        $citizen = Citizen::find($citizenId);
        
        if (!$citizen) {
            throw ServiceRequestException::notFound(
                'Data warga tidak ditemukan.',
                ['citizen_id' => $citizenId]
            );
        }
        
        if (!$citizen->is_active) {
            throw ServiceRequestException::validation(
                'Warga tidak aktif dan tidak dapat mengajukan permohonan.',
                ['citizen_id' => $citizenId, 'citizen_status' => 'inactive']
            );
        }
        
        // Check for pending requests of the same type
        $serviceType = $request->input('service_type');
        $pendingCount = ServiceRequest::where('citizen_id', $citizenId)
            ->where('service_type', $serviceType)
            ->whereIn('status', ['pending', 'processing'])
            ->count();
            
        if ($pendingCount > 0) {
            throw ServiceRequestException::validation(
                'Warga masih memiliki permohonan ' . $serviceType . ' yang sedang diproses.',
                [
                    'citizen_id' => $citizenId,
                    'service_type' => $serviceType,
                    'pending_count' => $pendingCount
                ]
            );
        }
    }
    
    /**
     * Validate status transitions.
     */
    protected function validateStatusTransition(Request $request): void
    {
        $serviceRequest = $request->route('service_request');
        $newStatus = $request->input('status');
        
        if (!$serviceRequest || !$newStatus) {
            return;
        }
        
        $currentStatus = $serviceRequest->status;
        
        // Define valid transitions
        $validTransitions = [
            'pending' => ['processing', 'rejected'],
            'processing' => ['completed', 'rejected'],
            'completed' => [], // Cannot change from completed
            'rejected' => ['pending'] // Can reopen rejected requests
        ];
        
        if (!isset($validTransitions[$currentStatus]) || 
            !in_array($newStatus, $validTransitions[$currentStatus])) {
            throw ServiceRequestException::invalidStatusTransition(
                $currentStatus,
                $newStatus,
                ['service_request_id' => $serviceRequest->id]
            );
        }
    }
    
    /**
     * Validate business hours for urgent requests.
     */
    protected function validateBusinessHours(Request $request): void
    {
        $now = now();
        $dayOfWeek = $now->dayOfWeek; // 0 = Sunday, 6 = Saturday
        $hour = $now->hour;
        
        // Business hours: Monday-Friday 8:00-16:00, Saturday 8:00-12:00
        $isBusinessDay = $dayOfWeek >= 1 && $dayOfWeek <= 6; // Monday to Saturday
        $isBusinessHour = false;
        
        if ($dayOfWeek >= 1 && $dayOfWeek <= 5) { // Monday to Friday
            $isBusinessHour = $hour >= 8 && $hour < 16;
        } elseif ($dayOfWeek === 6) { // Saturday
            $isBusinessHour = $hour >= 8 && $hour < 12;
        }
        
        if (!$isBusinessDay || !$isBusinessHour) {
            Log::warning('Urgent request submitted outside business hours', [
                'day_of_week' => $dayOfWeek,
                'hour' => $hour,
                'user_id' => auth()->id()
            ]);
            
            // Don't block, just log and add a note
            $request->merge([
                'notes' => ($request->input('notes') ?? '') . 
                    "\n[CATATAN SISTEM: Permohonan urgent diajukan di luar jam kerja pada " . 
                    $now->format('d/m/Y H:i') . "]"
            ]);
        }
    }
}