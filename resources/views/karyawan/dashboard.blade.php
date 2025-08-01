@extends('components.app')

@section('content')
<h2>Dashboard Karyawan</h2>
<p>Halo, {{ auth()->user()->peran }}</p>
<form action="{{ route('logout') }}" method="POST">@csrf <button type="submit">Logout</button></form>

@endsection
{{-- done bangggg --}}
{{-- jalani admin lwn user nya kypa tdi ada kata tambahan kh di samping kode nya
samping kode kyp?
ya  --}}
