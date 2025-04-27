@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Riwayat Absensi</h1>

    <table class="table">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Jam</th>
                <th>Lokasi</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody id="absensi-table-body">
            <!-- Data absensi akan di-load dari API -->
        </tbody>
    </table>

    <h2>Isi Absensi</h2>
    <form id="absen-form">
        @csrf
        <button type="submit" class="btn btn-primary">Absen Sekarang</button>
    </form>
</div>
@endsection

@push('scripts')
<script>
// Panggil API untuk menampilkan riwayat absensi
function loadAbsensi() {
    fetch('/api/siswa/absensi') // API GET untuk ambil riwayat absensi siswa
        .then(response => response.json())
        .then(data => {
            const tbody = document.getElementById('absensi-table-body');
            tbody.innerHTML = '';

            data.forEach(item => {
                tbody.innerHTML += `
                    <tr>
                        <td>${item.tanggal}</td>
                        <td>${item.jam}</td>
                        <td>${item.lokasi}</td>
                        <td>${item.status}</td>
                    </tr>
                `;
            });
        });
}

// Kirim absensi baru ke API
document.getElementById('absen-form').addEventListener('submit', function(e) {
    e.preventDefault();

    fetch('/api/siswa/absensi', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            // Kirim data tambahan jika diperlukan, misal lokasi, waktu, foto
        })
    })
    .then(response => response.json())
    .then(data => {
        alert('Absensi berhasil!');
        loadAbsensi(); // Reload riwayat
    })
    .catch(error => {
        console.error(error);
        alert('Gagal absen!');
    });
});

// Load absensi saat halaman pertama kali dibuka
loadAbsensi();
</script>
@endpush
