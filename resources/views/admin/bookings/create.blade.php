@extends('components.app')

@section('content')
    <div class="card mb-5">
        <div class="card-body">
            <div class="container-fluid">
                <h1>Tambah Booking Baru</h1>

                <form action="{{ route('admin.bookings.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="user_id">User</label>
                        <select name="user_id" class="form-control" required>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="room_id">Ruangan</label>
                        <select name="room_id" class="form-control" required>
                            @foreach ($rooms as $room)
                                <option value="{{ $room->id }}">{{ $room->name }}</option>
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
                        <label>Apakah Fullday?</label>
                        <select name="fullday" class="form-control">
                            <option value="0">Tidak</option>
                            <option value="1">Ya</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Jadwal Berulang</label>
                        <select name="repeat_schedule" id="repeat_schedule" class="form-control">
                            <option value="none">Tidak</option>
                            <option value="daily">Harian</option>
                            <option value="weekly">Mingguan</option>
                            <option value="monthly">Bulanan</option>
                        </select>
                    </div>

                    <div class="mb-3" id="repeat_weekly_field" style="display: none;">
                        <label>Repeat Weekly (jika mingguan)</label>
                        <input type="text" name="repeat_weekly" class="form-control" placeholder="cth: Monday,Wednesday"
                            value="">
                    </div>

                    <div class="mb-3" id="repeat_monthly_field" style="display: none;">
                        <label>Repeat Monthly (jika bulanan)</label>
                        <input type="text" name="repeat_monthly" class="form-control" placeholder="cth: 1,15,30"
                            value="">
                    </div>

                    <div class="mb-3">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="pending">Pending</option>
                            <option value="used">Used</option>
                            <option value="done">Done</option>
                            <option value="canceled">Canceled</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Konfirmasi</label>
                        <select name="confirmation_status" class="form-control">
                            <option value="tentative">Tentative</option>
                            <option value="confirmed">Confirmed</option>
                        </select>
                    </div>

                    <button class="btn btn-primary">Simpan</button>
                    <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const repeatSchedule = document.getElementById('repeat_schedule');
            const repeatWeeklyField = document.getElementById('repeat_weekly_field');
            const repeatMonthlyField = document.getElementById('repeat_monthly_field');

            function toggleRepeatFields() {
                const value = repeatSchedule.value;

                // Hide all fields first
                repeatWeeklyField.style.display = 'none';
                repeatMonthlyField.style.display = 'none';

                // Show relevant field based on selection
                if (value === 'weekly') {
                    repeatWeeklyField.style.display = 'block';
                } else if (value === 'monthly') {
                    repeatMonthlyField.style.display = 'block';
                }
            }

            // Listen for changes on repeat_schedule
            repeatSchedule.addEventListener('change', toggleRepeatFields);

            // Initialize on page load
            toggleRepeatFields();
        });
    </script>
@endsection
