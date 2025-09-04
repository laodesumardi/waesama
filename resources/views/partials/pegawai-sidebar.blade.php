<!-- Dashboard -->
<a href="{{ route('pegawai.dashboard') }}" class="nav-item {{ request()->routeIs('pegawai.dashboard') ? 'active text-white' : 'text-gray-700 hover:text-white' }}">
    <i class="fas fa-tachometer-alt"></i>
    <span class="nav-text">Dashboard</span>
</a>

<!-- Data Penduduk -->
<a href="{{ route('pegawai.penduduk.index') }}" class="nav-item {{ request()->routeIs('pegawai.penduduk.*') ? 'active text-white' : 'text-gray-700 hover:text-white' }}">
    <i class="fas fa-users"></i>
    <span class="nav-text">Data Penduduk</span>
</a>

<!-- Layanan Surat -->
<a href="{{ route('pegawai.surat.index') }}" class="nav-item {{ request()->routeIs('pegawai.surat.*') ? 'active text-white' : 'text-gray-700 hover:text-white' }}">
    <i class="fas fa-file-alt"></i>
    <span class="nav-text">Layanan Surat</span>
</a>

<!-- Antrian -->
<a href="{{ route('pegawai.antrian.index') }}" class="nav-item {{ request()->routeIs('pegawai.antrian.*') ? 'active text-white' : 'text-gray-700 hover:text-white' }}">
    <i class="fas fa-clock"></i>
    <span class="nav-text">Antrian</span>
</a>

<!-- Pengaduan -->
<a href="{{ route('pegawai.pengaduan.index') }}" class="nav-item {{ request()->routeIs('pegawai.pengaduan.*') ? 'active text-white' : 'text-gray-700 hover:text-white' }}">
    <i class="fas fa-comments"></i>
    <span class="nav-text">Pengaduan</span>
</a>

<!-- Laporan -->
<a href="{{ route('pegawai.laporan.index') }}" class="nav-item {{ request()->routeIs('pegawai.laporan.*') ? 'active text-white' : 'text-gray-700 hover:text-white' }}">
    <i class="fas fa-chart-bar"></i>
    <span class="nav-text">Laporan</span>
</a>