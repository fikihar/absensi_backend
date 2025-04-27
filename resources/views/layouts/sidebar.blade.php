<div class="main-sidebar">
    <aside id="sidebar-wrapper">
      <div class="sidebar-brand">
        <a href="#">Absenin</a>
      </div>
      <div class="sidebar-brand sidebar-brand-sm">
        <a href="#">AW</a>
      </div>

      <ul class="sidebar-menu">
        @php
          $role = auth()->user()->role;
        @endphp

        {{-- === ADMIN === --}}
        @if($role === 'admin')
          <li class="menu-header">Dashboard</li>
          <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.dashboard') }}">
              <i class="fas fa-fire"></i> <span>Dashboard</span>
            </a>
          </li>

          <li class="menu-header">Manajemen Data</li>
          <li class="{{ request()->routeIs('admin.siswa.index') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.siswa.index') }}">
              <i class="fas fa-user-graduate"></i> <span>Data Siswa</span>
            </a>
          </li>
          <li class="{{ request()->routeIs('admin.guru.index') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.guru.index') }}">
              <i class="fas fa-chalkboard-teacher"></i> <span>Data Guru</span>
            </a>
          </li>
          <li class="{{ request()->routeIs('admin.dudi.index') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.dudi.index') }}">
              <i class="fas fa-industry"></i> <span>Data DUDI</span>
            </a>
          </li>

          <li class="menu-header">Alokasi</li>
          <li class="{{ request()->routeIs('admin.alokasi-siswa.index') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.alokasi-siswa.index') }}">
              <i class="fas fa-random"></i> <span>Alokasi Siswa</span>
            </a>
          </li>
          <li class="{{ request()->routeIs('admin.alokasi-guru.index') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.alokasi-guru.index') }}">
              <i class="fas fa-random"></i> <span>Alokasi Guru</span>
            </a>
          </li>

          <li class="menu-header">Laporan</li>
          <li class="{{ request()->routeIs('admin.laporan-absensi.index') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.laporan-absensi.index') }}">
              <i class="fas fa-file-alt"></i> <span>Laporan Absensi</span>
            </a>
          </li>

        {{-- === GURU === --}}
        @elseif($role === 'guru')
          <li class="menu-header">Dashboard</li>
          <li class="{{ request()->routeIs('guru.dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('guru.dashboard') }}">
              <i class="fas fa-fire"></i> <span>Dashboard</span>
            </a>
          </li>

          <li class="menu-header">Absensi</li>
          <li class="{{ request()->routeIs('guru.absensi.index') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('guru.absensi.index') }}">
              <i class="fas fa-calendar-check"></i> <span>Data Absensi</span>
            </a>
          </li>
          <li class="{{ request()->routeIs('guru.siswa.index') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('guru.siswa.index') }}">
              <i class="fas fa-users"></i> <span>Daftar Siswa</span>
            </a>
          </li>

          <li class="menu-header">Laporan</li>
          <li class="{{ request()->routeIs('guru.laporan-absensi.index') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('guru.laporan-absensi.index') }}">
              <i class="fas fa-file-alt"></i> <span>Laporan Absensi</span>
            </a>
          </li>

        {{-- === SISWA === --}}
        @elseif($role === 'siswa')
          <li class="menu-header">Dashboard</li>
          <li class="{{ request()->routeIs('siswa.dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('siswa.dashboard') }}">
              <i class="fas fa-fire"></i> <span>Dashboard</span>
            </a>
          </li>

          <li class="menu-header">Absensi</li>
          <li class="{{ request()->routeIs('siswa.absensi.index') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('siswa.absensi.index') }}">
              <i class="fas fa-history"></i> <span>Riwayat Absensi</span>
            </a>
          </li>
          <li class="{{ request()->routeIs('siswa.absensi.create') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('siswa.absensi.create') }}">
              <i class="fas fa-calendar-plus"></i> <span>Isi Absensi</span>
            </a>
          </li>
        @endif

        {{-- Logout --}}
        <li class="menu-header mt-4">Akun</li>
        <li>
          <form action="{{ route('logout') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="btn btn-danger btn-block">
              <i class="fas fa-sign-out-alt"></i> Logout
            </button>
          </form>
        </li>
      </ul>
    </aside>
  </div>
