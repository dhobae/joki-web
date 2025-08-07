@extends('components.app')

@push('css')
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
@endpush


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

                <table class="table table-bordered" id="roomTable">
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
                                        <img src="{{ asset('storage/' . $room->photo) }}" class="img-fluid"
                                            style="max-height: 200px;">
                                    @endif
                                </td>
                                <td>{{ $room->is_active ? 'Aktif' : 'Nonaktif' }}</td>
                                <td>
                                    <a href="{{ route('admin.rooms.show', $room->id) }}" class="btn btn-sm btn-info">Detail</a>
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


@push('scripts')
    <!-- jQuery (wajib untuk DataTables) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#roomTable').DataTable({
                "order": [
                    [0, "desc"]
                ],
                "columnDefs": [{
                    "targets": [2,3,4], // kolom ke-4 (indeks mulai dari 0)
                    "orderable": false // kolom tidak bisa diurutkan
                }]
            });
        });
    </script>
@endpush
