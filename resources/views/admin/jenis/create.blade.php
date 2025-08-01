@extends('components.app')

@section('content')
<div class="container">
    <h2>Tambah Jenis</h2>

    <form action="{{ route('admin.jenis.store') }}" method="POST">
        @csrf
        <div class="form-group mb-3">
            <label>Nama Jenis</label>
            <input type="text" name="nama_jenis" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('admin.jenis.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
