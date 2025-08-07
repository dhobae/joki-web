@extends('components.app')

@section('content')
    <div class="card mb-5 py-3">
        <div class="card-body">
            <div class="container">
                <h1>Edit Booking</h1>

                <form action="{{ route('admin.bookings.update', $booking) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="room_id">Ruangan</label>
                        <select name="room_id" class="form-control" required>
                            @foreach ($rooms as $room)
                                <option value="{{ $room->id }}" @selected(old('room_id', $booking->room_id) == $room->id)>
                                    {{ $room->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Judul</label>
                        <input type="text" name="title" class="form-control"
                            value="{{ old('title', $booking->title) }}" required>
                    </div>

                    <div class="mb-3">
                        <label>Deskripsi</label>
                        <textarea name="description" class="form-control" rows="3" required>{{ old('description', $booking->description) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label>Check-in</label>
                        <input type="datetime-local" name="checkin_date" class="form-control"
                            value="{{ old('checkin_date', \Carbon\Carbon::parse($booking->checkin_date)->format('Y-m-d\TH:i')) }}"
                            required>
                    </div>

                    <div class="mb-3">
                        <label>Check-out</label>
                        <input type="datetime-local" name="checkout_date" class="form-control"
                            value="{{ old('checkout_date', \Carbon\Carbon::parse($booking->checkout_date)->format('Y-m-d\TH:i')) }}"
                            required>
                    </div>

                    <div class="mb-3">
                        <label>Jumlah Orang</label>
                        <input type="number" name="person_number" class="form-control"
                            value="{{ old('person_number', $booking->person_number) }}" required>
                    </div>

                    <div class="mb-3">
                        <label>Jenis Booking</label>
                        <select name="type" class="form-control" required>
                            <option value="internal" @selected(old('type', $booking->type) == 'internal')>Internal</option>
                            <option value="eksternal" @selected(old('type', $booking->type) == 'eksternal')>Eksternal</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Apakah Fullday?</label>
                        <select name="fullday" class="form-control">
                            <option value="0" @selected(old('fullday', $booking->fullday) == 0)>Tidak</option>
                            <option value="1" @selected(old('fullday', $booking->fullday) == 1)>Ya</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Jadwal Berulang</label>
                        <select name="repeat_schedule" id="repeat_schedule" class="form-control">
                            <option value="none" @selected(old('repeat_schedule', $booking->repeat_schedule) == 'none')>Tidak</option>
                            <option value="daily" @selected(old('repeat_schedule', $booking->repeat_schedule) == 'daily')>Harian</option>
                            <option value="weekly" @selected(old('repeat_schedule', $booking->repeat_schedule) == 'weekly')>Mingguan</option>
                            <option value="monthly" @selected(old('repeat_schedule', $booking->repeat_schedule) == 'monthly')>Bulanan</option>
                        </select>
                    </div>

                    <div class="mb-3" id="repeat_weekly_field" style="display: none;">
                        <label>Repeat Weekly (jika mingguan)</label>
                        <input type="text" name="repeat_weekly" class="form-control"
                            value="{{ old('repeat_weekly', $booking->repeat_weekly) }}" placeholder="cth: Monday,Wednesday">
                    </div>

                    <div class="mb-3" id="repeat_monthly_field" style="display: none;">
                        <label>Repeat Monthly (jika bulanan)</label>
                        <input type="text" name="repeat_monthly" class="form-control"
                            value="{{ old('repeat_monthly', $booking->repeat_monthly) }}" placeholder="cth: 1,15,30">
                    </div>

                    <div class="mb-3">
                        <label>Status</label>
                        <select name="status" class="form-control">
                            <option value="pending" @selected(old('status', $booking->status) == 'pending')>Pending</option>
                            <option value="used" @selected(old('status', $booking->status) == 'used')>Used</option>
                            <option value="done" @selected(old('status', $booking->status) == 'done')>Done</option>
                            <option value="canceled" @selected(old('status', $booking->status) == 'canceled')>Canceled</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Status Konfirmasi</label>
                        <select name="confirmation_status" class="form-control">
                            <option value="tentative" @selected(old('confirmation_status', $booking->confirmation_status) == 'tentative')>Tentative</option>
                            <option value="confirmed" @selected(old('confirmation_status', $booking->confirmation_status) == 'confirmed')>Confirmed</option>
                        </select>
                    </div>

                    <button class="btn btn-primary">Update</button>
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

            // Initialize on page load to show correct field based on current value
            toggleRepeatFields();
        });
    </script>
@endsection
