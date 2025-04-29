@auth
<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('admin.dashboard') }}">Absenin Walisongo</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('admin.dashboard') }}">AW</a>
        </div>

        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-fire"></i><span>Dashboard</span>
                </a>
            </li>

            <li class="menu-header">Manajemen</li>
            <li class="{{ request()->routeIs('admin.siswa.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.siswa.index') }}">
                    <i class="fas fa-user-graduate"></i><span>Data Siswa</span>
                </a>
            </li>
            <li class="{{ request()->routeIs('admin.guru.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.guru.index') }}">
                    <i class="fas fa-chalkboard-teacher"></i><span>Data Guru</span>
                </a>
            </li>
            <li class="{{ request()->routeIs('admin.dudi.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.dudi.index') }}">
                    <i class="fas fa-building"></i><span>Data DUDI</span>
                </a>
            </li>

            <li class="menu-header">Alokasi DUDI</li>
            <li class="{{ request()->routeIs('admin.alokasi-siswa.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.alokasi-siswa.index') }}">
                    <i class="fas fa-user-clock"></i><span>Alokasi Siswa</span>
                </a>
            </li>
            <li class="{{ request()->routeIs('admin.alokasi-guru.*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.alokasi-guru.index') }}">
                    <i class="fas fa-user-tie"></i><span>Alokasi Guru</span>
                </a>
            </li>

            <li class="menu-header">Laporan</li>
            <li class="{{ request()->routeIs('admin.laporan-absensi.index') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.laporan-absensi.index') }}">
                    <i class="fas fa-file-alt"></i><span>Laporan Absensi</span>
                </a>
            </li>
            <li class="{{ request()->routeIs('admin.laporan-absensi.export') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('admin.laporan-absensi.export') }}">
                    <i class="fas fa-file-pdf"></i><span>Export PDF</span>
                </a>
            </li>
        </ul>
    </aside>
</div>
@endauth
