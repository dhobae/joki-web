@extends('components.app')

@section('content')
<div class="container">
    <h3>Tambah Mobil</h3>
    <form action="{{ route('admin.mobil.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('admin.mobil.form')
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('admin.mobil.index') }}" class="btn btn-dark">Kembali</a>
    </form>
</div>
@endsection
