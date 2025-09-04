<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStatusRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->hasRole('admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $serviceRequest = $this->route('service_request');
        $currentStatus = $serviceRequest ? $serviceRequest->status : null;
        
        return [
            'status' => [
                'required',
                'string',
                Rule::in(['pending', 'processing', 'completed', 'rejected']),
                function ($attribute, $value, $fail) use ($currentStatus) {
                    // Validate status transitions
                    $validTransitions = [
                        'pending' => ['processing', 'rejected'],
                        'processing' => ['completed', 'rejected'],
                        'completed' => [], // Cannot change from completed
                        'rejected' => ['pending'] // Can reopen rejected requests
                    ];
                    
                    if ($currentStatus && isset($validTransitions[$currentStatus])) {
                        if (!in_array($value, $validTransitions[$currentStatus])) {
                            $fail('Perubahan status dari ' . $currentStatus . ' ke ' . $value . ' tidak diizinkan.');
                        }
                    }
                }
            ],
            'reason' => [
                'required_if:status,rejected',
                'nullable',
                'string',
                'min:10',
                'max:1000',
                function ($attribute, $value, $fail) {
                    if ($this->input('status') === 'rejected' && (!$value || str_word_count($value) < 3)) {
                        $fail('Alasan penolakan harus berisi minimal 3 kata.');
                    }
                }
            ],
            'admin_notes' => [
                'nullable',
                'string',
                'max:2000'
            ],
            'estimated_completion' => [
                'nullable',
                'date',
                'after:today',
                'before:' . now()->addMonths(3)->format('Y-m-d'),
                'required_if:status,processing'
            ],
            'fee_amount' => [
                'nullable',
                'numeric',
                'min:0',
                'max:10000000'
            ],
            'notify_citizen' => [
                'boolean'
            ]
        ];
    }

    /**
     * Get custom error messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'status.required' => 'Status harus dipilih.',
            'status.in' => 'Status yang dipilih tidak valid.',
            'reason.required_if' => 'Alasan penolakan harus diisi.',
            'reason.min' => 'Alasan penolakan minimal 10 karakter.',
            'reason.max' => 'Alasan penolakan maksimal 1000 karakter.',
            'admin_notes.max' => 'Catatan admin maksimal 2000 karakter.',
            'estimated_completion.required_if' => 'Perkiraan selesai harus diisi untuk status processing.',
            'estimated_completion.after' => 'Perkiraan selesai harus setelah hari ini.',
            'estimated_completion.before' => 'Perkiraan selesai maksimal 3 bulan ke depan.',
            'fee_amount.numeric' => 'Biaya harus berupa angka.',
            'fee_amount.min' => 'Biaya tidak boleh negatif.',
            'fee_amount.max' => 'Biaya maksimal Rp 10.000.000.'
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'status' => 'status',
            'reason' => 'alasan penolakan',
            'admin_notes' => 'catatan admin',
            'estimated_completion' => 'perkiraan selesai',
            'fee_amount' => 'biaya',
            'notify_citizen' => 'notifikasi warga'
        ];
    }

    /**
     * Handle a failed authorization attempt.
     */
    protected function failedAuthorization()
    {
        throw new \Illuminate\Http\Exceptions\HttpResponseException(
            redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengubah status permohonan.')
        );
    }

    /**
     * Handle a failed validation attempt.
     */
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        if ($this->expectsJson()) {
            throw new \Illuminate\Http\Exceptions\HttpResponseException(
                response()->json([
                    'success' => false,
                    'message' => 'Data yang dikirim tidak valid.',
                    'errors' => $validator->errors()
                ], 422)
            );
        }

        parent::failedValidation($validator);
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        // Set default value for notify_citizen if not provided
        if (!$this->has('notify_citizen')) {
            $this->merge([
                'notify_citizen' => true
            ]);
        }
    }
}