@extends('components.app')

@section('content')
<div class="container">
    <h1>Daftar Booking</h1>
    <a class="btn btn-sm btn-primary" href="{{ route('admin.bookings.create') }}">Tambah Booking Manual</a>
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Judul</th>
                <th>User</th>
                <th>Ruangan</th>
                <th>Check-in</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bookings as $booking)
                <tr>
                    <td>{{ $booking->title }}</td>
                    <td>{{ $booking->user->name }}</td>
                    <td>{{ $booking->room->name }}</td>
                    <td>{{ $booking->checkin_date }}</td>
                    <td>{{ $booking->status }} ({{ $booking->confirmation_status }})</td>
                    <td>
                        <a href="{{ route('admin.bookings.show', $booking) }}" class="btn btn-info btn-sm">Detail</a>
                        <a href="{{ route('admin.bookings.edit', $booking) }}" class="btn btn-warning btn-sm">Edit</a>

                        <form action="{{ route('admin.bookings.destroy', $booking) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Hapus</button>
                        </form>

                        @if ($booking->confirmation_status === 'tentative')
                            <form action="{{ route('admin.bookings.confirm', $booking) }}" method="POST" class="d-inline">
                                @csrf @method('PATCH')
                                <button class="btn btn-success btn-sm">Konfirmasi</button>
                            </form>
                            <form action="{{ route('admin.bookings.cancel', $booking) }}" method="POST" class="d-inline">
                                @csrf @method('PATCH')
                                <button class="btn btn-secondary btn-sm">Tolak</button>
                            </form>
                        @endif

                        @if ($booking->status === 'used')
                            <form action="{{ route('admin.bookings.done', $booking) }}" method="POST" class="d-inline">
                                @csrf @method('PATCH')
                                <button class="btn btn-primary btn-sm">Selesai</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $bookings->links() }}
</div>
@endsection
