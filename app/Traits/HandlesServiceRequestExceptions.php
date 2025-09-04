<?php

namespace App\Traits;

use App\Exceptions\ServiceRequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

trait HandlesServiceRequestExceptions
{
    /**
     * Handle ServiceRequestException and return appropriate response.
     */
    protected function handleServiceRequestException(ServiceRequestException $e, Request $request, string $defaultRedirect = 'admin.service-requests.index')
    {
        // Log the exception
        Log::error('Service Request Exception in ' . get_class($this), [
            'exception' => $e->getMessage(),
            'code' => $e->getCode(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'request_data' => $request->except(['_token', 'password'])
        ]);
        
        // Return JSON response for API requests
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'error_code' => $e->getCode()
            ], $this->getHttpStatusCode($e->getCode()));
        }
        
        // Return redirect response for web requests
        return redirect()->route($defaultRedirect)
            ->with('error', $e->getMessage())
            ->withInput();
    }
    
    /**
     * Handle general exceptions for service requests.
     */
    protected function handleGeneralException(\Exception $e, Request $request, string $operation = 'operation', string $defaultRedirect = 'admin.service-requests.index')
    {
        // Log the exception
        Log::error('General exception during service request ' . $operation, [
            'exception' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString(),
            'request_data' => $request->except(['_token', 'password'])
        ]);
        
        // Return JSON response for API requests
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem. Silakan coba lagi.',
                'error_code' => 500
            ], 500);
        }
        
        // Return redirect response for web requests
        return redirect()->route($defaultRedirect)
            ->with('error', 'Terjadi kesalahan sistem. Silakan coba lagi.')
            ->withInput();
    }
    
    /**
     * Get HTTP status code from exception code.
     */
    private function getHttpStatusCode(int $code): int
    {
        return match($code) {
            400 => 400, // Bad Request
            401 => 401, // Unauthorized
            403 => 403, // Forbidden
            404 => 404, // Not Found
            422 => 422, // Unprocessable Entity
            default => 500 // Internal Server Error
        };
    }
    
    /**
     * Create a standardized success response.
     */
    protected function successResponse(Request $request, string $message, array $data = [], string $redirectRoute = null)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => $data
            ]);
        }
        
        $redirect = $redirectRoute ? redirect()->route($redirectRoute) : redirect()->back();
        return $redirect->with('success', $message);
    }
    
    /**
     * Validate service request status transition.
     */
    protected function validateStatusTransition(string $currentStatus, string $newStatus): bool
    {
        $validTransitions = [
            'draft' => ['pending', 'cancelled'],
            'pending' => ['processing', 'approved', 'rejected', 'cancelled'],
            'processing' => ['completed', 'approved', 'rejected', 'on_hold'],
            'on_hold' => ['processing', 'rejected', 'cancelled'],
            'approved' => ['completed'],
            'completed' => [], // No transitions from completed
            'rejected' => [], // No transitions from rejected
            'cancelled' => [] // No transitions from cancelled
        ];
        
        return in_array($newStatus, $validTransitions[$currentStatus] ?? []);
    }
    
    /**
     * Check if user can modify service request.
     */
    protected function canModifyServiceRequest($serviceRequest, $user = null): bool
    {
        $user = $user ?? auth()->user();
        
        // Admin and pegawai can modify any request
        if ($user->hasAnyRole(['admin', 'pegawai'])) {
            return true;
        }
        
        // Citizens can only modify their own draft or pending requests
        if ($user->hasRole('warga')) {
            return $serviceRequest->citizen_id === $user->citizen_id &&
                   in_array($serviceRequest->status, ['draft', 'pending']);
        }
        
        return false;
    }
    
    /**
     * Check if user can view service request.
     */
    protected function canViewServiceRequest($serviceRequest, $user = null): bool
    {
        $user = $user ?? auth()->user();
        
        // Admin and pegawai can view any request
        if ($user->hasAnyRole(['admin', 'pegawai'])) {
            return true;
        }
        
        // Citizens can only view their own requests
        if ($user->hasRole('warga')) {
            return $serviceRequest->citizen_id === $user->citizen_id;
        }
        
        return false;
    }
}