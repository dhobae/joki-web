@extends('components.app')

@section('content')
    <div class="container mt-4">
        <h3>Bukti Pengembalian</h3>

        <div class="mb-3">
            <strong>Nama Peminjam:</strong> {{ $peminjaman->user->name }}<br>
            <strong>Mobil:</strong> {{ $peminjaman->mobil->model }} ({{ $peminjaman->mobil->plat_mobil }})<br>
            <strong>Tanggal Pengembalian:</strong> {{ $peminjaman->tanggal_pengembalian }}
        </div>

        <div class="mb-3">
            <img src="{{ asset('storage/' . $peminjaman->bukti_pengembalian) }}" class="img-fluid rounded"
                alt="Bukti Pengembalian">
        </div>

        <a href="{{ route('admin.peminjaman.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
@endsection
