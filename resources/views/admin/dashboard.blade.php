@extends('components.app')

@section('content')
    <h2>Dashboard Admin</h2>
    <p>Selamat datang, {{ auth()->user()->name }}</p>
    <form action="{{ route('logout') }}" method="POST">@csrf <button type="submit" class="btn btn-danger">Logout</button></form>
@endsection
