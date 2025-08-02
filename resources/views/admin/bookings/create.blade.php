@extends('components.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Tambah Booking</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.bookings.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="user_id">Pengguna</label>
            <select name="user_id" id="user_id" class="form-control" required>
                <option value="">-- Pilih Pengguna --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }} ({{ $user->email }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="room_id">Ruangan</label>
            <select name="room_id" id="room_id" class="form-control" required>
                <option value="">-- Pilih Ruangan --</option>
                @foreach($rooms as $room)
                    <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>
                        {{ $room->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="checkin_date">Tanggal Mulai</label>
            <input type="datetime-local" name="checkin_date" id="checkin_date" class="form-control"
                   value="{{ old('checkin_date') }}" required>
        </div>

        <div class="form-group">
            <label for="checkout_date">Tanggal Selesai</label>
            <input type="datetime-local" name="checkout_date" id="checkout_date" class="form-control"
                   value="{{ old('checkout_date') }}" required>
        </div>

        <div class="form-group">
            <label for="person_number">Jumlah Orang</label>
            <input type="number" name="person_number" id="person_number" class="form-control"
                   value="{{ old('person_number') }}" required min="1">
        </div>

        <div class="form-group">
            <label for="title">Judul</label>
            <input type="text" name="title" id="title" class="form-control"
                   value="{{ old('title') }}" required>
        </div>

        <div class="form-group">
            <label for="description">Deskripsi</label>
            <textarea name="description" id="description" class="form-control" rows="3" required>{{ old('description') }}</textarea>
        </div>

        <div class="form-group">
            <label for="type">Jenis</label>
            <select name="type" id="type" class="form-control" required>
                <option value="internal" {{ old('type') == 'internal' ? 'selected' : '' }}>Internal</option>
                <option value="eksternal" {{ old('type') == 'eksternal' ? 'selected' : '' }}>Eksternal</option>
            </select>
        </div>

        <div class="form-group">
            <label for="repeat_schedule">Jadwal Pengulangan</label>
            <select name="repeat_schedule" id="repeat_schedule" class="form-control">
                <option value="none" {{ old('repeat_schedule') == 'none' ? 'selected' : '' }}>Tidak Ada</option>
                <option value="daily" {{ old('repeat_schedule') == 'daily' ? 'selected' : '' }}>Harian</option>
                <option value="weekly" {{ old('repeat_schedule') == 'weekly' ? 'selected' : '' }}>Mingguan</option>
                <option value="monthly" {{ old('repeat_schedule') == 'monthly' ? 'selected' : '' }}>Bulanan</option>
            </select>
        </div>

        <div class="form-group">
            <label for="repeat_weekly">Ulang Mingguan</label>
            <input type="text" name="repeat_weekly" id="repeat_weekly" class="form-control"
                   value="{{ old('repeat_weekly') }}">
        </div>

        <div class="form-group">
            <label for="repeat_monthly">Ulang Bulanan</label>
            <input type="text" name="repeat_monthly" id="repeat_monthly" class="form-control"
                   value="{{ old('repeat_monthly') }}">
        </div>

        <div class="form-check">
            <input type="checkbox" name="fullday" id="fullday" class="form-check-input" value="1"
                   {{ old('fullday') ? 'checked' : '' }}>
            <label for="fullday" class="form-check-label">Sehari Penuh</label>
        </div>

        <div class="form-group mt-3">
            <label for="confirmation_status">Status Konfirmasi</label>
            <select name="confirmation_status" id="confirmation_status" class="form-control" required>
                <option value="tentative" {{ old('confirmation_status') == 'tentative' ? 'selected' : '' }}>Tentatif</option>
                <option value="confirmed" {{ old('confirmation_status') == 'confirmed' ? 'selected' : '' }}>Terkonfirmasi</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
