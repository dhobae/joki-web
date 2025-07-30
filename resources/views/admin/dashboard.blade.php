@extends('components.app')

@section('content')
    <div>Hello {{ Auth()->user()->role }}</div>
@endsection
