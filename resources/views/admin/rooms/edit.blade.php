@extends('components.app')

@section('content')
    <div class="container mt-4">
        <h1>Edit Ruangan</h1>

        <form action="{{ route('admin.rooms.update', $room) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Nama Ruangan</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $room->name) }}" required>
                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group mt-2">
                <label>Deskripsi</label>
                <textarea name="description" class="form-control">{{ old('description', $room->description) }}</textarea>
            </div>

            <div class="form-group mt-2">
                <label>Kapasitas</label>
                <input type="number" name="capacity" class="form-control" value="{{ old('capacity', $room->capacity) }}"
                    required>
                @error('capacity')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group mt-2">
                <label>Fasilitas</label>
                <textarea name="facilities" class="form-control">{{ old('facilities', $room->facilities) }}</textarea>
            </div>

            <div class="form-group mt-2">
                <label>Foto Lama</label>
                @if ($room->photo)
                    <img src="{{ asset('storage/' . $room->photo) }}" class="img-fluid">
                @endif

                <label>Foto Baru</label>
                <input type="file" name="photo" class="form-control" value="{{ old('photo', $room->photo) }}">
            </div>

            <div class="form-group form-check mt-3">
                <input type="checkbox" class="form-check-input" name="is_active" id="is_active" value="1"
                    {{ $room->is_active ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">Aktif</label>
            </div>

            <button type="submit" class="btn btn-success mt-3">Perbarui</button>
            <a href="{{ route('admin.rooms.index') }}" class="btn btn-secondary mt-3">Kembali</a>
        </form>
    </div>
@endsection
