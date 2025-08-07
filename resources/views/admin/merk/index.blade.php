@extends('components.app')

@section('content')
    <div class="container">
        <h2>Data Merk</h2>
        <a href="{{ route('admin.merk.create') }}" class="btn btn-primary mb-3">Tambah Merk</a>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered" id="tabelMerk">
            <thead>

                <tr>
                    <th style="width: 3%">No</th>
                    <th>Nama Merk</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($merk as $i => $item)
                    <tr>
                        <td style="width: 3%">{{ $i + 1 }}</td>
                        <td>{{ $item->nama_merk }}</td>
                        <td>
                            <a href="{{ route('admin.merk.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('admin.merk.destroy', $item->id) }}" method="POST"
                                style="display:inline;">
                                @csrf @method('DELETE')
                                <button onclick="return confirm('Yakin?')" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@push('scripts')
    <!-- Inisialisasi DataTables -->
    <script>
        $(document).ready(function() {
            $('#tabelMerk').DataTable({
                columnDefs: [{
                    targets: 2, // Kolom 'No'
                    orderable: false,
                    searchable: false,
                    className: 'text-center',
                }, ]
            });
        });
    </script>
@endpush
