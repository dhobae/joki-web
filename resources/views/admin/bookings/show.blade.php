@extends('components.app')

@section('content')
<div class="container">
    <h1>Detail Booking</h1>

    <div class="card">
        <div class="card-body">
            <p><strong>Judul:</strong> {{ $booking->title }}</p>
            <p><strong>Deskripsi:</strong> {{ $booking->description }}</p>
            <p><strong>Pengguna:</strong> {{ $booking->user->name }}</p>
            <p><strong>Ruangan:</strong> {{ $booking->room->name }}</p>
            <p><strong>Check-in:</strong> {{ $booking->checkin_date }}</p>
            <p><strong>Check-out:</strong> {{ $booking->checkout_date }}</p>
            <p><strong>Jumlah Orang:</strong> {{ $booking->person_number }}</p>
            <p><strong>Status:</strong> {{ $booking->status }}</p>
            <p><strong>Tipe:</strong> {{ $booking->type }}</p>
        </div>
    </div>

    <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary mt-3">Kembali</a>
</div>
@endsection
