@extends('components.app')

@section('content')
    <div class="container mt-4">
        <h3>Daftar Peminjaman Saya</h3>
        <a href="{{ route('karyawan.peminjaman.create') }}" class="btn btn-primary my-3">Pinjam Mobil</a>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Mobil</th>
                    <th>Tanggal Pinjam</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($peminjamans as $p)
                    <tr>
                        <td>{{ $p->mobil->model }} ({{ $p->mobil->plat_mobil }})</td>
                        <td>{{ $p->tanggal_pinjam }}</td>
                        <td>{{ ucfirst($p->status_peminjaman) }}</td>
                        <td>
                            <a href="{{ route('karyawan.peminjaman.show', $p->id) }}" class="btn btn-info btn-sm">Detail</a>
                            @if ($p->status_peminjaman === 'dipinjam')
                                <a href="{{ route('karyawan.peminjaman.pengembalian.form', $p->id) }}"
                                    class="btn btn-warning btn-sm">Kembalikan</a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">Belum ada data peminjaman.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
