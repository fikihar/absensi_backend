@auth
<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('siswa.dashboard') }}">Absenin Walisongo</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('siswa.dashboard') }}">AW</a>
        </div>

        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="{{ request()->routeIs('siswa.dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('siswa.dashboard') }}">
                    <i class="fas fa-fire"></i><span>Dashboard</span>
                </a>
            </li>

            <li class="menu-header">Absensi</li>
            <li class="{{ request()->routeIs('siswa.absensi.index') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('siswa.absensi.index') }}">
                    <i class="fas fa-calendar-check"></i><span>Riwayat Absensi</span>
                </a>
            </li>
            <li class="{{ request()->routeIs('siswa.absensi.create') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('siswa.absensi.create') }}">
                    <i class="fas fa-plus-circle"></i><span>Isi Absensi</span>
                </a>
            </li>
       </ul>
    </aside>
</div>
@endauth
