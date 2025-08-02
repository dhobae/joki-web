@extends('components.app')

@section('content')
    <div class="container">
        <h1>Riwayat Booking</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <a href="{{ route('user.bookings.create') }}" class="btn btn-primary mb-3">Buat Booking Baru</a>

        <table class="table">
            <thead>
                <tr>
                    <th>Ruangan</th>
                    <th>Judul</th>
                    <th>Check-in</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($bookings as $booking)
                    <tr>
                        <td>{{ $booking->room->name }}</td>
                        <td>{{ $booking->title }}</td>
                        <td>{{ $booking->checkin_date }}</td>
                        <td>{{ $booking->status }} ({{ $booking->confirmation_status }})</td>
                        <td>
                            <a href="{{ route('user.bookings.show', $booking) }}" class="btn btn-info btn-sm">Lihat</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">Belum ada booking.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $bookings->links() }}
    </div>
@endsection
