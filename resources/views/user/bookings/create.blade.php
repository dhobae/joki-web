@extends('components.app')

@section('content')
    <div class="card mb-4">
        <div class="card-body ">
            <div class="container-fluid">
                <h1>Buat Booking Baru</h1>

                <form action="{{ route('user.bookings.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="room_id">Ruangan</label>
                        <select name="room_id" class="form-control" required>
                            @foreach ($rooms as $room)
                                <option value="{{ $room->id }}">{{ $room->name }} (Kapasitas: {{ $room->capacity }})
                                </option>
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

                    <div class="mb-3">
                        <label>Type?</label>
                        <select name="type_pemesanan" class="form-control">
                            <option value="luring">Luring</option>
                            <option value="daring">Daring</option>
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

                    <button class="btn btn-primary">Kirim Booking</button>
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
