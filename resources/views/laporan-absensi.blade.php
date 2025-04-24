@extends('layouts.app')

@section('content')
<div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Laporan Absensi</h3>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('laporan-absensi') }}">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="periode">Periode:</label>
                            <select name="periode" class="form-control" onchange="this.form.submit()">
                                <option value="harian" {{ $periode == 'harian' ? 'selected' : '' }}>Harian</option>
                                <option value="mingguan" {{ $periode == 'mingguan' ? 'selected' : '' }}>Mingguan</option>
                                <option value="bulanan" {{ $periode == 'bulanan' ? 'selected' : '' }}>Bulanan</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="tanggal">Tanggal:</label>
                            <input type="date" name="tanggal" value="{{ $tanggal }}" class="form-control" onchange="this.form.submit()">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="kelas">Kelas:</label>
                            <select name="kelas" class="form-control" onchange="this.form.submit()">
                                <option value="">Semua Kelas</option>
                                <option value="TJKT A" {{ $kelas == 'TJKT A' ? 'selected' : '' }}>TJKT A</option>
                                <option value="TJKT B" {{ $kelas == 'TJKT B' ? 'selected' : '' }}>TJKT B</option>
                            </select>
                        </div>
                    </div>
                </div>
            </form>

            <div class="row">
                <div class="col-md-4">
                    <div class="info-box">
                        <span class="info-box-icon bg-info"><i class="fas fa-users"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Absensi</span>
                            <span class="info-box-number">{{ $statistik['total_absensi'] }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-box">
                        <span class="info-box-icon bg-success"><i class="fas fa-check"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Hadir</span>
                            <span class="info-box-number">{{ $statistik['total_hadir'] }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="info-box">
                        <span class="info-box-icon bg-danger"><i class="fas fa-times"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Tidak Hadir</span>
                            <span class="info-box-number">{{ $statistik['total_tidak_hadir'] }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered">
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
                        @forelse ($absensi as $item)
                            <tr>
                                <td>{{ $item->siswa->nama }}</td>
                                <td>{{ $item->siswa->kelas }}</td>
                                <td>{{ $item->tanggal }}</td>
                                <td>{{ $item->lokasi }}</td>
                                <td>
                                    <span class="badge {{ $item->status === 'Hadir' ? 'bg-success' : 'bg-danger' }}">
                                        {{ $item->status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada data absensi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('laporan-absensi.export-pdf', ['periode' => $periode, 'tanggal' => $tanggal, 'kelas' => $kelas]) }}"
               class="btn btn-primary">
                <i class="fas fa-download"></i> Download PDF
            </a>
        </div>
    </div>
</div>
@endsection
