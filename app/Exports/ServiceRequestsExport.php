<?php

namespace App\Exports;

use App\Models\ServiceRequest;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ServiceRequestsExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = ServiceRequest::with(['citizen.village', 'processedBy', 'approvedBy']);
        
        // Apply filters
        if (isset($this->filters['search']) && $this->filters['search']) {
            $search = $this->filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('request_number', 'like', "%{$search}%")
                  ->orWhere('service_type', 'like', "%{$search}%")
                  ->orWhereHas('citizen', function($citizenQuery) use ($search) {
                      $citizenQuery->where('name', 'like', "%{$search}%")
                                   ->orWhere('nik', 'like', "%{$search}%");
                  });
            });
        }
        
        if (isset($this->filters['status']) && $this->filters['status']) {
            $query->where('status', $this->filters['status']);
        }
        
        if (isset($this->filters['service_type']) && $this->filters['service_type']) {
            $query->where('service_type', $this->filters['service_type']);
        }
        
        if (isset($this->filters['priority']) && $this->filters['priority']) {
            $query->where('priority', $this->filters['priority']);
        }
        
        return $query->orderBy('created_at', 'desc')->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'No. Permintaan',
            'Nama Pemohon',
            'NIK',
            'Desa',
            'Jenis Layanan',
            'Keperluan',
            'Status',
            'Prioritas',
            'Tanggal Permintaan',
            'Diproses Oleh',
            'Disetujui Oleh',
            'Tanggal Diproses',
            'Tanggal Disetujui',
            'Tanggal Selesai',
            'Biaya',
            'Catatan'
        ];
    }

    /**
     * @param mixed $serviceRequest
     * @return array
     */
    public function map($serviceRequest): array
    {
        return [
            $serviceRequest->request_number,
            $serviceRequest->citizen->name,
            $serviceRequest->citizen->nik,
            $serviceRequest->citizen->village->name ?? '-',
            $serviceRequest->service_type,
            $serviceRequest->purpose,
            $this->getStatusLabel($serviceRequest->status),
            $this->getPriorityLabel($serviceRequest->priority),
            $serviceRequest->requested_at ? $serviceRequest->requested_at->format('d/m/Y H:i') : '-',
            $serviceRequest->processedBy->name ?? '-',
            $serviceRequest->approvedBy->name ?? '-',
            $serviceRequest->processed_at ? $serviceRequest->processed_at->format('d/m/Y H:i') : '-',
            $serviceRequest->approved_at ? $serviceRequest->approved_at->format('d/m/Y H:i') : '-',
            $serviceRequest->completed_at ? $serviceRequest->completed_at->format('d/m/Y H:i') : '-',
            'Rp ' . number_format($serviceRequest->fee_amount, 0, ',', '.'),
            $serviceRequest->notes ?? '-'
        ];
    }

    /**
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1 => [
                'font' => ['bold' => true, 'size' => 12],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4F46E5']
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                    ],
                ],
            ],
        ];
    }

    /**
     * Get status label in Indonesian
     */
    private function getStatusLabel($status)
    {
        $labels = [
            'draft' => 'Draft',
            'pending' => 'Menunggu',
            'processing' => 'Diproses',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan'
        ];
        
        return $labels[$status] ?? $status;
    }

    /**
     * Get priority label in Indonesian
     */
    private function getPriorityLabel($priority)
    {
        $labels = [
            'low' => 'Rendah',
            'normal' => 'Normal',
            'high' => 'Tinggi',
            'urgent' => 'Mendesak'
        ];
        
        return $labels[$priority] ?? $priority;
    }
}