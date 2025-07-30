@extends('components.app')

@section('content')
    <div class="container">
        <h1>Edit Booking</h1>
        <form action="{{ route('admin.bookings.update', $booking->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Pengguna</label>
                <select name="user_id" class="form-control">
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ $booking->user_id == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Ruangan</label>
                <select name="room_id" class="form-control">
                    @foreach ($rooms as $room)
                        <option value="{{ $room->id }}" {{ $booking->room_id == $room->id ? 'selected' : '' }}>
                            {{ $room->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Check-in</label>
                <input type="datetime-local" name="checkin_date" class="form-control"
                    value="{{ date('Y-m-d\TH:i', strtotime($booking->checkin_date)) }}">
            </div>

            <div class="form-group">
                <label>Check-out</label>
                <input type="datetime-local" name="checkout_date" class="form-control"
                    value="{{ date('Y-m-d\TH:i', strtotime($booking->checkout_date)) }}">
            </div>

            <div class="form-group">
                <label>Jumlah Orang</label>
                <input type="number" name="person_number" class="form-control" value="{{ $booking->person_number }}">
            </div>

            <div class="form-group">
                <label>Judul</label>
                <input type="text" name="title" class="form-control" value="{{ $booking->title }}">
            </div>

            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="description" class="form-control">{{ $booking->description }}</textarea>
            </div>

            <div class="form-group">
                <label>Tipe</label>
                <select name="type" class="form-control">
                    <option value="internal" {{ $booking->type == 'internal' ? 'selected' : '' }}>Internal</option>
                    <option value="eksternal" {{ $booking->type == 'eksternal' ? 'selected' : '' }}>Eksternal</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection
