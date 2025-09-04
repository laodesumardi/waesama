<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreServiceRequestRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'citizen_id' => [
                'required',
                'integer',
                'exists:citizens,id',
                function ($attribute, $value, $fail) {
                    $citizen = \App\Models\Citizen::find($value);
                    if ($citizen && !$citizen->is_active) {
                        $fail('Warga yang dipilih tidak aktif.');
                    }
                }
            ],
            'service_type' => [
                'required',
                'string',
                'max:100',
                Rule::in([
                    'surat_domisili',
                    'surat_keterangan_tidak_mampu',
                    'surat_keterangan_usaha',
                    'surat_pengantar',
                    'surat_keterangan_kematian',
                    'surat_keterangan_kelahiran',
                    'surat_keterangan_pindah'
                ])
            ],
            'purpose' => [
                'required',
                'string',
                'min:10',
                'max:1000',
                function ($attribute, $value, $fail) {
                    if (str_word_count($value) < 3) {
                        $fail('Keperluan harus berisi minimal 3 kata.');
                    }
                }
            ],
            'priority' => [
                'required',
                Rule::in(['low', 'normal', 'high', 'urgent'])
            ],
            'notes' => [
                'nullable',
                'string',
                'max:2000'
            ],
            'template_variables' => [
                'nullable',
                'array',
                'max:20'
            ],
            'template_variables.*' => [
                'string',
                'max:500'
            ],
            'fee_amount' => [
                'nullable',
                'numeric',
                'min:0',
                'max:10000000'
            ],
            'required_date' => [
                'nullable',
                'date',
                'after:today',
                'before:' . now()->addMonths(6)->format('Y-m-d')
            ]
        ];
    }

    /**
     * Get custom error messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'citizen_id.required' => 'Warga pemohon harus dipilih.',
            'citizen_id.exists' => 'Warga yang dipilih tidak valid.',
            'service_type.required' => 'Jenis layanan harus dipilih.',
            'service_type.in' => 'Jenis layanan yang dipilih tidak valid.',
            'purpose.required' => 'Keperluan harus diisi.',
            'purpose.min' => 'Keperluan minimal 10 karakter.',
            'purpose.max' => 'Keperluan maksimal 1000 karakter.',
            'priority.required' => 'Prioritas harus dipilih.',
            'priority.in' => 'Prioritas yang dipilih tidak valid.',
            'notes.max' => 'Catatan maksimal 2000 karakter.',
            'fee_amount.numeric' => 'Biaya harus berupa angka.',
            'fee_amount.min' => 'Biaya tidak boleh negatif.',
            'fee_amount.max' => 'Biaya maksimal Rp 10.000.000.',
            'required_date.after' => 'Tanggal dibutuhkan harus setelah hari ini.',
            'required_date.before' => 'Tanggal dibutuhkan maksimal 6 bulan ke depan.',
            'template_variables.max' => 'Maksimal 20 variabel template.',
            'template_variables.*.max' => 'Setiap variabel template maksimal 500 karakter.'
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'citizen_id' => 'warga pemohon',
            'service_type' => 'jenis layanan',
            'purpose' => 'keperluan',
            'priority' => 'prioritas',
            'notes' => 'catatan',
            'fee_amount' => 'biaya',
            'required_date' => 'tanggal dibutuhkan',
            'template_variables' => 'variabel template'
        ];
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
}