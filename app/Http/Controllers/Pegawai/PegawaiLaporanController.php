<?php

namespace App\Http\Controllers\Pegawai;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Penduduk;
use App\Models\Surat;
use App\Models\Antrian;
use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class PegawaiLaporanController extends Controller
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
            case 'surat':
                $data = $this->getSuratData($start, $end);
                break;
            case 'antrian':
                $data = $this->getAntrianData($start, $end);
                break;
            case 'pengaduan':
                $data = $this->getPengaduanData($start, $end);
                break;
        }
        
        return view('pegawai.laporan.index', compact('data', 'startDate', 'endDate', 'type'));
    }
    
    private function getOverviewData($start, $end)
    {
        $user = Auth::user();
        
        return [
            // My work statistics
            'my_surat_total' => Surat::where('diproses_oleh', $user->id)
                ->whereBetween('created_at', [$start, $end])->count(),
            'my_surat_pending' => Surat::where('diproses_oleh', $user->id)
                ->whereBetween('created_at', [$start, $end])
                ->where('status', 'Pending')->count(),
            'my_surat_processing' => Surat::where('diproses_oleh', $user->id)
                ->whereBetween('created_at', [$start, $end])
                ->where('status', 'Diproses')->count(),
            'my_surat_completed' => Surat::where('diproses_oleh', $user->id)
                ->whereBetween('created_at', [$start, $end])
                ->where('status', 'Selesai')->count(),
            
            // My antrian statistics
            'my_antrian_total' => Antrian::where('dilayani_oleh', $user->id)
                ->whereBetween('created_at', [$start, $end])->count(),
            'my_antrian_served' => Antrian::where('dilayani_oleh', $user->id)
                ->whereBetween('created_at', [$start, $end])
                ->where('status', 'Dilayani')->count(),
            'my_antrian_completed' => Antrian::where('dilayani_oleh', $user->id)
                ->whereBetween('created_at', [$start, $end])
                ->where('status', 'Selesai')->count(),
            
            // My pengaduan statistics
            'my_pengaduan_total' => Pengaduan::where('ditangani_oleh', $user->id)
                ->whereBetween('created_at', [$start, $end])->count(),
            'my_pengaduan_processing' => Pengaduan::where('ditangani_oleh', $user->id)
                ->whereBetween('created_at', [$start, $end])
                ->where('status', 'Diproses')->count(),
            'my_pengaduan_completed' => Pengaduan::where('ditangani_oleh', $user->id)
                ->whereBetween('created_at', [$start, $end])
                ->where('status', 'Selesai')->count(),
                
            // General statistics (read-only for pegawai)
            'total_penduduk' => Penduduk::count(),
            'surat_total' => Surat::whereBetween('created_at', [$start, $end])->count(),
            'antrian_total' => Antrian::whereBetween('created_at', [$start, $end])->count(),
            'pengaduan_total' => Pengaduan::whereBetween('created_at', [$start, $end])->count(),
        ];
    }
    
    private function getSuratData($start, $end)
    {
        $user = Auth::user();
        
        return [
            'my_surat' => Surat::where('diproses_oleh', $user->id)
                ->whereBetween('created_at', [$start, $end])
                ->with('pemohon')
                ->orderBy('created_at', 'desc')
                ->get(),
            'status_breakdown' => Surat::where('diproses_oleh', $user->id)
                ->whereBetween('created_at', [$start, $end])
                ->select('status', DB::raw('count(*) as total'))
                ->groupBy('status')
                ->get(),
            'jenis_breakdown' => Surat::where('diproses_oleh', $user->id)
                ->whereBetween('created_at', [$start, $end])
                ->select('jenis_surat', DB::raw('count(*) as total'))
                ->groupBy('jenis_surat')
                ->get(),
        ];
    }
    
    private function getAntrianData($start, $end)
    {
        $user = Auth::user();
        
        return [
            'my_antrian' => Antrian::where('dilayani_oleh', $user->id)
                ->whereBetween('created_at', [$start, $end])
                ->orderBy('created_at', 'desc')
                ->get(),
            'status_breakdown' => Antrian::where('dilayani_oleh', $user->id)
                ->whereBetween('created_at', [$start, $end])
                ->select('status', DB::raw('count(*) as total'))
                ->groupBy('status')
                ->get(),
            'layanan_breakdown' => Antrian::where('dilayani_oleh', $user->id)
                ->whereBetween('created_at', [$start, $end])
                ->select('jenis_layanan', DB::raw('count(*) as total'))
                ->groupBy('jenis_layanan')
                ->get(),
        ];
    }
    
    private function getPengaduanData($start, $end)
    {
        $user = Auth::user();
        
        return [
            'my_pengaduan' => Pengaduan::where('ditangani_oleh', $user->id)
                ->whereBetween('created_at', [$start, $end])
                ->orderBy('created_at', 'desc')
                ->get(),
            'status_breakdown' => Pengaduan::where('ditangani_oleh', $user->id)
                ->whereBetween('created_at', [$start, $end])
                ->select('status', DB::raw('count(*) as total'))
                ->groupBy('status')
                ->get(),
            'kategori_breakdown' => Pengaduan::where('ditangani_oleh', $user->id)
                ->whereBetween('created_at', [$start, $end])
                ->select('kategori', DB::raw('count(*) as total'))
                ->groupBy('kategori')
                ->get(),
        ];
    }
    
    public function export(Request $request)
    {
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
            case 'surat':
                $data = $this->getSuratData($start, $end);
                break;
            case 'antrian':
                $data = $this->getAntrianData($start, $end);
                break;
            case 'pengaduan':
                $data = $this->getPengaduanData($start, $end);
                break;
        }
        
        return $this->exportToPdf($data, $type, $startDate, $endDate);
    }
    
    private function exportToPdf($data, $type, $startDate, $endDate)
    {
        $user = Auth::user();
        
        // Generate PDF
        $pdf = Pdf::loadView('pdf.laporan-pegawai', [
            'data' => $data,
            'type' => $type,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'generatedAt' => now(),
            'pegawai' => $user
        ]);
        $pdf->setPaper('A4', 'portrait');
        
        // Generate filename
        $filename = 'laporan-pegawai-' . $type . '-' . $startDate . '-to-' . $endDate . '-' . now()->format('Y-m-d') . '.pdf';
        
        // Return PDF for download
        return $pdf->download($filename);
    }
}