@extends('components.app')

@section('content')
    <div class="container">
        <h1>Detail Booking</h1>

        <dl class="row">
            <dt class="col-sm-3">Ruangan</dt>
            <dd class="col-sm-9">{{ $booking->room->name }}</dd>

            <dt class="col-sm-3">Judul</dt>
            <dd class="col-sm-9">{{ $booking->title }}</dd>

            <dt class="col-sm-3">Deskripsi</dt>
            <dd class="col-sm-9">{{ $booking->description }}</dd>

            <dt class="col-sm-3">Check-in</dt>
            <dd class="col-sm-9">{{ $booking->checkin_date }}</dd>

            <dt class="col-sm-3">Check-out</dt>
            <dd class="col-sm-9">{{ $booking->checkout_date }}</dd>

            <dt class="col-sm-3">Jumlah Orang</dt>
            <dd class="col-sm-9">{{ $booking->person_number }}</dd>

            <dt class="col-sm-3">Jenis</dt>
            <dd class="col-sm-9">{{ ucfirst($booking->type) }}</dd>

            <dt class="col-sm-3">Fullday</dt>
            <dd class="col-sm-9">{{ $booking->fullday ? 'Ya' : 'Tidak' }}</dd>

            <dt class="col-sm-3">Status</dt>
            <dd class="col-sm-9">{{ $booking->status }}</dd>

            <dt class="col-sm-3">Konfirmasi</dt>
            <dd class="col-sm-9">{{ $booking->confirmation_status }}</dd>
        </dl>

        <a href="{{ route('user.bookings.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
@endsection
