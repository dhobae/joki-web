@extends('components.app')

@section('content')
<div class="container">
    <h3>Daftar Mobil</h3>
    <a href="{{ route('admin.mobil.create') }}" class="btn btn-primary mb-3">Tambah Mobil</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Plat</th>
                <th>Merk</th>
                <th>Jenis</th>
                <th>Model</th>
                <th>Kapasitas</th>
                <th>Status</th>
                <th>Foto</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($mobils as $mobil)
                <tr>
                    <td>{{ $mobil->plat_mobil }}</td>
                    <td>{{ $mobil->merk->nama_merk }}</td>
                    <td>{{ $mobil->jenis->nama_jenis }}</td>
                    <td>{{ $mobil->model }}</td>
                    <td>{{ $mobil->kapasitas }}</td>
                    <td>{{ $mobil->status_mobil }}</td>
                    <td>
                        @if($mobil->foto_mobil)
                            <img src="{{ asset('storage/' . $mobil->foto_mobil) }}" width="80">
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.mobil.edit', $mobil->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('admin.mobil.destroy', $mobil->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Yakin hapus?')" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
