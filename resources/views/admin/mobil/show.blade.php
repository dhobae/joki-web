@extends('components.app')

@section('content')
    <div class="container mt-4">
        <h3>Detail Mobil</h3>
        <div class="card mt-3">
            <div class="card-body">
                <h5 class="card-title">{{ $mobil->model }} ({{ $mobil->plat_mobil }})</h5>
                <p><strong>Merk:</strong> {{ $mobil->merk->nama_merk }}</p>
                <p><strong>Jenis:</strong> {{ $mobil->jenis->nama_jenis }}</p>
                <p><strong>Kapasitas:</strong> {{ $mobil->kapasitas }} orang</p>
                <p><strong>Status:</strong> {{ $mobil->status_mobil }}</p>
                <p><strong>Catatan:</strong> {{ $mobil->catatan_lain ?? '-' }}</p>
                @if ($mobil->foto_mobil)
                    <p><strong>Foto:</strong></p>
                    <img src="{{ asset('storage/' . $mobil->foto_mobil) }}" alt="Foto Mobil" class="img-fluid"
                        style="max-width: 300px;">
                @endif
                <div class="row">
                    <div class="col">
                        <a href="{{ route('admin.mobil.index') }}" class="btn btn-secondary mt-3">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
