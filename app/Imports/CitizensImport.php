<?php

namespace App\Imports;

use App\Models\Citizen;
use App\Models\Village;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Illuminate\Validation\Rule;

class CitizensImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError, SkipsOnFailure
{
    use Importable, SkipsErrors, SkipsFailures;

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Find village by name
        $village = Village::where('name', $row['desa'])->first();
        
        if (!$village) {
            throw new \Exception("Desa '{$row['desa']}' tidak ditemukan.");
        }

        return new Citizen([
            'nik' => $row['nik'],
            'name' => $row['nama'],
            'birth_place' => $row['tempat_lahir'],
            'birth_date' => $this->transformDate($row['tanggal_lahir']),
            'gender' => $this->transformGender($row['jenis_kelamin']),
            'address' => $row['alamat'],
            'village_id' => $village->id,
            'phone' => $row['telepon'] ?? null,
            'email' => $row['email'] ?? null,
            'occupation' => $row['pekerjaan'] ?? null,
            'marital_status' => $row['status_perkawinan'],
            'religion' => $row['agama'],
            'education' => $row['pendidikan'] ?? null,
            'is_active' => $this->transformStatus($row['status'] ?? 'Aktif')
        ]);
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'nik' => [
                'required',
                'string',
                'size:16',
                Rule::unique('citizens', 'nik')
            ],
            'nama' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan,L,P',
            'alamat' => 'required|string',
            'desa' => 'required|string',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'pekerjaan' => 'nullable|string|max:255',
            'status_perkawinan' => 'required|in:Belum Kawin,Kawin,Cerai Hidup,Cerai Mati',
            'agama' => 'required|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu',
            'pendidikan' => 'nullable|string|max:255',
            'status' => 'nullable|in:Aktif,Pindah,Meninggal,Tidak Aktif'
        ];
    }

    /**
     * Transform date format
     */
    private function transformDate($date)
    {
        if (is_numeric($date)) {
            // Excel date format
            return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($date)->format('Y-m-d');
        }
        
        return date('Y-m-d', strtotime($date));
    }

    /**
     * Transform gender format
     */
    private function transformGender($gender)
    {
        if (in_array($gender, ['Laki-laki', 'laki-laki', 'LAKI-LAKI'])) {
            return 'L';
        }
        
        if (in_array($gender, ['Perempuan', 'perempuan', 'PEREMPUAN'])) {
            return 'P';
        }
        
        return $gender; // Return as is if already L or P
    }

    /**
     * Transform status format
     */
    private function transformStatus($status)
    {
        return in_array($status, ['Aktif', 'aktif', 'AKTIF']) ? true : false;
    }
}