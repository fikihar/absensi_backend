<!DOCTYPE html>
<html>
<head>
    <title>Laporan Absensi</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        h1 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .statistik { margin-top: 20px; }
    </style>
</head>
<body>
    <h1>Laporan Absensi</h1>
    <p><strong>Periode:</strong> {{ ucfirst($periode) }}</p>
    <p><strong>Tanggal Mulai:</strong> {{ $tanggal_mulai }}</p>
    <p><strong>Tanggal Selesai:</strong> {{ $tanggal_selesai }}</p>

    <div class="statistik">
        <p><strong>Total Absensi:</strong> {{ $statistik['total_absensi'] }}</p>
        <p><strong>Total Hadir:</strong> {{ $statistik['total_hadir'] }}</p>
        <p><strong>Total Tidak Hadir:</strong> {{ $statistik['total_tidak_hadir'] }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Tanggal</th>
                <th>Lokasi</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($absensi as $item)
                <tr>
                    <td>{{ $item->siswa->nama }}</td>
                    <td>{{ $item->siswa->kelas }}</td>
                    <td>{{ $item->tanggal }}</td>
                    <td>{{ $item->lokasi }}</td>
                    <td>{{ $item->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
