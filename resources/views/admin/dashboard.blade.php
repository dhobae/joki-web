@extends('components.app')


@section('content')
    <div class="container-fluid">
        {{-- Header --}}
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="h3 mb-0">Dashboard Admin</h1>
                    <div class="d-flex align-items-center gap-3">
                        {{-- Navigation Bulan --}}
                        <div class="btn-group" role="group">
                            <a href="{{ route('admin.dashboard', ['month' => $currentDate->copy()->subMonth()->month, 'year' => $currentDate->copy()->subMonth()->year]) }}"
                                class="btn btn-outline-primary">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                            <button class="btn btn-outline-primary">
                                {{ $currentDate->format('F Y') }}
                            </button>
                            <a href="{{ route('admin.dashboard', ['month' => $currentDate->copy()->addMonth()->month, 'year' => $currentDate->copy()->addMonth()->year]) }}"
                                class="btn btn-outline-primary">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Statistics Cards --}}
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Booking Bulan Ini
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $stats['total_bookings_this_month'] }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Pending Approval
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $stats['tentative_bookings'] }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clock fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Confirmed Bookings
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $stats['confirmed_bookings'] }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-3">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Total Ruangan
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    {{ $stats['total_rooms'] }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-door-open fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Calendar Section --}}
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Kalender Booking Room</h6>
                    </div>
                    <div class="card-body">
                        {{-- Calendar Header --}}
                        <div class="table-responsive">
                            <table class="table table-bordered calendar-table">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-center" style="width: 14.28%;">Senin</th>
                                        <th class="text-center" style="width: 14.28%;">Selasa</th>
                                        <th class="text-center" style="width: 14.28%;">Rabu</th>
                                        <th class="text-center" style="width: 14.28%;">Kamis</th>
                                        <th class="text-center" style="width: 14.28%;">Jumat</th>
                                        <th class="text-center" style="width: 14.28%;">Sabtu</th>
                                        <th class="text-center" style="width: 14.28%;">Minggu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($calendar as $week)
                                        <tr>
                                            @foreach ($week as $day)
                                                <td class="calendar-day {{ !$day['is_current_month'] ? 'other-month' : '' }} {{ $day['is_today'] ? 'today' : '' }}"
                                                    style="height: 120px; vertical-align: top; position: relative;">

                                                    {{-- Date Number --}}
                                                    <div
                                                        class="date-number {{ $day['is_today'] ? 'text-white' : ($day['is_current_month'] ? 'text-dark' : 'text-muted') }}">
                                                        {{ $day['day'] }}
                                                    </div>

                                                    {{-- Bookings for this day --}}
                                                    @if (count($day['bookings']) > 0)
                                                        <div class="bookings-container mt-1">
                                                            @foreach (array_slice($day['bookings'], 0, 3) as $booking)
                                                                <div class="booking-item mb-1 cursor-pointer"
                                                                    data-booking-id="{{ $booking['id'] }}"
                                                                    data-toggle="modal" data-target="#bookingModal"
                                                                    title="{{ $booking['title'] }} - {{ $booking['room_name'] }}">

                                                                    <div
                                                                        class="booking-card 
                                                        {{ $booking['status'] === 'pending' ? 'bg-warning' : '' }}
                                                        {{ $booking['status'] === 'confirmed' ? 'bg-success' : '' }}
                                                        {{ $booking['status'] === 'used' ? 'bg-info' : '' }}
                                                        {{ $booking['status'] === 'done' ? 'bg-secondary' : '' }}
                                                        {{ $booking['status'] === 'canceled' ? 'bg-danger' : '' }}
                                                        text-white">

                                                                        <div class="booking-title">
                                                                            {{ Str::limit($booking['title'], 15) }}
                                                                        </div>
                                                                        <div class="booking-room">
                                                                            <small>{{ Str::limit($booking['room_name'], 12) }}</small>
                                                                        </div>
                                                                        @if (!$booking['fullday'])
                                                                            <div class="booking-time">
                                                                                <small>{{ \Carbon\Carbon::parse($booking['checkin_date'])->format('H:i') }}</small>
                                                                            </div>
                                                                        @else
                                                                            <div class="booking-time">
                                                                                <small>Full Day</small>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            @endforeach

                                                            @if (count($day['bookings']) > 3)
                                                                <div class="more-bookings">
                                                                    <small
                                                                        class="text-muted">+{{ count($day['bookings']) - 3 }}
                                                                        lainnya</small>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @endif
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Legend --}}
        <div class="row mt-3 mb-3">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h6 class="font-weight-bold mb-3">Keterangan Status:</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="legend-color bg-warning mr-2"></div>
                                    <span>Pending - Menunggu konfirmasi</span>
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <div class="legend-color bg-info mr-2"></div>
                                    <span>Used - Sedang digunakan</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center mb-2">
                                    <div class="legend-color bg-success mr-2"></div>
                                    <span>Done - Selesai</span>
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <div class="legend-color bg-danger mr-2"></div>
                                    <span>Canceled - Dibatalkan</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Detail Booking --}}
    <div class="modal fade" id="bookingModal" tabindex="-1" role="dialog" aria-labelledby="bookingModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bookingModalLabel">Detail Booking</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="bookingModalBody">
                    <div class="text-center">
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <div id="bookingActions"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <style>
        .calendar-table {
            font-size: 0.875rem;
        }

        .calendar-day {
            padding: 8px;
            border: 1px solid #e3e6f0;
        }

        .calendar-day.other-month {
            background-color: #f8f9fc;
        }

        .calendar-day.today {
            background-color: #4e73df;
        }

        .date-number {
            font-weight: bold;
            font-size: 14px;
        }

        .booking-card {
            padding: 3px 6px;
            border-radius: 3px;
            font-size: 11px;
            line-height: 1.2;
        }

        .booking-title {
            font-weight: 500;
        }

        .booking-room,
        .booking-time {
            opacity: 0.9;
        }

        .more-bookings {
            text-align: center;
            font-style: italic;
        }

        .legend-color {
            width: 20px;
            height: 15px;
            border-radius: 3px;
        }

        .cursor-pointer {
            cursor: pointer;
        }

        .booking-item:hover .booking-card {
            opacity: 0.8;
            transform: scale(1.02);
            transition: all 0.2s ease;
        }

        /* Custom scrollbar untuk modal */
        .modal-body {
            max-height: 70vh;
            overflow-y: auto;
        }

        /* Badge styles */
        .bg-status {
            font-size: 0.75rem;
        }

        .bg-tentative {
            background-color: #f6c23e;
            color: #fff;
        }

        .bg-confirmed {
            background-color: #1cc88a;
            color: #fff;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            // Handle booking item click
            $('.booking-item').on('click', function() {
                const bookingId = $(this).data('booking-id');
                loadBookingDetails(bookingId);
            });

            // Load booking details via AJAX
            function loadBookingDetails(bookingId) {
                $('#bookingModalBody').html(`
            <div class="text-center">
                <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        `);

                $('#bookingActions').html('');

                $.ajax({
                    url: `{{ route('admin.booking.details', ':id') }}`.replace(':id', bookingId),
                    method: 'GET',
                    success: function(response) {
                        if (response.success) {
                            displayBookingDetails(response.data);
                        } else {
                            $('#bookingModalBody').html(
                                '<div class="alert alert-danger">Gagal memuat data booking.</div>');
                        }
                    },
                    error: function() {
                        $('#bookingModalBody').html(
                            '<div class="alert alert-danger">Terjadi kesalahan saat memuat data.</div>'
                            );
                    }
                });
            }

            // Display booking details in modal
            function displayBookingDetails(booking) {
                const checkinDate = new Date(booking.checkin_date).toLocaleDateString('id-ID', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                });

                const checkoutDate = new Date(booking.checkout_date).toLocaleDateString('id-ID', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                });

                const statusBadge = getStatusBadge(booking.status);
                const confirmationBadge = getConfirmationBadge(booking.confirmation_status);
                const typeBadge = booking.type === 'internal' ?
                    '<span class="badge bg-primary">Internal</span>' :
                    '<span class="badge bg-info">Eksternal</span>';

                $('#bookingModalBody').html(`
            <div class="row">
                <div class="col-md-6">
                    <h6 class="font-weight-bold">Informasi Booking</h6>
                    <table class="table table-sm">
                        <tr>
                            <td><strong>Judul:</strong></td>
                            <td>${booking.title}</td>
                        </tr>
                        <tr>
                            <td><strong>Deskripsi:</strong></td>
                            <td>${booking.description || '-'}</td>
                        </tr>
                        <tr>
                            <td><strong>Tipe:</strong></td>
                            <td>${typeBadge}</td>
                        </tr>
                        <tr>
                            <td><strong>Status:</strong></td>
                            <td>${statusBadge}</td>
                        </tr>
                        <tr>
                            <td><strong>Konfirmasi:</strong></td>
                            <td>${confirmationBadge}</td>
                        </tr>
                        <tr>
                            <td><strong>Full Day:</strong></td>
                            <td>${booking.fullday ? '<span class="badge bg-success">Ya</span>' : '<span class="badge bg-secondary">Tidak</span>'}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h6 class="font-weight-bold">Detail Lainnya</h6>
                    <table class="table table-sm">
                        <tr>
                            <td><strong>Ruangan:</strong></td>
                            <td>${booking.room.name}</td>
                        </tr>
                        <tr>
                            <td><strong>Pemesan:</strong></td>
                            <td>${booking.user.name}</td>
                        </tr>
                        <tr>
                            <td><strong>Jumlah Orang:</strong></td>
                            <td>${booking.person_number} orang</td>
                        </tr>
                        <tr>
                            <td><strong>Check-in:</strong></td>
                            <td>${checkinDate}</td>
                        </tr>
                        <tr>
                            <td><strong>Check-out:</strong></td>
                            <td>${checkoutDate}</td>
                        </tr>
                        <tr>
                            <td><strong>Repeat:</strong></td>
                            <td>${booking.repeat_schedule === 'none' ? 'Tidak' : booking.repeat_schedule}</td>
                        </tr>
                    </table>
                </div>
            </div>
        `);

                // Add action buttons based on status
                let actionButtons = '';
                if (booking.confirmation_status === 'tentative') {
                    actionButtons = `
                <button type="button" class="btn btn-success btn-sm mr-2" onclick="updateConfirmationStatus(${booking.id}, 'confirmed', 'used')">
                    <i class="fas fa-check"></i> Konfirmasi
                </button>
                <button type="button" class="btn btn-danger btn-sm" onclick="updateConfirmationStatus(${booking.id}, 'confirmed', 'canceled')">
                    <i class="fas fa-times"></i> Tolak
                </button>
            `;
                } else if (booking.status === 'used') {
                    actionButtons = `
                <button type="button" class="btn btn-secondary btn-sm" onclick="updateConfirmationStatus(${booking.id}, 'confirmed', 'done')">
                    <i class="fas fa-flag-checkered"></i> Selesai
                </button>
            `;
                }

                $('#bookingActions').html(actionButtons);
            }

            // Helper functions for badges
            function getStatusBadge(status) {
                const badges = {
                    'pending': '<span class="badge bg-warning">Pending</span>',
                    'used': '<span class="badge bg-info">Digunakan</span>',
                    'done': '<span class="badge bg-success">Selesai</span>',
                    'canceled': '<span class="badge bg-danger">Dibatalkan</span>'
                };
                return badges[status] || '<span class="badge bg-secondary">Unknown</span>';
            }

            function getConfirmationBadge(status) {
                const badges = {
                    'tentative': '<span class="badge bg-tentative">Tentative</span>',
                    'confirmed': '<span class="badge bg-confirmed">Confirmed</span>'
                };
                return badges[status] || '<span class="badge bg-secondary">Unknown</span>';
            }

            // Update confirmation status
            window.updateConfirmationStatus = function(bookingId, confirmationStatus, status) {
                if (!confirm('Apakah Anda yakin ingin mengubah status booking ini?')) {
                    return;
                }

                $.ajax({
                    url: `{{ route('admin.booking.confirmation', ':id') }}`.replace(':id', bookingId),
                    method: 'PATCH',
                    data: {
                        confirmation_status: confirmationStatus,
                        status: status,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            alert('Status booking berhasil diupdate!');
                            location.reload(); // Reload page to update calendar
                        } else {
                            alert('Gagal mengupdate status booking.');
                        }
                    },
                    error: function() {
                        alert('Terjadi kesalahan saat mengupdate status.');
                    }
                });
            };
        });
    </script>
@endpush
