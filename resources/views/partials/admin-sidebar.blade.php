<!-- Dashboard -->
<a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active text-white' : 'text-gray-700 hover:text-white' }}">
    <i class="fas fa-tachometer-alt"></i>
    <span class="nav-text">Dashboard</span>
</a>

<!-- Data Penduduk -->
<a href="{{ route('admin.penduduk.index') }}" class="nav-item {{ request()->routeIs('admin.penduduk.*') ? 'active text-white' : 'text-gray-700 hover:text-white' }}">
    <i class="fas fa-users"></i>
    <span class="nav-text">Data Penduduk</span>
</a>

<!-- Layanan Surat -->
<a href="{{ route('admin.surat.index') }}" class="nav-item {{ request()->routeIs('admin.surat.*') ? 'active text-white' : 'text-gray-700 hover:text-white' }}">
    <i class="fas fa-file-alt"></i>
    <span class="nav-text">Layanan Surat</span>
</a>

<!-- Dokumen -->
<a href="{{ route('admin.documents.index') }}" class="nav-item {{ request()->routeIs('admin.documents.*') ? 'active text-white' : 'text-gray-700 hover:text-white' }}">
    <i class="fas fa-file-pdf"></i>
    <span class="nav-text">Dokumen</span>
</a>



{{-- <!-- Approval Dokumen -->
<a href="{{ route('admin.document-approvals.index') }}" class="nav-item {{ request()->routeIs('admin.document-approvals.*') ? 'active text-white' : 'text-gray-700 hover:text-white' }}">
    <i class="fas fa-check-circle"></i>
    <span class="nav-text">Approval Dokumen</span>
</a> --}}

{{-- <!-- Template Dokumen -->
<a href="{{ route('document-templates.index') }}" class="nav-item {{ request()->routeIs('document-templates.*') ? 'active text-white' : 'text-gray-700 hover:text-white' }}">
    <i class="fas fa-file-alt"></i>
    <span class="nav-text">Template Dokumen</span>
</a> --}}

<!-- Antrian -->
<a href="{{ route('admin.antrian.index') }}" class="nav-item {{ request()->routeIs('admin.antrian.index') ? 'active text-white' : 'text-gray-700 hover:text-white' }}">
    <i class="fas fa-clock"></i>
    <span class="nav-text">Antrian</span>
</a>

<!-- Dashboard Antrian -->
<a href="{{ route('admin.antrian.dashboard') }}" class="nav-item {{ request()->routeIs('admin.antrian.dashboard') ? 'active text-white' : 'text-gray-700 hover:text-white' }}">
    <i class="fas fa-chart-line"></i>
    <span class="nav-text">Dashboard Antrian</span>
</a>

<!-- Berita -->
<a href="{{ route('admin.berita.index') }}" class="nav-item {{ request()->routeIs('admin.berita.*') ? 'active text-white' : 'text-gray-700 hover:text-white' }}">
    <i class="fas fa-newspaper"></i>
    <span class="nav-text">Berita</span>
</a>

<!-- Pengaduan -->
<a href="{{ route('admin.pengaduan.index') }}" class="nav-item {{ request()->routeIs('admin.pengaduan.*') ? 'active text-white' : 'text-gray-700 hover:text-white' }}">
    <i class="fas fa-comments"></i>
    <span class="nav-text">Pengaduan</span>
</a>

<!-- Manajemen User -->
<a href="{{ route('admin.user.index') }}" class="nav-item {{ request()->routeIs('admin.user.*') ? 'active text-white' : 'text-gray-700 hover:text-white' }}">
    <i class="fas fa-user-cog"></i>
    <span class="nav-text">Manajemen User</span>
</a>

<!-- Laporan -->
<a href="{{ route('admin.laporan.index') }}" class="nav-item {{ request()->routeIs('admin.laporan.*') ? 'active text-white' : 'text-gray-700 hover:text-white' }}">
    <i class="fas fa-chart-bar"></i>
    <span class="nav-text">Laporan</span>
</a>

<!-- Pengaturan -->
<a href="{{ route('admin.settings.index') }}" class="nav-item {{ request()->routeIs('admin.settings.*') ? 'active text-white' : 'text-gray-700 hover:text-white' }}">
    <i class="fas fa-cog"></i>
    <span class="nav-text">Pengaturan</span>
</a>