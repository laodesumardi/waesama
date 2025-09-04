<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Penduduk;
use App\Models\Surat;
use App\Models\Antrian;
use App\Models\Berita;
use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // Get filter parameters
        $startDate = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->format('Y-m-d'));
        $type = $request->get('type', 'overview');
        
        // Convert to Carbon instances
        $start = Carbon::parse($startDate)->startOfDay();
        $end = Carbon::parse($endDate)->endOfDay();
        
        $data = [];
        
        switch ($type) {
            case 'overview':
                $data = $this->getOverviewData($start, $end);
                break;
            case 'penduduk':
                $data = $this->getPendudukData($start, $end);
                break;
            case 'surat':
                $data = $this->getSuratData($start, $end);
                break;
            case 'antrian':
                $data = $this->getAntrianData($start, $end);
                break;
            case 'pengaduan':
                $data = $this->getPengaduanData($start, $end);
                break;
            case 'berita':
                $data = $this->getBeritaData($start, $end);
                break;
            case 'user':
                $data = $this->getUserData($start, $end);
                break;
        }
        
        return view('admin.laporan.index', compact('data', 'startDate', 'endDate', 'type'));
    }
    
    private function getOverviewData($start, $end)
    {
        return [
            'total_penduduk' => Penduduk::count(),
            'total_users' => User::count(),
            'total_berita' => Berita::count(),
            
            // Surat statistics
            'surat_total' => Surat::whereBetween('created_at', [$start, $end])->count(),
            'surat_pending' => Surat::whereBetween('created_at', [$start, $end])->where('status', 'pending')->count(),
            'surat_processing' => Surat::whereBetween('created_at', [$start, $end])->where('status', 'processing')->count(),
            'surat_completed' => Surat::whereBetween('created_at', [$start, $end])->where('status', 'completed')->count(),
            
            // Antrian statistics
            'antrian_total' => Antrian::whereBetween('created_at', [$start, $end])->count(),
            'antrian_waiting' => Antrian::whereBetween('created_at', [$start, $end])->where('status', 'waiting')->count(),
            'antrian_called' => Antrian::whereBetween('created_at', [$start, $end])->where('status', 'called')->count(),
            'antrian_served' => Antrian::whereBetween('created_at', [$start, $end])->where('status', 'served')->count(),
            'antrian_completed' => Antrian::whereBetween('created_at', [$start, $end])->where('status', 'completed')->count(),
            
            // Pengaduan statistics
            'pengaduan_total' => Pengaduan::whereBetween('created_at', [$start, $end])->count(),
            'pengaduan_pending' => Pengaduan::whereBetween('created_at', [$start, $end])->where('status', 'pending')->count(),
            'pengaduan_processing' => Pengaduan::whereBetween('created_at', [$start, $end])->where('status', 'processing')->count(),
            'pengaduan_completed' => Pengaduan::whereBetween('created_at', [$start, $end])->where('status', 'completed')->count(),
            'pengaduan_rejected' => Pengaduan::whereBetween('created_at', [$start, $end])->where('status', 'rejected')->count(),
            
            // Daily statistics for charts
            'daily_surat' => $this->getDailyStats(Surat::class, $start, $end),
            'daily_antrian' => $this->getDailyStats(Antrian::class, $start, $end),
            'daily_pengaduan' => $this->getDailyStats(Pengaduan::class, $start, $end),
        ];
    }
    
    private function getPendudukData($start, $end)
    {
        $totalPopulation = Penduduk::count();
        $ageGroups = $this->getPendudukByAgeGroup();
        
        // Calculate age groups with percentages
        $ageGroupsWithPercentage = $ageGroups->map(function($group) use ($totalPopulation) {
            $percentage = $totalPopulation > 0 ? ($group->total / $totalPopulation) * 100 : 0;
            return [
                'label' => $group->age_group,
                'count' => $group->total,
                'percentage' => round($percentage, 1)
            ];
        });
        
        // Calculate gender by age groups
        $genderByAge = $this->getGenderByAgeGroup();
        
        // Calculate daily registrations for chart
        $dailyRegistrations = $this->getDailyStats(Penduduk::class, $start, $end)
            ->map(function($item) {
                return [
                    'date' => $item->date,
                    'count' => $item->total
                ];
            });
        
        return [
            'total' => $totalPopulation,
            'total_population' => $totalPopulation,
            'male_count' => Penduduk::where('jenis_kelamin', 'L')->count(),
            'female_count' => Penduduk::where('jenis_kelamin', 'P')->count(),
            'new_registrations' => Penduduk::whereBetween('created_at', [$start, $end])->count(),
            'by_gender' => Penduduk::select('jenis_kelamin', DB::raw('count(*) as total'))
                ->groupBy('jenis_kelamin')
                ->get(),
            'by_age_group' => $this->getPendudukByAgeGroup(),
            'age_groups' => $ageGroupsWithPercentage,
            'gender_by_age' => $genderByAge,
            'daily_registrations' => $dailyRegistrations,
            'by_status' => Penduduk::select('status_perkawinan', DB::raw('count(*) as total'))
                ->groupBy('status_perkawinan')
                ->get(),
            'by_education' => Penduduk::select('pendidikan', DB::raw('count(*) as total'))
                ->groupBy('pendidikan')
                ->get(),
            'by_occupation' => Penduduk::select('pekerjaan', DB::raw('count(*) as total'))
                ->groupBy('pekerjaan')
                ->get(),
        ];
    }
    
    private function getSuratData($start, $end)
    {
        return [
            'total' => Surat::whereBetween('created_at', [$start, $end])->count(),
            'by_status' => Surat::whereBetween('created_at', [$start, $end])
                ->select('status', DB::raw('count(*) as total'))
                ->groupBy('status')
                ->get(),
            'by_type' => Surat::whereBetween('created_at', [$start, $end])
                ->select('jenis_surat', DB::raw('count(*) as total'))
                ->groupBy('jenis_surat')
                ->get(),
            'by_month' => Surat::whereBetween('created_at', [$start, $end])
                ->select(DB::raw('MONTH(created_at) as month'), DB::raw('count(*) as total'))
                ->groupBy(DB::raw('MONTH(created_at)'))
                ->orderBy('month')
                ->get(),
            'processing_time' => $this->getSuratProcessingTime($start, $end),
            'recent' => Surat::whereBetween('created_at', [$start, $end])
                ->with(['penduduk', 'processedBy'])
                ->latest()
                ->take(10)
                ->get(),
        ];
    }
    
    private function getAntrianData($start, $end)
    {
        return [
            'total' => Antrian::whereBetween('created_at', [$start, $end])->count(),
            'by_status' => Antrian::whereBetween('created_at', [$start, $end])
                ->select('status', DB::raw('count(*) as total'))
                ->groupBy('status')
                ->get(),
            'by_service' => Antrian::whereBetween('created_at', [$start, $end])
                ->select('layanan', DB::raw('count(*) as total'))
                ->groupBy('layanan')
                ->get(),
            'by_month' => Antrian::whereBetween('created_at', [$start, $end])
                ->select(DB::raw('MONTH(created_at) as month'), DB::raw('count(*) as total'))
                ->groupBy(DB::raw('MONTH(created_at)'))
                ->orderBy('month')
                ->get(),
            'average_waiting_time' => $this->getAverageWaitingTime($start, $end),
            'peak_hours' => $this->getPeakHours($start, $end),
            'recent' => Antrian::whereBetween('created_at', [$start, $end])
                ->with(['penduduk', 'servedBy'])
                ->latest()
                ->take(10)
                ->get(),
        ];
    }
    
    private function getPengaduanData($start, $end)
    {
        return [
            'total' => Pengaduan::whereBetween('created_at', [$start, $end])->count(),
            'by_status' => Pengaduan::whereBetween('created_at', [$start, $end])
                ->select('status', DB::raw('count(*) as total'))
                ->groupBy('status')
                ->get(),
            'by_category' => Pengaduan::whereBetween('created_at', [$start, $end])
                ->select('kategori', DB::raw('count(*) as total'))
                ->groupBy('kategori')
                ->get(),
            'by_priority' => Pengaduan::whereBetween('created_at', [$start, $end])
                ->select('prioritas', DB::raw('count(*) as total'))
                ->groupBy('prioritas')
                ->get(),
            'by_month' => Pengaduan::whereBetween('created_at', [$start, $end])
                ->select(DB::raw('MONTH(created_at) as month'), DB::raw('count(*) as total'))
                ->groupBy(DB::raw('MONTH(created_at)'))
                ->orderBy('month')
                ->get(),
            'response_time' => $this->getPengaduanResponseTime($start, $end),
            'recent' => Pengaduan::whereBetween('created_at', [$start, $end])
                ->with(['handledBy'])
                ->latest()
                ->take(10)
                ->get(),
        ];
    }
    
    private function getBeritaData($start, $end)
    {
        return [
            'total' => Berita::whereBetween('created_at', [$start, $end])->count(),
            'published' => Berita::whereBetween('created_at', [$start, $end])->where('is_published', true)->count(),
            'draft' => Berita::whereBetween('created_at', [$start, $end])->where('is_published', false)->count(),
            'by_author' => Berita::whereBetween('created_at', [$start, $end])
                ->with('author')
                ->select('author_id', DB::raw('count(*) as total'))
                ->groupBy('author_id')
                ->get(),
            'by_month' => Berita::whereBetween('created_at', [$start, $end])
                ->select(DB::raw('MONTH(created_at) as month'), DB::raw('count(*) as total'))
                ->groupBy(DB::raw('MONTH(created_at)'))
                ->orderBy('month')
                ->get(),
            'recent' => Berita::whereBetween('created_at', [$start, $end])
                ->with('author')
                ->latest()
                ->take(10)
                ->get(),
        ];
    }
    
    private function getUserData($start, $end)
    {
        return [
            'total' => User::count(),
            'new_users' => User::whereBetween('created_at', [$start, $end])->count(),
            'active_users' => User::where('is_active', true)->count(),
            'inactive_users' => User::where('is_active', false)->count(),
            'by_role' => User::with('role')
                ->select('role_id', DB::raw('count(*) as total'))
                ->groupBy('role_id')
                ->get(),
            'by_month' => User::whereBetween('created_at', [$start, $end])
                ->select(DB::raw('MONTH(created_at) as month'), DB::raw('count(*) as total'))
                ->groupBy(DB::raw('MONTH(created_at)'))
                ->orderBy('month')
                ->get(),
            'recent' => User::whereBetween('created_at', [$start, $end])
                ->with('role')
                ->latest()
                ->take(10)
                ->get(),
        ];
    }
    
    private function getDailyStats($model, $start, $end)
    {
        return $model::whereBetween('created_at', [$start, $end])
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get();
    }
    
    private function getPendudukByAgeGroup()
    {
        $ageGroups = [
            '0-17' => [0, 17],
            '18-30' => [18, 30],
            '31-45' => [31, 45],
            '46-60' => [46, 60],
            '60+' => [61, 150]
        ];
        
        $result = [];
        foreach ($ageGroups as $group => $range) {
            $count = Penduduk::whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN ? AND ?', $range)
                ->count();
            $result[] = (object) ['age_group' => $group, 'total' => $count];
        }
        
        return collect($result);
    }
    
    private function getGenderByAgeGroup()
    {
        $ageGroups = [
            '0-17' => [0, 17],
            '18-30' => [18, 30],
            '31-45' => [31, 45],
            '46-60' => [46, 60],
            '60+' => [61, 150]
        ];
        
        $result = [];
        foreach ($ageGroups as $group => $range) {
            $male = Penduduk::whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN ? AND ?', $range)
                ->where('jenis_kelamin', 'L')
                ->count();
            $female = Penduduk::whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN ? AND ?', $range)
                ->where('jenis_kelamin', 'P')
                ->count();
            $total = $male + $female;
            
            $malePercentage = $total > 0 ? ($male / $total) * 100 : 0;
            $femalePercentage = $total > 0 ? ($female / $total) * 100 : 0;
            
            $result[] = [
                'label' => $group,
                'male' => $male,
                'female' => $female,
                'total' => $total,
                'male_percentage' => round($malePercentage, 1),
                'female_percentage' => round($femalePercentage, 1)
            ];
        }
        
        return collect($result);
    }
    
    private function getSuratProcessingTime($start, $end)
    {
        $completed = Surat::whereBetween('created_at', [$start, $end])
            ->where('status', 'completed')
            ->whereNotNull('processed_at')
            ->get();
            
        if ($completed->isEmpty()) {
            return ['average' => 0, 'min' => 0, 'max' => 0];
        }
        
        $times = $completed->map(function ($surat) {
            return $surat->created_at->diffInHours($surat->processed_at);
        });
        
        return [
            'average' => round($times->avg(), 2),
            'min' => $times->min(),
            'max' => $times->max()
        ];
    }
    
    private function getAverageWaitingTime($start, $end)
    {
        $served = Antrian::whereBetween('created_at', [$start, $end])
            ->whereIn('status', ['served', 'completed'])
            ->whereNotNull('called_at')
            ->get();
            
        if ($served->isEmpty()) {
            return 0;
        }
        
        $times = $served->map(function ($antrian) {
            return $antrian->created_at->diffInMinutes($antrian->called_at);
        });
        
        return round($times->avg(), 2);
    }
    
    private function getPeakHours($start, $end)
    {
        return Antrian::whereBetween('created_at', [$start, $end])
            ->select(DB::raw('HOUR(created_at) as hour'), DB::raw('count(*) as total'))
            ->groupBy(DB::raw('HOUR(created_at)'))
            ->orderBy('total', 'desc')
            ->take(5)
            ->get();
    }
    
    private function getPengaduanResponseTime($start, $end)
    {
        $responded = Pengaduan::whereBetween('created_at', [$start, $end])
            ->whereNotNull('tanggapan')
            ->whereNotNull('updated_at')
            ->get();
            
        if ($responded->isEmpty()) {
            return ['average' => 0, 'min' => 0, 'max' => 0];
        }
        
        $times = $responded->map(function ($pengaduan) {
            return $pengaduan->created_at->diffInHours($pengaduan->updated_at);
        });
        
        return [
            'average' => round($times->avg(), 2),
            'min' => $times->min(),
            'max' => $times->max()
        ];
    }
    
    public function export(Request $request)
    {
        $type = $request->get('type', 'overview');
        $format = $request->get('format', 'pdf');
        $startDate = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->format('Y-m-d'));
        
        // Get data based on type
        $start = Carbon::parse($startDate)->startOfDay();
        $end = Carbon::parse($endDate)->endOfDay();
        
        switch ($type) {
            case 'overview':
                $data = $this->getOverviewData($start, $end);
                break;
            case 'penduduk':
                $data = $this->getPendudukData($start, $end);
                break;
            case 'surat':
                $data = $this->getSuratData($start, $end);
                break;
            case 'antrian':
                $data = $this->getAntrianData($start, $end);
                break;
            case 'pengaduan':
                $data = $this->getPengaduanData($start, $end);
                break;
            case 'berita':
                $data = $this->getBeritaData($start, $end);
                break;
            case 'user':
                $data = $this->getUserData($start, $end);
                break;
            default:
                $data = $this->getOverviewData($start, $end);
        }
        
        if ($format === 'pdf') {
            return $this->exportToPdf($data, $type, $startDate, $endDate);
        } else {
            return $this->exportToExcel($data, $type, $startDate, $endDate);
        }
    }
    
    private function exportToPdf($data, $type, $startDate, $endDate)
    {
        // Generate PDF
        $pdf = Pdf::loadView('pdf.laporan', [
            'data' => $data,
            'type' => $type,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'generatedAt' => now()
        ]);
        $pdf->setPaper('A4', 'portrait');
        
        // Generate filename
        $filename = 'laporan-' . $type . '-' . $startDate . '-to-' . $endDate . '-' . now()->format('Y-m-d') . '.pdf';
        
        // Return PDF for download
        return $pdf->download($filename);
    }
    
    private function exportToExcel($data, $type, $startDate, $endDate)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Set document properties
        $spreadsheet->getProperties()
            ->setCreator('Kantor Camat Waesama')
            ->setTitle('Laporan ' . ucfirst($type))
            ->setSubject('Laporan periode ' . $startDate . ' sampai ' . $endDate)
            ->setDescription('Laporan data ' . $type . ' Kantor Camat Waesama');
        
        // Set header style
        $headerStyle = [
            'font' => ['bold' => true, 'size' => 12],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '4F46E5']],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
        ];
        
        $dataStyle = [
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT]
        ];
        
        // Set title
        $sheet->setCellValue('A1', 'LAPORAN ' . strtoupper($type));
        $sheet->mergeCells('A1:D1');
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 16],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
        ]);
        
        $sheet->setCellValue('A2', 'Periode: ' . $startDate . ' sampai ' . $endDate);
        $sheet->mergeCells('A2:D2');
        $sheet->getStyle('A2')->applyFromArray([
            'font' => ['size' => 12],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
        ]);
        
        $row = 4;
        
        if ($type === 'overview') {
            // Overview data
            $sheet->setCellValue('A' . $row, 'Kategori');
            $sheet->setCellValue('B' . $row, 'Total');
            $sheet->setCellValue('C' . $row, 'Pending');
            $sheet->setCellValue('D' . $row, 'Completed');
            $sheet->getStyle('A' . $row . ':D' . $row)->applyFromArray($headerStyle);
            $row++;
            
            // Add overview data
            $overviewData = [
                ['Penduduk', $data['total_penduduk'], '-', '-'],
                ['Users', $data['total_users'], '-', '-'],
                ['Berita', $data['total_berita'], '-', '-'],
                ['Surat', $data['surat_total'], $data['surat_pending'], $data['surat_completed']],
                ['Antrian', $data['antrian_total'], $data['antrian_waiting'], $data['antrian_completed']],
                ['Pengaduan', $data['pengaduan_total'], $data['pengaduan_pending'], $data['pengaduan_completed']]
            ];
            
            foreach ($overviewData as $rowData) {
                $sheet->setCellValue('A' . $row, $rowData[0]);
                $sheet->setCellValue('B' . $row, $rowData[1]);
                $sheet->setCellValue('C' . $row, $rowData[2]);
                $sheet->setCellValue('D' . $row, $rowData[3]);
                $sheet->getStyle('A' . $row . ':D' . $row)->applyFromArray($dataStyle);
                $row++;
            }
        } else {
            // For specific data types, create appropriate columns
            switch ($type) {
                case 'surat':
                    $sheet->setCellValue('A' . $row, 'No');
                    $sheet->setCellValue('B' . $row, 'Jenis Surat');
                    $sheet->setCellValue('C' . $row, 'Pemohon');
                    $sheet->setCellValue('D' . $row, 'Status');
                    $sheet->setCellValue('E' . $row, 'Tanggal');
                    break;
                case 'antrian':
                    $sheet->setCellValue('A' . $row, 'No');
                    $sheet->setCellValue('B' . $row, 'Nomor Antrian');
                    $sheet->setCellValue('C' . $row, 'Nama');
                    $sheet->setCellValue('D' . $row, 'Status');
                    $sheet->setCellValue('E' . $row, 'Tanggal');
                    break;
                case 'pengaduan':
                    $sheet->setCellValue('A' . $row, 'No');
                    $sheet->setCellValue('B' . $row, 'Judul');
                    $sheet->setCellValue('C' . $row, 'Pelapor');
                    $sheet->setCellValue('D' . $row, 'Status');
                    $sheet->setCellValue('E' . $row, 'Tanggal');
                    break;
                default:
                    $sheet->setCellValue('A' . $row, 'Data');
                    $sheet->setCellValue('B' . $row, 'Jumlah');
            }
            
            $sheet->getStyle('A' . $row . ':E' . $row)->applyFromArray($headerStyle);
            $row++;
            
            // Add summary data for specific types
            if (isset($data['items']) && is_array($data['items'])) {
                foreach ($data['items'] as $index => $item) {
                    $sheet->setCellValue('A' . $row, $index + 1);
                    // Add item data based on type
                    $row++;
                }
            } else {
                // If no detailed items, show summary
                $sheet->setCellValue('A' . $row, 'Total ' . ucfirst($type));
                $sheet->setCellValue('B' . $row, $data[$type . '_total'] ?? 'N/A');
                $sheet->getStyle('A' . $row . ':B' . $row)->applyFromArray($dataStyle);
            }
        }
        
        // Auto-size columns
        foreach (range('A', 'E') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        
        // Generate filename
        $filename = 'laporan-' . $type . '-' . $startDate . '-to-' . $endDate . '-' . now()->format('Y-m-d') . '.xlsx';
        
        // Create writer and save to temporary file
        $writer = new Xlsx($spreadsheet);
        $tempFile = tempnam(sys_get_temp_dir(), 'excel_export');
        $writer->save($tempFile);
        
        // Return file download response
        return response()->download($tempFile, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ])->deleteFileAfterSend(true);
    }
}