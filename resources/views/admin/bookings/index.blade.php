@extends('components.app')

@push('css')
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
@endpush


@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Booking Management</h4>
                        <a href="{{ route('admin.bookings.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add New Booking
                        </a>
                    </div>

                    <div class="card-body">
                        <!-- Filter Form -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <form method="GET" action="{{ route('admin.bookings.index') }}" class="row g-3">
                                    <div class="col-md-3">
                                        <label class="form-label">Search</label>
                                        <input type="text" name="search" class="form-control"
                                            placeholder="Title, User, Room..." value="{{ request('search') }}">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Status</label>
                                        <select name="status" class="form-select">
                                            <option value="">All Status</option>
                                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                                                Pending</option>
                                            <option value="used" {{ request('status') == 'used' ? 'selected' : '' }}>Used
                                            </option>
                                            <option value="done" {{ request('status') == 'done' ? 'selected' : '' }}>Done
                                            </option>
                                            <option value="canceled"
                                                {{ request('status') == 'canceled' ? 'selected' : '' }}>Canceled</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Confirmation</label>
                                        <select name="confirmation_status" class="form-select">
                                            <option value="">All Confirmation</option>
                                            <option value="tentative"
                                                {{ request('confirmation_status') == 'tentative' ? 'selected' : '' }}>
                                                Tentative</option>
                                            <option value="confirmed"
                                                {{ request('confirmation_status') == 'confirmed' ? 'selected' : '' }}>
                                                Confirmed</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Date From</label>
                                        <input type="date" name="date_from" class="form-control"
                                            value="{{ request('date_from') }}">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Date To</label>
                                        <input type="date" name="date_to" class="form-control"
                                            value="{{ request('date_to') }}">
                                    </div>
                                    <div class="col-md-1 d-flex align-items-end">
                                        <button type="submit" class="btn btn-outline-primary me-2">
                                            <i class="fas fa-search"></i>
                                        </button>
                                        <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-secondary">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Results Info -->
                        <div class="row mb-3">
                            <div class="col-12">
                                <p class="text-muted mb-0">
                                    Showing {{ $bookings->firstItem() ?? 0 }} to {{ $bookings->lastItem() ?? 0 }}
                                    of {{ $bookings->total() }} results
                                </p>
                            </div>
                        </div>

                        <!-- Bookings Table -->
                        <div class="table-responsive">
                            <table class="table table-hover" id="bookingTable">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>User</th>
                                        <th>Room</th>
                                        <th>Check-in</th>
                                        <th>Check-out</th>
                                        <th>Person</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Confirmation</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($bookings as $booking)
                                        <tr>
                                            <td>{{ $booking->id }}</td>
                                            <td>
                                                <strong>{{ $booking->title }}</strong>
                                                @if ($booking->fullday)
                                                    <span class="badge bg-info ms-1">Full Day</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div>{{ $booking->user->name }}</div>
                                                <small class="text-muted">{{ $booking->user->email }}</small>
                                            </td>
                                            <td>{{ $booking->room->name }}</td>
                                            <td>{{ $booking->checkin_date->format('d/m/Y H:i') }}</td>
                                            <td>{{ $booking->checkout_date->format('d/m/Y H:i') }}</td>
                                            <td>{{ $booking->person_number }}</td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $booking->type == 'internal' ? 'primary' : 'warning' }}">
                                                    {{ ucfirst($booking->type) }}
                                                </span>
                                            </td>
                                            <td>
                                                @php
                                                    $statusColors = [
                                                        'pending' => 'warning',
                                                        'used' => 'success',
                                                        'done' => 'info',
                                                        'canceled' => 'danger',
                                                    ];
                                                @endphp
                                                <span
                                                    class="badge bg-{{ $statusColors[$booking->status] ?? 'secondary' }}">
                                                    {{ ucfirst($booking->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $booking->confirmation_status == 'confirmed' ? 'success' : 'secondary' }}">
                                                    {{ ucfirst($booking->confirmation_status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.bookings.show', $booking) }}"
                                                        class="btn btn-sm btn-outline-info" title="View">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.bookings.edit', $booking) }}"
                                                        class="btn btn-sm btn-outline-primary" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>

                                                    @if ($booking->status == 'pending')
                                                        <form action="{{ route('admin.bookings.approve', $booking) }}"
                                                            method="POST" style="display: inline;">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="btn btn-sm btn-outline-success"
                                                                title="Approve" onclick="return confirm('Are you sure?')">
                                                                <i class="fas fa-check"></i>
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('admin.bookings.reject', $booking) }}"
                                                            method="POST" style="display: inline;">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                                title="Reject" onclick="return confirm('Are you sure?')">
                                                                <i class="fas fa-times"></i>
                                                            </button>
                                                        </form>
                                                    @endif

                                                    <form action="{{ route('admin.bookings.destroy', $booking) }}"
                                                        method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                                            title="Delete"
                                                            onclick="return confirm('Are you sure you want to delete this booking?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="11" class="text-center py-4">
                                                <div class="text-muted">
                                                    <i class="fas fa-calendar-times fa-3x mb-3"></i>
                                                    <p>No bookings found</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-end">
                            <!-- Pagination -->
                            @if ($bookings->hasPages())
                                <div class="d-flex justify-content-center">
                                    {{ $bookings->appends(request()->query())->links() }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <!-- jQuery (wajib untuk DataTables) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#bookingTable').DataTable({
                "order": [
                    [0, "desc"]
                ], // Default sort: ID descending
                "paging": false, // Matikan pagination bawaan DataTables (karena Laravel sudah handle)
                "info": false,
                "searching": false // Disable search (karena filter pakai Laravel)
            });
        });
    </script>
@endpush
