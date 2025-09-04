<?php

namespace App\Exports;

use App\Models\Citizen;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CitizensExport implements FromCollection, WithHeadings, WithMapping, WithStyles
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
        $query = Citizen::with('village');
        
        // If specific IDs are provided, filter by them
        if (isset($this->filters['ids']) && is_array($this->filters['ids']) && count($this->filters['ids']) > 0) {
            return $query->whereIn('id', $this->filters['ids'])->get();
        }
        
        // Apply other filters
        if (isset($this->filters['search']) && $this->filters['search']) {
            $search = $this->filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }
        
        if (isset($this->filters['village_id']) && $this->filters['village_id']) {
            $query->where('village_id', $this->filters['village_id']);
        }
        
        if (isset($this->filters['status']) && $this->filters['status']) {
            if ($this->filters['status'] === 'Aktif') {
                $query->where('is_active', true);
            } else {
                $query->where('is_active', false);
            }
        }
        
        return $query->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'NIK',
            'Nama',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Jenis Kelamin',
            'Alamat',
            'Desa',
            'Telepon',
            'Email',
            'Pekerjaan',
            'Status Perkawinan',
            'Agama',
            'Pendidikan',
            'Status',
            'Tanggal Dibuat'
        ];
    }

    /**
     * @param mixed $citizen
     * @return array
     */
    public function map($citizen): array
    {
        return [
            $citizen->nik,
            $citizen->name,
            $citizen->birth_place,
            $citizen->birth_date,
            $citizen->gender == 'L' ? 'Laki-laki' : 'Perempuan',
            $citizen->address,
            $citizen->village->name,
            $citizen->phone,
            $citizen->email,
            $citizen->occupation,
            $citizen->marital_status,
            $citizen->religion,
            $citizen->education,
            $citizen->status,
            $citizen->created_at->format('Y-m-d H:i:s')
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
            1 => ['font' => ['bold' => true]],
        ];
    }
}