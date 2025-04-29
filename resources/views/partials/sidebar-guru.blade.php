@auth
<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('guru.dashboard') }}">Absenin Walisongo</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('guru.dashboard') }}">AW</a>
        </div>

        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="{{ request()->routeIs('guru.dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('guru.dashboard') }}">
                    <i class="fas fa-fire"></i><span>Dashboard</span>
                </a>
            </li>

            <li class="menu-header">Absensi</li>
            <li class="{{ request()->routeIs('guru.absensi.index') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('guru.absensi.index') }}">
                    <i class="fas fa-calendar-check"></i><span>Data Absensi</span>
                </a>
            </li>

            <li class="menu-header">Siswa</li>
            <li class="{{ request()->routeIs('guru.siswa.index') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('guru.siswa.index') }}">
                    <i class="fas fa-user-graduate"></i><span>Daftar Siswa</span>
                </a>
            </li>

            <li class="menu-header">Laporan</li>
            <li class="{{ request()->routeIs('guru.laporan-absensi.index') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('guru.laporan-absensi.index') }}">
                    <i class="fas fa-file-alt"></i><span>Laporan Absensi</span>
                </a>
            </li>
            <li class="{{ request()->routeIs('guru.laporan-absensi.export') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('guru.laporan-absensi.export') }}">
                    <i class="fas fa-file-pdf"></i><span>Export PDF</span>
                </a>
            </li>

            <li class="menu-header">Pengguna</li>
            <li class="{{ request()->is('profile/edit') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('profile/edit') }}">
                    <i class="far fa-user"></i><span>Profil</span>
                </a>
            </li>
            <li class="{{ request()->is('profile/change-password') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('profile/change-password') }}">
                    <i class="fas fa-key"></i><span>Ganti Password</span>
                </a>
            </li>
        </ul>
    </aside>
</div>
@endauth
