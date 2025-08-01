@extends('components.app')

@section('content')
    <div class="container">
        <h3>Edit Mobil</h3>
        <form action="{{ route('admin.mobil.update', $mobil->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.mobil.form')
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('admin.mobil.index') }}" class="btn btn-dark">Kembali</a>
            </div>
        </form>
    </div>
@endsection
