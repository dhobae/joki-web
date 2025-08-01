@extends('components.app')

@section('content')
<div class="container">
    <h2>Data Jenis</h2>
    <a href="{{ route('admin.jenis.create') }}" class="btn btn-primary mb-3">Tambah Jenis</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Nama Jenis</th>
            <th>Aksi</th>
        </tr>
        @foreach($jenis as $i => $item)
        <tr>
            <td>{{ $i+1 }}</td>
            <td>{{ $item->nama_jenis }}</td>
            <td>
                <a href="{{ route('admin.jenis.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('admin.jenis.destroy', $item->id) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button onclick="return confirm('Yakin?')" class="btn btn-danger btn-sm">Hapus</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
