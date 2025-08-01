@extends('components.app')

@section('content')
<div class="container">
    <h2>Edit Jenis</h2>

    <form action="{{ route('admin.jenis.update', $jeni->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="form-group mb-3">
            <label>Nama Jenis</label>
            <input type="text" name="nama_jenis" value="{{ $jeni->nama_jenis }}" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('admin.jenis.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
