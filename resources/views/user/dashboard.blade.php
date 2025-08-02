@extends('components.app')

@section('content')
    <div>Hello {{ Auth()->user()->name }}, role : {{ Auth()->user()->role }}</div>
@endsection
