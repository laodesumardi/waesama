<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan {{ ucfirst($type) }} - Kantor Camat Waesama</title>
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
        .report-info {
            margin: 20px 0;
            background-color: #f5f5f5;
            padding: 15px;
            border-radius: 5px;
        }
        .report-info table {
            width: 100%;
            border-collapse: collapse;
        }
        .report-info td {
            padding: 5px;
            border: none;
        }
        .report-info .label {
            font-weight: bold;
            width: 30%;
        }
        .content {
            margin: 20px 0;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .data-table th,
        .data-table td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: left;
        }
        .data-table th {
            background-color: #f5f5f5;
            font-weight: bold;
            font-size: 11px;
        }
        .data-table td {
            font-size: 10px;
        }
        .summary {
            margin: 20px 0;
            background-color: #f0f8ff;
            padding: 15px;
            border-radius: 5px;
        }
        .summary h3 {
            margin-top: 0;
            margin-bottom: 10px;
            font-size: 14px;
        }
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }
        .summary-item {
            background-color: white;
            padding: 10px;
            border-radius: 3px;
            border: 1px solid #ddd;
        }
        .summary-item .label {
            font-size: 10px;
            color: #666;
            margin-bottom: 5px;
        }
        .summary-item .value {
            font-size: 16px;
            font-weight: bold;
            color: #333;
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
        .status {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 3px;
            font-weight: bold;
            font-size: 9px;
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
        .page-break {
            page-break-before: always;
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

    <div class="report-info">
        <table>
            <tr>
                <td class="label">Jenis Laporan</td>
                <td>: Laporan Pegawai - {{ ucfirst($type) }}</td>
            </tr>
            <tr>
                <td class="label">Periode</td>
                <td>: {{ $startDate }} s/d {{ $endDate }}</td>
            </tr>
            <tr>
                <td class="label">Tanggal Cetak</td>
                <td>: {{ $generatedAt->format('d F Y, H:i') }} WIB</td>
            </tr>
            <tr>
                <td class="label">Dicetak oleh</td>
                <td>: {{ $pegawai->name }} ({{ $pegawai->role->name ?? 'Pegawai' }})</td>
            </tr>
        </table>
    </div>

    <div class="content">
        <h2 style="text-align: center; margin-bottom: 20px;">LAPORAN PEGAWAI - {{ strtoupper($type) }}</h2>
        
        @if($type === 'overview')
            <!-- Summary Overview -->
            <div class="summary">
                <h3>Ringkasan Data Keseluruhan</h3>
                <div class="summary-grid">
                    <div class="summary-item">
                        <div class="label">Total Surat Diproses</div>
                        <div class="value">{{ $data['total_surat'] ?? 0 }}</div>
                    </div>
                    <div class="summary-item">
                        <div class="label">Total Antrian Dilayani</div>
                        <div class="value">{{ $data['total_antrian'] ?? 0 }}</div>
                    </div>
                    <div class="summary-item">
                        <div class="label">Total Pengaduan Ditangani</div>
                        <div class="value">{{ $data['total_pengaduan'] ?? 0 }}</div>
                    </div>
                    <div class="summary-item">
                        <div class="label">Total Berita Dipublikasi</div>
                        <div class="value">{{ $data['total_berita'] ?? 0 }}</div>
                    </div>
                </div>
            </div>

            <!-- Detail Status -->
            <div class="summary">
                <h3>Detail Status Layanan yang Ditangani</h3>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Layanan</th>
                            <th>Pending</th>
                            <th>Diproses</th>
                            <th>Selesai</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Surat</td>
                            <td>{{ $data['surat_pending'] ?? 0 }}</td>
                            <td>{{ $data['surat_processing'] ?? 0 }}</td>
                            <td>{{ $data['surat_completed'] ?? 0 }}</td>
                            <td>{{ $data['total_surat'] ?? 0 }}</td>
                        </tr>
                        <tr>
                            <td>Antrian</td>
                            <td>{{ $data['antrian_pending'] ?? 0 }}</td>
                            <td>{{ $data['antrian_processing'] ?? 0 }}</td>
                            <td>{{ $data['antrian_completed'] ?? 0 }}</td>
                            <td>{{ $data['total_antrian'] ?? 0 }}</td>
                        </tr>
                        <tr>
                            <td>Pengaduan</td>
                            <td>{{ $data['pengaduan_pending'] ?? 0 }}</td>
                            <td>{{ $data['pengaduan_processing'] ?? 0 }}</td>
                            <td>{{ $data['pengaduan_completed'] ?? 0 }}</td>
                            <td>{{ $data['total_pengaduan'] ?? 0 }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

        @elseif($type === 'surat')
            <!-- Laporan Surat -->
            @if(isset($data['recent']) && count($data['recent']) > 0)
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Jenis Surat</th>
                        <th>Pemohon</th>
                        <th>Status</th>
                        <th>Tanggal Pengajuan</th>
                        <th>Tanggal Selesai</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['recent'] as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->jenis_surat }}</td>
                        <td>{{ $item->penduduk->nama ?? 'N/A' }}</td>
                        <td>
                            <span class="status 
                                @switch($item->status)
                                    @case('pending')
                                        status-pending
                                        @break
                                    @case('processing')
                                        status-processing
                                        @break
                                    @case('completed')
                                        status-completed
                                        @break
                                    @case('rejected')
                                        status-rejected
                                        @break
                                    @default
                                        status-pending
                                @endswitch">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td>{{ $item->created_at->format('d/m/Y') }}</td>
                        <td>{{ $item->status === 'completed' && $item->updated_at ? $item->updated_at->format('d/m/Y') : '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <p style="text-align: center; color: #666; font-style: italic;">Tidak ada data surat pada periode ini.</p>
            @endif

        @elseif($type === 'antrian')
            <!-- Laporan Antrian -->
            @if(isset($data['recent']) && count($data['recent']) > 0)
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nomor Antrian</th>
                        <th>Nama</th>
                        <th>Layanan</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['recent'] as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->nomor_antrian }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->layanan }}</td>
                        <td>
                            <span class="status 
                                @switch($item->status)
                                    @case('pending')
                                        status-pending
                                        @break
                                    @case('processing')
                                        status-processing
                                        @break
                                    @case('completed')
                                        status-completed
                                        @break
                                    @default
                                        status-pending
                                @endswitch">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <p style="text-align: center; color: #666; font-style: italic;">Tidak ada data antrian pada periode ini.</p>
            @endif

        @elseif($type === 'pengaduan')
            <!-- Laporan Pengaduan -->
            @if(isset($data['recent']) && count($data['recent']) > 0)
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Pelapor</th>
                        <th>Kategori</th>
                        <th>Prioritas</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['recent'] as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->judul }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->kategori }}</td>
                        <td>{{ $item->prioritas ?? '-' }}</td>
                        <td>
                            <span class="status 
                                @switch($item->status)
                                    @case('pending')
                                        status-pending
                                        @break
                                    @case('processing')
                                        status-processing
                                        @break
                                    @case('completed')
                                        status-completed
                                        @break
                                    @case('rejected')
                                        status-rejected
                                        @break
                                    @default
                                        status-pending
                                @endswitch">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td>{{ $item->created_at->format('d/m/Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <p style="text-align: center; color: #666; font-style: italic;">Tidak ada data pengaduan pada periode ini.</p>
            @endif

        @elseif($type === 'berita')
            <!-- Laporan Berita -->
            @if(isset($data['recent']) && count($data['recent']) > 0)
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Status</th>
                        <th>Tanggal Publikasi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['recent'] as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->judul }}</td>
                        <td>{{ $item->kategori }}</td>
                        <td>
                            <span class="status 
                                @if($item->status === 'published')
                                    status-completed
                                @elseif($item->status === 'draft')
                                    status-pending
                                @else
                                    status-processing
                                @endif">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td>{{ $item->created_at->format('d/m/Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <p style="text-align: center; color: #666; font-style: italic;">Tidak ada data berita pada periode ini.</p>
            @endif
        @endif
    </div>

    <div class="footer">
        <p>Waesama, {{ $generatedAt->format('d F Y') }}</p>
        <div class="signature">
            <div class="signature-box">
                <p>{{ $pegawai->role->name ?? 'Pegawai' }}</p>
                <div class="signature-line"></div>
                <p><strong>{{ $pegawai->name }}</strong></p>
                <p>NIP. {{ $pegawai->nip ?? '-' }}</p>
            </div>
        </div>
    </div>
</body>
</html>