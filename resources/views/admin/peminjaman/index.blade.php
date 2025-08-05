@extends('components.app')

@section('content')
    <div class="container mt-4">
        <h3>Riwayat Peminjaman Mobil</h3>

        @if (session('success'))
            <div class="alert alert-success mt-2">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Mobil</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Kembali</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($peminjamans as $p)
                    <tr>
                        <td>{{ $p->user->name }}</td>
                        <td>{{ $p->mobil->model }} ({{ $p->mobil->plat_mobil }})</td>
                        <td>{{ \Carbon\Carbon::parse($p->tanggal_pinjam)->format('d/m/Y H:i') }}</td>
                        <td>
                            @if($p->tanggal_pengembalian)
                                {{ \Carbon\Carbon::parse($p->tanggal_pengembalian)->format('d/m/Y H:i') }}
                            @else
                                <span class="text-muted">Belum dikembalikan</span>
                            @endif
                        </td>
                        <td>
                            @if($p->status_peminjaman === 'dipinjam')
                                <span class="badge bg-warning text-dark">Sedang Dipinjam</span>
                            @elseif($p->status_peminjaman === 'dikembalikan')
                                <span class="badge bg-success">Sudah Dikembalikan</span>
                            @endif
                        </td>
                        <td>
                            @if($p->status_peminjaman === 'dikembalikan' && $p->bukti_pengembalian)
                                <a href="{{ route('admin.peminjaman.bukti', $p->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i> Lihat Bukti
                                </a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Belum ada data peminjaman.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Summary Cards -->
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <h5 class="card-title">Sedang Dipinjam</h5>
                        <h3>{{ $peminjamans->where('status_peminjaman', 'dipinjam')->count() }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h5 class="card-title">Sudah Dikembalikan</h5>
                        <h3>{{ $peminjamans->where('status_peminjaman', 'dikembalikan')->count() }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <h5 class="card-title">Total Peminjaman</h5>
                        <h3>{{ $peminjamans->count() }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection