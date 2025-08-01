@extends('components.app')

@section('content')
    <div class="container mt-4">
        <h3>Form Pengembalian Mobil</h3>

        <form action="{{ route('karyawan.peminjaman.pengembalian.store', $peminjaman->id) }}" method="POST"
            enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="bukti_pengembalian" class="form-label">Unggah Bukti Pengembalian (Foto)</label>
                <input type="file" name="bukti_pengembalian" class="form-control" accept="image/*" required>
                @error('bukti_pengembalian')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-success">Kembalikan Mobil</button>
            <a href="{{ route('karyawan.peminjaman.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection
