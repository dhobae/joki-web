@extends('components.app')

@section('content')
    <div class="container">
        <h1>Tambah Booking</h1>
        <form action="{{ route('admin.bookings.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Pengguna</label>
                <select name="user_id" class="form-control">
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Ruangan</label>
                <select name="room_id" class="form-control">
                    @foreach ($rooms as $room)
                        <option value="{{ $room->id }}">{{ $room->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Check-in</label>
                <input type="datetime-local" name="checkin_date" class="form-control">
            </div>

            <div class="form-group">
                <label>Check-out</label>
                <input type="datetime-local" name="checkout_date" class="form-control">
            </div>

            <div class="form-group">
                <label>Jumlah Orang</label>
                <input type="number" name="person_number" class="form-control">
            </div>

            <div class="form-group">
                <label>Judul</label>
                <input type="text" name="title" class="form-control">
            </div>

            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="description" class="form-control"></textarea>
            </div>

            <div class="form-group">
                <label>Tipe</label>
                <select name="type" class="form-control">
                    <option value="internal">Internal</option>
                    <option value="eksternal">Eksternal</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection
