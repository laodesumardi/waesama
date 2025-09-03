<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\ServiceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

class DocumentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin,pegawai']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Document::with(['serviceRequest.citizen', 'generatedBy']);
        
        // Filter berdasarkan pencarian
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('document_number', 'like', "%{$search}%")
                  ->orWhere('template_name', 'like', "%{$search}%")
                  ->orWhereHas('serviceRequest.citizen', function($citizenQuery) use ($search) {
                      $citizenQuery->where('name', 'like', "%{$search}%")
                                   ->orWhere('nik', 'like', "%{$search}%");
                  });
            });
        }
        
        // Filter berdasarkan template
        if ($request->has('template') && $request->template) {
            $query->where('template_name', $request->template);
        }
        
        // Filter berdasarkan status
        if ($request->has('status') && $request->status) {
            if ($request->status === 'active') {
                $query->active();
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }
        
        $documents = $query->orderBy('created_at', 'desc')->paginate(10);
        $availableTemplates = Document::getAvailableTemplates();
        
        return view('admin.documents.index', compact('documents', 'availableTemplates'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $serviceRequest = null;
        if ($request->has('service_request_id')) {
            $serviceRequest = ServiceRequest::with('citizen')->find($request->service_request_id);
        }
        
        $availableTemplates = Document::getAvailableTemplates();
        
        return view('admin.documents.create', compact('serviceRequest', 'availableTemplates'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'service_request_id' => 'required|exists:service_requests,id',
            'template_name' => 'required|string|max:100',
            'template_variables' => 'required|array',
            'valid_until' => 'nullable|date|after:today',
            'notes' => 'nullable|string'
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }
        
        try {
            $serviceRequest = ServiceRequest::with('citizen.village')->find($request->service_request_id);
            
            // Generate dokumen PDF
            $documentContent = $this->generateDocumentContent(
                $request->template_name,
                $request->template_variables,
                $serviceRequest
            );
            
            // Simpan file PDF
            $fileName = $this->generateFileName($request->template_name, $serviceRequest->citizen->name);
            $filePath = 'documents/' . date('Y/m/') . $fileName;
            
            $pdf = Pdf::loadHTML($documentContent);
            Storage::disk('public')->put($filePath, $pdf->output());
            
            // Simpan record dokumen
            $documentData = [
                'service_request_id' => $request->service_request_id,
                'template_name' => $request->template_name,
                'file_path' => $filePath,
                'file_size' => Storage::disk('public')->size($filePath),
                'template_variables' => $request->template_variables,
                'generated_by' => Auth::id(),
                'generated_at' => now(),
                'notes' => $request->notes
            ];
            
            if ($request->valid_until) {
                $documentData['valid_until'] = $request->valid_until;
            }
            
            $document = Document::create($documentData);
            
            return redirect()->route('admin.documents.show', $document)
                           ->with('success', 'Dokumen berhasil dibuat.');
                           
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Terjadi kesalahan saat membuat dokumen: ' . $e->getMessage())
                           ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Document $document)
    {
        $document->load(['serviceRequest.citizen.village', 'generatedBy']);
        
        return view('admin.documents.show', compact('document'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Document $document)
    {
        // Hanya bisa edit jika dokumen masih aktif
        if (!$document->is_active) {
            return redirect()->route('admin.documents.show', $document)
                           ->with('error', 'Dokumen yang tidak aktif tidak dapat diedit.');
        }
        
        $document->load('serviceRequest.citizen');
        $availableTemplates = Document::getAvailableTemplates();
        
        return view('admin.documents.edit', compact('document', 'availableTemplates'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Document $document)
    {
        if (!$document->is_active) {
            return redirect()->route('admin.documents.show', $document)
                           ->with('error', 'Dokumen yang tidak aktif tidak dapat diubah.');
        }
        
        $validator = Validator::make($request->all(), [
            'template_variables' => 'required|array',
            'valid_until' => 'nullable|date|after:today',
            'notes' => 'nullable|string'
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }
        
        try {
            // Regenerate dokumen jika template variables berubah
            if ($document->template_variables != $request->template_variables) {
                $serviceRequest = $document->serviceRequest()->with('citizen.village')->first();
                
                // Generate ulang konten dokumen
                $documentContent = $this->generateDocumentContent(
                    $document->template_name,
                    $request->template_variables,
                    $serviceRequest
                );
                
                // Hapus file lama
                if (Storage::disk('public')->exists($document->file_path)) {
                    Storage::disk('public')->delete($document->file_path);
                }
                
                // Simpan file baru
                $fileName = $this->generateFileName($document->template_name, $serviceRequest->citizen->name);
                $filePath = 'documents/' . date('Y/m/') . $fileName;
                
                $pdf = Pdf::loadHTML($documentContent);
                Storage::disk('public')->put($filePath, $pdf->output());
                
                $document->file_path = $filePath;
                $document->file_size = Storage::disk('public')->size($filePath);
            }
            
            $document->template_variables = $request->template_variables;
            $document->valid_until = $request->valid_until;
            $document->notes = $request->notes;
            $document->save();
            
            return redirect()->route('admin.documents.show', $document)
                           ->with('success', 'Dokumen berhasil diperbarui.');
                           
        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Terjadi kesalahan saat memperbarui dokumen: ' . $e->getMessage())
                           ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Document $document)
    {
        try {
            $document->deleteFile();
            $document->delete();
            
            return redirect()->route('admin.documents.index')
                           ->with('success', 'Dokumen berhasil dihapus.');
                           
        } catch (\Exception $e) {
            return redirect()->route('admin.documents.index')
                           ->with('error', 'Terjadi kesalahan saat menghapus dokumen: ' . $e->getMessage());
        }
    }

    /**
     * Download the document
     */
    public function download(Document $document)
    {
        if (!$document->is_active) {
            return redirect()->back()
                           ->with('error', 'Dokumen tidak aktif tidak dapat diunduh.');
        }
        
        if (!Storage::disk('public')->exists($document->file_path)) {
            return redirect()->back()
                           ->with('error', 'File dokumen tidak ditemukan.');
        }
        
        // Increment download count
        $document->incrementDownloadCount();
        
        $fileName = basename($document->file_path);
        
        return Storage::disk('public')->download($document->file_path, $fileName);
    }

    /**
     * Preview the document
     */
    public function preview(Document $document)
    {
        if (!$document->is_active) {
            return redirect()->back()
                           ->with('error', 'Dokumen tidak aktif tidak dapat dipratinjau.');
        }
        
        if (!Storage::disk('public')->exists($document->file_path)) {
            return redirect()->back()
                           ->with('error', 'File dokumen tidak ditemukan.');
        }
        
        $file = Storage::disk('public')->get($document->file_path);
        
        return Response::make($file, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . basename($document->file_path) . '"'
        ]);
    }

    /**
     * Deactivate the document
     */
    public function deactivate(Document $document)
    {
        $document->markAsInactive();
        
        return redirect()->back()
                       ->with('success', 'Dokumen berhasil dinonaktifkan.');
    }

    /**
     * Activate the document
     */
    public function activate(Document $document)
    {
        $document->is_active = true;
        $document->save();
        
        return redirect()->back()
                       ->with('success', 'Dokumen berhasil diaktifkan.');
    }

    /**
     * Generate document content from template
     */
    private function generateDocumentContent($templateName, $variables, $serviceRequest)
    {
        // Template dasar untuk surat
        $templates = [
            'surat_keterangan_domisili' => $this->getTemplateKeteranganDomisili(),
            'surat_keterangan_usaha' => $this->getTemplateKeteranganUsaha(),
            'surat_keterangan_tidak_mampu' => $this->getTemplateKeteranganTidakMampu(),
            'surat_pengantar_nikah' => $this->getTemplatePengantarNikah(),
            'surat_keterangan_kelahiran' => $this->getTemplateKeteranganKelahiran(),
            'surat_keterangan_kematian' => $this->getTemplateKeteranganKematian()
        ];
        
        $template = $templates[$templateName] ?? $templates['surat_keterangan_domisili'];
        
        // Replace variables dalam template
        $content = $template;
        foreach ($variables as $key => $value) {
            $content = str_replace('{{' . $key . '}}', $value, $content);
        }
        
        // Replace data citizen dan service request
        $citizen = $serviceRequest->citizen;
        $content = str_replace('{{citizen_name}}', $citizen->name, $content);
        $content = str_replace('{{citizen_nik}}', $citizen->nik, $content);
        $content = str_replace('{{citizen_birth_date}}', $citizen->birth_date->format('d F Y'), $content);
        $content = str_replace('{{citizen_birth_place}}', $citizen->birth_place, $content);
        $content = str_replace('{{citizen_address}}', $citizen->address, $content);
        $content = str_replace('{{village_name}}', $citizen->village->name, $content);
        $content = str_replace('{{current_date}}', now()->format('d F Y'), $content);
        $content = str_replace('{{request_number}}', $serviceRequest->request_number, $content);
        
        return $content;
    }

    /**
     * Generate file name
     */
    private function generateFileName($templateName, $citizenName)
    {
        $cleanName = Str::slug($citizenName);
        $timestamp = now()->format('Ymd_His');
        
        return "{$templateName}_{$cleanName}_{$timestamp}.pdf";
    }

    /**
     * Template Surat Keterangan Domisili
     */
    private function getTemplateKeteranganDomisili()
    {
        return '
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; margin: 40px; }
                .header { text-align: center; margin-bottom: 30px; }
                .title { font-size: 18px; font-weight: bold; text-decoration: underline; }
                .content { line-height: 1.6; }
                .signature { margin-top: 50px; text-align: right; }
            </style>
        </head>
        <body>
            <div class="header">
                <h2>PEMERINTAH DESA {{village_name}}</h2>
                <h3 class="title">SURAT KETERANGAN DOMISILI</h3>
                <p>Nomor: {{request_number}}</p>
            </div>
            
            <div class="content">
                <p>Yang bertanda tangan di bawah ini, Kepala Desa {{village_name}}, menerangkan bahwa:</p>
                
                <table style="margin: 20px 0;">
                    <tr><td width="150">Nama</td><td>: {{citizen_name}}</td></tr>
                    <tr><td>NIK</td><td>: {{citizen_nik}}</td></tr>
                    <tr><td>Tempat/Tgl Lahir</td><td>: {{citizen_birth_place}}, {{citizen_birth_date}}</td></tr>
                    <tr><td>Alamat</td><td>: {{citizen_address}}</td></tr>
                </table>
                
                <p>Adalah benar-benar berdomisili di {{village_name}} dan merupakan warga yang baik.</p>
                
                <p>Surat keterangan ini dibuat untuk keperluan: <strong>{{purpose}}</strong></p>
                
                <p>Demikian surat keterangan ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.</p>
            </div>
            
            <div class="signature">
                <p>{{village_name}}, {{current_date}}</p>
                <p>Kepala Desa</p>
                <br><br><br>
                <p><strong>{{village_head_name}}</strong></p>
            </div>
        </body>
        </html>';
    }

    /**
     * Template Surat Keterangan Usaha
     */
    private function getTemplateKeteranganUsaha()
    {
        return '
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; margin: 40px; }
                .header { text-align: center; margin-bottom: 30px; }
                .title { font-size: 18px; font-weight: bold; text-decoration: underline; }
                .content { line-height: 1.6; }
                .signature { margin-top: 50px; text-align: right; }
            </style>
        </head>
        <body>
            <div class="header">
                <h2>PEMERINTAH DESA {{village_name}}</h2>
                <h3 class="title">SURAT KETERANGAN USAHA</h3>
                <p>Nomor: {{request_number}}</p>
            </div>
            
            <div class="content">
                <p>Yang bertanda tangan di bawah ini, Kepala Desa {{village_name}}, menerangkan bahwa:</p>
                
                <table style="margin: 20px 0;">
                    <tr><td width="150">Nama</td><td>: {{citizen_name}}</td></tr>
                    <tr><td>NIK</td><td>: {{citizen_nik}}</td></tr>
                    <tr><td>Tempat/Tgl Lahir</td><td>: {{citizen_birth_place}}, {{citizen_birth_date}}</td></tr>
                    <tr><td>Alamat</td><td>: {{citizen_address}}</td></tr>
                    <tr><td>Jenis Usaha</td><td>: {{business_type}}</td></tr>
                    <tr><td>Alamat Usaha</td><td>: {{business_address}}</td></tr>
                </table>
                
                <p>Adalah benar-benar memiliki usaha {{business_type}} yang beralamat di {{business_address}}.</p>
                
                <p>Surat keterangan ini dibuat untuk keperluan: <strong>{{purpose}}</strong></p>
                
                <p>Demikian surat keterangan ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.</p>
            </div>
            
            <div class="signature">
                <p>{{village_name}}, {{current_date}}</p>
                <p>Kepala Desa</p>
                <br><br><br>
                <p><strong>{{village_head_name}}</strong></p>
            </div>
        </body>
        </html>';
    }

    /**
     * Template Surat Keterangan Tidak Mampu
     */
    private function getTemplateKeteranganTidakMampu()
    {
        return '
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; margin: 40px; }
                .header { text-align: center; margin-bottom: 30px; }
                .title { font-size: 18px; font-weight: bold; text-decoration: underline; }
                .content { line-height: 1.6; }
                .signature { margin-top: 50px; text-align: right; }
            </style>
        </head>
        <body>
            <div class="header">
                <h2>PEMERINTAH DESA {{village_name}}</h2>
                <h3 class="title">SURAT KETERANGAN TIDAK MAMPU</h3>
                <p>Nomor: {{request_number}}</p>
            </div>
            
            <div class="content">
                <p>Yang bertanda tangan di bawah ini, Kepala Desa {{village_name}}, menerangkan bahwa:</p>
                
                <table style="margin: 20px 0;">
                    <tr><td width="150">Nama</td><td>: {{citizen_name}}</td></tr>
                    <tr><td>NIK</td><td>: {{citizen_nik}}</td></tr>
                    <tr><td>Tempat/Tgl Lahir</td><td>: {{citizen_birth_place}}, {{citizen_birth_date}}</td></tr>
                    <tr><td>Alamat</td><td>: {{citizen_address}}</td></tr>
                    <tr><td>Pekerjaan</td><td>: {{job}}</td></tr>
                </table>
                
                <p>Adalah benar-benar termasuk keluarga tidak mampu/kurang mampu dan memerlukan bantuan.</p>
                
                <p>Surat keterangan ini dibuat untuk keperluan: <strong>{{purpose}}</strong></p>
                
                <p>Demikian surat keterangan ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.</p>
            </div>
            
            <div class="signature">
                <p>{{village_name}}, {{current_date}}</p>
                <p>Kepala Desa</p>
                <br><br><br>
                <p><strong>{{village_head_name}}</strong></p>
            </div>
        </body>
        </html>';
    }

    /**
     * Template Surat Pengantar Nikah
     */
    private function getTemplatePengantarNikah()
    {
        return '
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; margin: 40px; }
                .header { text-align: center; margin-bottom: 30px; }
                .title { font-size: 18px; font-weight: bold; text-decoration: underline; }
                .content { line-height: 1.6; }
                .signature { margin-top: 50px; text-align: right; }
            </style>
        </head>
        <body>
            <div class="header">
                <h2>PEMERINTAH DESA {{village_name}}</h2>
                <h3 class="title">SURAT PENGANTAR NIKAH</h3>
                <p>Nomor: {{request_number}}</p>
            </div>
            
            <div class="content">
                <p>Yang bertanda tangan di bawah ini, Kepala Desa {{village_name}}, menerangkan bahwa:</p>
                
                <table style="margin: 20px 0;">
                    <tr><td width="150">Nama</td><td>: {{citizen_name}}</td></tr>
                    <tr><td>NIK</td><td>: {{citizen_nik}}</td></tr>
                    <tr><td>Tempat/Tgl Lahir</td><td>: {{citizen_birth_place}}, {{citizen_birth_date}}</td></tr>
                    <tr><td>Alamat</td><td>: {{citizen_address}}</td></tr>
                    <tr><td>Agama</td><td>: {{religion}}</td></tr>
                    <tr><td>Status</td><td>: {{marital_status}}</td></tr>
                </table>
                
                <p>Adalah benar-benar penduduk desa kami dan akan melangsungkan pernikahan dengan:</p>
                
                <table style="margin: 20px 0;">
                    <tr><td width="150">Nama</td><td>: {{partner_name}}</td></tr>
                    <tr><td>Alamat</td><td>: {{partner_address}}</td></tr>
                </table>
                
                <p>Surat pengantar ini dibuat untuk keperluan pendaftaran nikah di KUA.</p>
                
                <p>Demikian surat pengantar ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.</p>
            </div>
            
            <div class="signature">
                <p>{{village_name}}, {{current_date}}</p>
                <p>Kepala Desa</p>
                <br><br><br>
                <p><strong>{{village_head_name}}</strong></p>
            </div>
        </body>
        </html>';
    }

    /**
     * Template Surat Keterangan Kelahiran
     */
    private function getTemplateKeteranganKelahiran()
    {
        return '
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; margin: 40px; }
                .header { text-align: center; margin-bottom: 30px; }
                .title { font-size: 18px; font-weight: bold; text-decoration: underline; }
                .content { line-height: 1.6; }
                .signature { margin-top: 50px; text-align: right; }
            </style>
        </head>
        <body>
            <div class="header">
                <h2>PEMERINTAH DESA {{village_name}}</h2>
                <h3 class="title">SURAT KETERANGAN KELAHIRAN</h3>
                <p>Nomor: {{request_number}}</p>
            </div>
            
            <div class="content">
                <p>Yang bertanda tangan di bawah ini, Kepala Desa {{village_name}}, menerangkan bahwa:</p>
                
                <p>Pada hari {{birth_day}}, tanggal {{birth_date}}, telah lahir seorang anak dengan keterangan sebagai berikut:</p>
                
                <table style="margin: 20px 0;">
                    <tr><td width="150">Nama Anak</td><td>: {{baby_name}}</td></tr>
                    <tr><td>Jenis Kelamin</td><td>: {{baby_gender}}</td></tr>
                    <tr><td>Tempat Lahir</td><td>: {{birth_place}}</td></tr>
                    <tr><td>Anak ke</td><td>: {{child_order}}</td></tr>
                </table>
                
                <p>Dari pasangan:</p>
                <table style="margin: 20px 0;">
                    <tr><td width="150">Nama Ayah</td><td>: {{father_name}}</td></tr>
                    <tr><td>Nama Ibu</td><td>: {{mother_name}}</td></tr>
                    <tr><td>Alamat</td><td>: {{citizen_address}}</td></tr>
                </table>
                
                <p>Surat keterangan ini dibuat untuk keperluan: <strong>{{purpose}}</strong></p>
                
                <p>Demikian surat keterangan ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.</p>
            </div>
            
            <div class="signature">
                <p>{{village_name}}, {{current_date}}</p>
                <p>Kepala Desa</p>
                <br><br><br>
                <p><strong>{{village_head_name}}</strong></p>
            </div>
        </body>
        </html>';
    }

    /**
     * Template Surat Keterangan Kematian
     */
    private function getTemplateKeteranganKematian()
    {
        return '
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; margin: 40px; }
                .header { text-align: center; margin-bottom: 30px; }
                .title { font-size: 18px; font-weight: bold; text-decoration: underline; }
                .content { line-height: 1.6; }
                .signature { margin-top: 50px; text-align: right; }
            </style>
        </head>
        <body>
            <div class="header">
                <h2>PEMERINTAH DESA {{village_name}}</h2>
                <h3 class="title">SURAT KETERANGAN KEMATIAN</h3>
                <p>Nomor: {{request_number}}</p>
            </div>
            
            <div class="content">
                <p>Yang bertanda tangan di bawah ini, Kepala Desa {{village_name}}, menerangkan bahwa:</p>
                
                <table style="margin: 20px 0;">
                    <tr><td width="150">Nama</td><td>: {{citizen_name}}</td></tr>
                    <tr><td>NIK</td><td>: {{citizen_nik}}</td></tr>
                    <tr><td>Tempat/Tgl Lahir</td><td>: {{citizen_birth_place}}, {{citizen_birth_date}}</td></tr>
                    <tr><td>Alamat</td><td>: {{citizen_address}}</td></tr>
                    <tr><td>Tanggal Meninggal</td><td>: {{death_date}}</td></tr>
                    <tr><td>Tempat Meninggal</td><td>: {{death_place}}</td></tr>
                    <tr><td>Sebab Kematian</td><td>: {{death_cause}}</td></tr>
                </table>
                
                <p>Adalah benar-benar telah meninggal dunia dan merupakan penduduk desa kami.</p>
                
                <p>Surat keterangan ini dibuat untuk keperluan: <strong>{{purpose}}</strong></p>
                
                <p>Demikian surat keterangan ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya.</p>
            </div>
            
            <div class="signature">
                <p>{{village_name}}, {{current_date}}</p>
                <p>Kepala Desa</p>
                <br><br><br>
                <p><strong>{{village_head_name}}</strong></p>
            </div>
        </body>
        </html>';
    }
}
