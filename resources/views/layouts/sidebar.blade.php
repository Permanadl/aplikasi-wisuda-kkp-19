<ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center bg-warning" href="{{ url('dashboard') }}">
        <div class="sidebar-brand-icon">
            <img src="{{ asset('img/logo/logo2.png') }}">
        </div>
        <div class="sidebar-brand-text mx-3">AplikasiWisuda</div>
    </a>
    <hr class="sidebar-divider my-0">
    <li class="nav-item active">
        <a class="nav-link" href="{{ url('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">Navigasi Utama</div>
    @if (Session::get('level') == 'admin')
    <li class="nav-item">
        <a class="nav-link" href="{{ url('admin') }}">
            <i class="fas fa-fw fa-user-tie"></i>
            <span>Admin</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ url('prodi') }}">
            <i class="fas fa-fw fa-sitemap"></i>
            <span>Program Studi</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ url('wisuda') }}">
            <i class="fas fa-fw fa-graduation-cap"></i>
            <span>Wisuda</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ url('wisudawan') }}">
            <i class="fas fa-fw fa-user-graduate"></i>
            <span>Wisudawan</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ url('verifikasi') }}">
            <i class="fas fa-fw fa-clipboard-check"></i>
            <span>Verifikasi</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ url('testimoni') }}">
            <i class="fas fa-fw fa-comment-dots"></i>
            <span>Testimoni</span>
        </a>
    </li>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">Laporan</div>
    <li class="nav-item">
        <a class="nav-link" href="{{ url('peringkat') }}">
            <i class="fas fa-fw fa-list-ol"></i>
            <span>Peringkat</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('download') }}">
            <i class="fas fa-fw fa-file-excel"></i>
            <span>Format LLDIKTI</span>
        </a>
    </li>
    @else
    @if (Session::get('edited') == 'edited')
    <li class="nav-item">
        <a class="nav-link" href="{{ url('upload')}}">
            <i class="fas fa-fw fa-clipboard-check"></i>
            <span>Verifikasi</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ url('testimoni') }}">
            <i class="fas fa-fw fa-comment-dots"></i>
            <span>Testimoni</span>
        </a>
    </li>
    @else
    <li class="nav-item">
        <a class="nav-link" href="{{ route('profile') }}">
            <i class="fas fa-fw fa-user-edit"></i>
            <span>Perbarui Profil</span>
        </a>
    </li>
    @endif
    <hr class="sidebar-divider">
    <div class="sidebar-heading">Pengaturan</div>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('setting') }}">
            <i class="fas fa-fw fa-user-cog"></i>
            <span>Pengaturan Akun</span>
        </a>
    </li>
    @endif
    <hr class="sidebar-divider">
    <div class="version" id="version-app-wisuda"></div>
</ul>