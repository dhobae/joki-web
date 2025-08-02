@extends('components.app')

@section('content')
<div class="container">
    <h1>Buat Booking Baru</h1>

    <form action="{{ route('user.bookings.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="room_id">Ruangan</label>
            <select name="room_id" class="form-control" required>
                @foreach ($rooms as $room)
                    <option value="{{ $room->id }}">{{ $room->name }} (Kapasitas: {{ $room->capacity }})</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Judul</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="description" class="form-control" rows="3" required></textarea>
        </div>

        <div class="mb-3">
            <label>Check-in</label>
            <input type="datetime-local" name="checkin_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Check-out</label>
            <input type="datetime-local" name="checkout_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Jumlah Orang</label>
            <input type="number" name="person_number" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Jenis Booking</label>
            <select name="type" class="form-control" required>
                <option value="internal">Internal</option>
                <option value="eksternal">Eksternal</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Fullday?</label>
            <select name="fullday" class="form-control">
                <option value="0">Tidak</option>
                <option value="1">Ya</option>
            </select>
        </div>

        <button class="btn btn-primary">Kirim Booking</button>
    </form>
</div>
@endsection
