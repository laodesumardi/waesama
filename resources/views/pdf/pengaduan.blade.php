<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pengaduan - {{ $pengaduan->judul }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #000;
            padding-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }
        .header h2 {
            margin: 5px 0;
            font-size: 16px;
            font-weight: bold;
        }
        .header p {
            margin: 2px 0;
            font-size: 11px;
        }
        .content {
            margin: 20px 0;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .info-table td {
            padding: 8px;
            border: 1px solid #ddd;
            vertical-align: top;
        }
        .info-table .label {
            background-color: #f5f5f5;
            font-weight: bold;
            width: 30%;
        }
        .description {
            margin: 20px 0;
        }
        .description h3 {
            margin-bottom: 10px;
            font-size: 14px;
        }
        .description-content {
            border: 1px solid #ddd;
            padding: 15px;
            background-color: #f9f9f9;
            min-height: 100px;
        }
        .response {
            margin: 20px 0;
        }
        .response h3 {
            margin-bottom: 10px;
            font-size: 14px;
        }
        .response-content {
            border: 1px solid #ddd;
            padding: 15px;
            background-color: #f0f8ff;
            min-height: 80px;
        }
        .status {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-weight: bold;
            font-size: 11px;
        }
        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }
        .status-processing {
            background-color: #dbeafe;
            color: #1e40af;
        }
        .status-completed {
            background-color: #d1fae5;
            color: #065f46;
        }
        .status-rejected {
            background-color: #fee2e2;
            color: #991b1b;
        }
        .footer {
            margin-top: 40px;
            text-align: right;
        }
        .signature {
            margin-top: 60px;
        }
        .signature-box {
            display: inline-block;
            text-align: center;
            margin-left: 50px;
        }
        .signature-line {
            border-bottom: 1px solid #000;
            width: 200px;
            margin: 40px auto 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>PEMERINTAH KABUPATEN WAKATOBI</h1>
        <h2>KANTOR CAMAT WAESAMA</h2>
        <p>Alamat: Jl. Raya Waesama, Kec. Waesama, Kab. Wakatobi, Sulawesi Tenggara</p>
        <p>Telepon: (0401) 123456 | Email: camat.waesama@wakatolikab.go.id</p>
    </div>

    <div class="content">
        <h2 style="text-align: center; margin-bottom: 20px;">LAPORAN PENGADUAN</h2>
        
        <table class="info-table">
            <tr>
                <td class="label">Nomor Pengaduan</td>
                <td>{{ $pengaduan->nomor_pengaduan }}</td>
            </tr>
            <tr>
                <td class="label">Judul Pengaduan</td>
                <td>{{ $pengaduan->judul_pengaduan }}</td>
            </tr>
            <tr>
                <td class="label">Nama Pengadu</td>
                <td>{{ $pengaduan->nama_pengadu }}</td>
            </tr>
            <tr>
                <td class="label">Email</td>
                <td>{{ $pengaduan->email_pengadu }}</td>
            </tr>
            <tr>
                <td class="label">Nomor Telepon</td>
                <td>{{ $pengaduan->phone_pengadu ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Alamat</td>
                <td>{{ $pengaduan->alamat_pengadu ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Kategori</td>
                <td>{{ $pengaduan->kategori }}</td>
            </tr>
            <tr>
                <td class="label">Prioritas</td>
                <td>{{ $pengaduan->prioritas }}</td>
            </tr>
            <tr>
                <td class="label">Status</td>
                <td>
                    <span class="status 
                        @switch($pengaduan->status)
                            @case('Diterima')
                                status-pending
                                @break
                            @case('Diproses')
                                status-processing
                                @break
                            @case('Ditindaklanjuti')
                                status-processing
                                @break
                            @case('Selesai')
                                status-completed
                                @break
                            @case('Ditolak')
                                status-rejected
                                @break
                        @endswitch">
                        {{ $pengaduan->status }}
                    </span>
                </td>
            </tr>
            <tr>
                <td class="label">Tanggal Pengaduan</td>
                <td>{{ $pengaduan->created_at->format('d F Y, H:i') }} WIB</td>
            </tr>
            @if($pengaduan->updated_at != $pengaduan->created_at)
            <tr>
                <td class="label">Tanggal Update</td>
                <td>{{ $pengaduan->updated_at->format('d F Y, H:i') }} WIB</td>
            </tr>
            @endif
        </table>

        <div class="description">
            <h3>Deskripsi Pengaduan:</h3>
            <div class="description-content">
                {{ $pengaduan->isi_pengaduan }}
            </div>
        </div>

        @if($pengaduan->tanggapan)
        <div class="response">
            <h3>Tanggapan:</h3>
            <div class="response-content">
                {{ $pengaduan->tanggapan }}
            </div>
            @if($pengaduan->handler)
            <p style="margin-top: 10px; font-style: italic; font-size: 11px;">
                Ditanggapi oleh: {{ $pengaduan->handler->name }}
            </p>
            @endif
        </div>
        @endif
    </div>

    <div class="footer">
        <p>Waesama, {{ now()->format('d F Y') }}</p>
        <div class="signature">
            <div class="signature-box">
                <p>Camat Waesama</p>
                <div class="signature-line"></div>
                <p><strong>Nama Camat</strong></p>
                <p>NIP. 123456789012345678</p>
            </div>
        </div>
    </div>
</body>
</html>