@extends('components.app')

@section('content')
<div class="container">
    <h1>Detail Booking</h1>

    <dl class="row">
        <dt class="col-sm-3">User</dt>
        <dd class="col-sm-9">{{ $booking->user->name }} ({{ $booking->user->email }})</dd>

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

        <dt class="col-sm-3">Jenis Booking</dt>
        <dd class="col-sm-9">{{ ucfirst($booking->type) }}</dd>

        <dt class="col-sm-3">Fullday</dt>
        <dd class="col-sm-9">{{ $booking->fullday ? 'Ya' : 'Tidak' }}</dd>

        <dt class="col-sm-3">Jadwal Berulang</dt>
        <dd class="col-sm-9">{{ ucfirst($booking->repeat_schedule) }}</dd>

        @if($booking->repeat_schedule === 'weekly')
            <dt class="col-sm-3">Hari Berulang</dt>
            <dd class="col-sm-9">{{ $booking->repeat_weekly }}</dd>
        @endif

        @if($booking->repeat_schedule === 'monthly')
            <dt class="col-sm-3">Tanggal Berulang</dt>
            <dd class="col-sm-9">{{ $booking->repeat_monthly }}</dd>
        @endif

        <dt class="col-sm-3">Status</dt>
        <dd class="col-sm-9">{{ $booking->status }}</dd>

        <dt class="col-sm-3">Konfirmasi</dt>
        <dd class="col-sm-9">{{ $booking->confirmation_status }}</dd>
    </dl>

    <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection
