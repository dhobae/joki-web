@extends('components.app')

@section('content')
    <div class="container">
        <h2>Tambah Merk</h2>

        <form action="{{ route('admin.merk.store') }}" method="POST">
            @csrf
            <div class="form-group mb-3">
                <label>Nama Merk</label>
                <input type="text" name="nama_merk" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.merk.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
@endsection
