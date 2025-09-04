<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class ServiceRequestException extends Exception
{
    protected $context;
    
    public function __construct($message = "", $code = 0, Exception $previous = null, array $context = [])
    {
        parent::__construct($message, $code, $previous);
        $this->context = $context;
    }
    
    /**
     * Report the exception.
     */
    public function report(): void
    {
        Log::error('Service Request Exception: ' . $this->getMessage(), [
            'exception' => get_class($this),
            'file' => $this->getFile(),
            'line' => $this->getLine(),
            'trace' => $this->getTraceAsString(),
            'context' => $this->context
        ]);
    }
    
    /**
     * Render the exception as an HTTP response.
     */
    public function render(Request $request): Response
    {
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => $this->getMessage(),
                'error_code' => $this->getCode(),
                'context' => config('app.debug') ? $this->context : null
            ], $this->getStatusCode());
        }
        
        return redirect()->back()
            ->with('error', $this->getMessage())
            ->withInput();
    }
    
    /**
     * Get the HTTP status code for this exception.
     */
    protected function getStatusCode(): int
    {
        return match($this->getCode()) {
            400 => 400, // Bad Request
            401 => 401, // Unauthorized
            403 => 403, // Forbidden
            404 => 404, // Not Found
            422 => 422, // Unprocessable Entity
            default => 500 // Internal Server Error
        };
    }
    
    /**
     * Create a validation exception.
     */
    public static function validation(string $message, array $context = []): self
    {
        return new self($message, 422, null, $context);
    }
    
    /**
     * Create an authorization exception.
     */
    public static function unauthorized(string $message = 'Unauthorized access', array $context = []): self
    {
        return new self($message, 403, null, $context);
    }
    
    /**
     * Create a not found exception.
     */
    public static function notFound(string $message = 'Service request not found', array $context = []): self
    {
        return new self($message, 404, null, $context);
    }
    
    /**
     * Create a status transition exception.
     */
    public static function invalidStatusTransition(string $from, string $to, array $context = []): self
    {
        return new self(
            "Invalid status transition from '{$from}' to '{$to}'",
            400,
            null,
            array_merge($context, ['from_status' => $from, 'to_status' => $to])
        );
    }
    
    /**
     * Create a database operation exception.
     */
    public static function databaseError(string $operation, Exception $previous = null, array $context = []): self
    {
        return new self(
            "Database error during {$operation}",
            500,
            $previous,
            array_merge($context, ['operation' => $operation])
        );
    }
}