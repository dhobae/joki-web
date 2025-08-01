@extends('components.app')

@section('content')
    <div class="container mt-4">
        <h3>Detail Peminjaman</h3>

        <div class="mb-3">
            <strong>Mobil:</strong> {{ $peminjaman->mobil->model }} - {{ $peminjaman->mobil->plat_mobil }}
        </div>

        <div class="mb-3">
            <strong>Tanggal Pinjam:</strong> {{ $peminjaman->tanggal_pinjam }}
        </div>

        <div class="mb-3">
            <strong>Status:</strong> {{ ucfirst($peminjaman->status_peminjaman) }}
        </div>

        @if ($peminjaman->tanggal_pengembalian)
            <div class="mb-3">
                <strong>Tanggal Pengembalian:</strong> {{ $peminjaman->tanggal_pengembalian }}
            </div>
        @endif

        @if ($peminjaman->bukti_pengembalian)
            <div class="mb-3">
                <strong>Bukti Pengembalian:</strong><br>
                <img src="{{ asset('storage/' . $peminjaman->bukti_pengembalian) }}" width="300">
            </div>
        @endif

        <a href="{{ route('karyawan.peminjaman.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
@endsection
