@extends('components.app')

@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css">
@endpush

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#booking-table').DataTable({
                theme: 'bootstrap' // untuk versi DataTables 2.x
            });
        });
    </script>
@endpush

@section('content')
    <div class="card">
        <div class="card-body">

            <div class="container-fluid">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="d-flex justify-content-between align-items-center">
                    <h1>Riwayat Booking</h1>
                    <a href="{{ route('user.bookings.create') }}" class="btn btn-primary mb-3">Buat Booking Baru</a>

                </div>

                <table class="table" id="booking-table">
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
                                    <a href="{{ route('user.bookings.show', $booking) }}"
                                        class="btn btn-info btn-sm">Lihat</a>
                                    @if ($booking->confirmation_status === 'tentative')
                                        <form action="{{ route('user.bookings.cancel', $booking) }}" method="POST"
                                            class="d-inline">
                                            @csrf @method('PATCH')
                                            <button class="btn btn-danger btn-sm">Cancel Booking</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">Belum ada booking.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection
