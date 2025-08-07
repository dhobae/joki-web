@extends('components.app')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-4">Dashboard User</h1>

        {{-- Statistik --}}
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card text-white bg-primary">
                    <div class="card-body">
                        <h5 class="card-title">Total Booking</h5>
                        <p class="card-text">{{ $stats['total_bookings'] ?? 0 }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-success">
                    <div class="card-body">
                        <h5 class="card-title">Room yang Sedang Kamu Booking</h5>
                        <p class="card-text">{{ $stats['user_active_rooms'] ?? 0 }}</p>
                    </div>
                </div>
            </div>
            {{-- Tambahkan statistik lain jika ada --}}
        </div>

        {{-- Navigasi Bulan --}}
        <div class="row mb-4">
            <div class="col-md-6">
                <form method="GET" action="{{ route('user.dashboard') }}">
                    <div class="input-group">
                        <select name="month" class="form-select">
                            @for ($m = 1; $m <= 12; $m++)
                                <option value="{{ $m }}" {{ $currentDate->month == $m ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                                </option>
                            @endfor
                        </select>
                        <select name="year" class="form-select">
                            @for ($y = now()->year - 2; $y <= now()->year + 2; $y++)
                                <option value="{{ $y }}" {{ $currentDate->year == $y ? 'selected' : '' }}>
                                    {{ $y }}
                                </option>
                            @endfor
                        </select>
                        <button class="btn btn-secondary" type="submit">Tampilkan</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Kalender --}}
        <div class="table-responsive mb-5">
            <table class="table table-bordered text-center align-middle">
                <thead class="table-light">
                    <tr>
                        @foreach (['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $day)
                            <th>{{ $day }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($calendar as $week)
                        <tr>
                            @foreach ($week as $day)
                                <td class="{{ $day['is_current_month'] ? '' : 'bg-light text-muted' }}">
                                    <div><strong>{{ $day['date']->day }}</strong></div>
                                    @if (!empty($day['bookings']))
                                        @foreach ($day['bookings'] as $booking)
                                            <div class="badge bg-info text-dark mt-1">
                                                {{ $booking['room_name'] }}<br>
                                                {{ $booking['user_name'] }}
                                            </div>
                                        @endforeach
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Daftar Booking (Opsional) --}}
        <div class="card mb-3">
            <div class="card-header">
                <h5>Daftar Booking Bulan Ini</h5>
            </div>
            <div class="card-body">
                @if ($bookings->isEmpty())
                    <p>Tidak ada booking di bulan ini.</p>
                @else
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nama User</th>
                                <th>Kamar</th>
                                <th>Check-in</th>
                                <th>Check-out</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bookings as $booking)
                                <tr>
                                    <td>{{ $booking->user->name }}</td>
                                    <td>{{ $booking->room->name }}</td>
                                    <td>{{ $booking->checkin_date->format('d M Y') }}</td>
                                    <td>{{ $booking->checkout_date->format('d M Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
@endsection
