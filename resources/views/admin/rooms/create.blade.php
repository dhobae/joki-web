@extends('components.app')

@section('content')
    <div class="container mt-4">
        <h1>Tambah Ruangan</h1>

        <form action="{{ route('admin.rooms.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label>Nama Ruangan</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group mt-2">
                <label>Deskripsi</label>
                <textarea name="description" class="form-control">{{ old('description') }}</textarea>
            </div>

            <div class="form-group mt-2">
                <label>Kapasitas</label>
                <input type="number" name="capacity" class="form-control" value="{{ old('capacity') }}" required>
                @error('capacity')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group mt-2">
                <label>Fasilitas</label>
                <textarea name="facilities" class="form-control">{{ old('facilities') }}</textarea>
            </div>

            <div class="form-group mt-2">
                <label>Foto (URL)</label>
                <input type="file" name="photo" class="form-control" value="{{ old('photo') }}">
            </div>

            <div class="form-group form-check mt-3">
                <input type="checkbox" class="form-check-input" name="is_active" id="is_active" value="1" checked>
                <label class="form-check-label" for="is_active">Aktif</label>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Simpan</button>
            <a href="{{ route('admin.rooms.index') }}" class="btn btn-secondary mt-3">Kembali</a>
        </form>
    </div>
@endsection
