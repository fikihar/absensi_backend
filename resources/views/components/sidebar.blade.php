<aside class="bg-white w-64 border-r hidden md:block">
    @php
        $role = auth()->user()->role ?? null;
    @endphp

    @if ($role === 'admin')
        @include('partials.sidebar-admin')
    @elseif ($role === 'guru')
        @include('partials.sidebar-guru')
    @elseif ($role === 'siswa')
        @include('partials.sidebar-siswa')
    @endif
</aside>
