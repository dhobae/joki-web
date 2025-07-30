@extends('components.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="container-fluid my-2 p-2">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1>Daftar Ruangan</h1>
                    <a href="{{ route('admin.rooms.create') }}" class="btn btn-primary mb-3">Tambah Ruangan</a>
                </div>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Kapasitas</th>
                            <th>Foto</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rooms as $room)
                            <tr>
                                <td>{{ $room->name }}</td>
                                <td>{{ $room->capacity }}</td>
                                <td>
                                    @if ($room->photo)
                                        <img src="{{ asset('storage/' . $room->photo) }}" class="img-fluid" style="max-height: 200px;">
                                    @endif
                                </td>
                                <td>{{ $room->is_active ? 'Aktif' : 'Nonaktif' }}</td>
                                <td>
                                    <a href="{{ route('admin.rooms.edit', $room) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('admin.rooms.destroy', $room) }}" method="POST"
                                        style="display:inline;">
                                        @csrf @method('DELETE')
                                        <button onclick="return confirm('Yakin ingin menghapus?')"
                                            class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
