@extends('components.app')

@section('content')
    <div class="container mt-4">
        <h3>Manajemen Pengajuan Peminjaman</h3>

        @if (session('success'))
            <div class="alert alert-success mt-2">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Mobil</th>
                    <th>Tanggal Pinjam</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($peminjamans as $p)
                    <tr>
                        <td>{{ $p->user->name }}</td>
                        <td>{{ $p->mobil->model }} ({{ $p->mobil->plat_mobil }})</td>
                        <td>{{ $p->tanggal_pinjam }}</td>
                        <td>{{ ucfirst($p->status_peminjaman) }}</td>
                        <td>
                            @if ($p->status_peminjaman === 'diajukan')
                                <form action="{{ route('admin.peminjaman.setujui', $p->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">Setujui</button>
                                </form>
                                <form action="{{ route('admin.peminjaman.tolak', $p->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm">Tolak</button>
                                </form>
                            @elseif($p->status_peminjaman === 'dikembalikan')
                                <a href="{{ route('admin.peminjaman.bukti', $p->id) }}" class="btn btn-sm btn-info">Lihat Bukti Pengembalian</a>
                            @else
                                <span class="text-muted">Tidak ada aksi</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">Belum ada data peminjaman.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
