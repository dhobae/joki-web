@extends('components.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title mb-0">Booking Details</h4>
                        <div>
                            <a href="{{ route('admin.bookings.edit', $booking) }}" class="btn btn-primary me-2">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <!-- Basic Information -->
                            <div class="col-md-8">
                                <div class="card h-100">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Booking Information</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col-sm-3"><strong>ID:</strong></div>
                                            <div class="col-sm-9">{{ $booking->id }}</div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-3"><strong>Title:</strong></div>
                                            <div class="col-sm-9">
                                                {{ $booking->title }}
                                                @if ($booking->fullday)
                                                    <span class="badge bg-info ms-2">Full Day</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-3"><strong>Description:</strong></div>
                                            <div class="col-sm-9">{{ $booking->description }}</div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-3"><strong>Check-in Date:</strong></div>
                                            <div class="col-sm-9">{{ $booking->checkin_date->format('d F Y, H:i') }}</div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-3"><strong>Check-out Date:</strong></div>
                                            <div class="col-sm-9">{{ $booking->checkout_date->format('d F Y, H:i') }}</div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-3"><strong>Duration:</strong></div>
                                            <div class="col-sm-9">
                                                {{ $booking->checkin_date->diffForHumans($booking->checkout_date, true) }}
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-3"><strong>Number of Person:</strong></div>
                                            <div class="col-sm-9">{{ $booking->person_number }} people</div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-3"><strong>Type:</strong></div>
                                            <div class="col-sm-9">
                                                <span
                                                    class="badge bg-{{ $booking->type == 'internal' ? 'primary' : 'warning' }}">
                                                    {{ ucfirst($booking->type) }}
                                                </span>
                                            </div>
                                        </div>

                                        @if ($booking->repeat_schedule != 'none')
                                            <div class="row mb-3">
                                                <div class="col-sm-3"><strong>Repeat Schedule:</strong></div>
                                                <div class="col-sm-9">
                                                    <span
                                                        class="badge bg-info">{{ ucfirst($booking->repeat_schedule) }}</span>
                                                </div>
                                            </div>

                                            @if ($booking->repeat_weekly)
                                                <div class="row mb-3">
                                                    <div class="col-sm-3"><strong>Weekly Repeat:</strong></div>
                                                    <div class="col-sm-9">{{ $booking->repeat_weekly }}</div>
                                                </div>
                                            @endif

                                            @if ($booking->repeat_monthly)
                                                <div class="row mb-3">
                                                    <div class="col-sm-3"><strong>Monthly Repeat:</strong></div>
                                                    <div class="col-sm-9">{{ $booking->repeat_monthly }}</div>
                                                </div>
                                            @endif
                                        @endif

                                        <div class="row mb-3">
                                            <div class="col-sm-3"><strong>Created At:</strong></div>
                                            <div class="col-sm-9">{{ $booking->created_at->format('d F Y, H:i') }}</div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-3"><strong>Updated At:</strong></div>
                                            <div class="col-sm-9">{{ $booking->updated_at->format('d F Y, H:i') }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Status and Actions -->
                            <div class="col-md-4">
                                <div class="card mb-3">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Status</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="form-label"><strong>Booking Status:</strong></label>
                                            <div>
                                                @php
                                                    $statusColors = [
                                                        'pending' => 'warning',
                                                        'used' => 'success',
                                                        'done' => 'info',
                                                        'canceled' => 'danger',
                                                    ];
                                                @endphp
                                                <span
                                                    class="badge bg-{{ $statusColors[$booking->status] ?? 'secondary' }} fs-6">
                                                    {{ ucfirst($booking->status) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label"><strong>Confirmation Status:</strong></label>
                                            <div>
                                                <span
                                                    class="badge bg-{{ $booking->confirmation_status == 'confirmed' ? 'success' : 'secondary' }} fs-6">
                                                    {{ ucfirst($booking->confirmation_status) }}
                                                </span>
                                            </div>
                                        </div>

                                        <!-- Quick Actions -->
                                        @if ($booking->status == 'pending')
                                            <div class="d-grid gap-2">
                                                <form action="{{ route('admin.bookings.approve', $booking) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-success"
                                                        onclick="return confirm('Approve this booking?')">
                                                        <i class="fas fa-check"></i> Approve Booking
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.bookings.reject', $booking) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-danger"
                                                        onclick="return confirm('Reject this booking?')">
                                                        <i class="fas fa-times"></i> Reject Booking
                                                    </button>
                                                </form>
                                            </div>
                                        @endif

                                        <!-- Status Update Form -->
                                        <div class="mt-3">
                                            <form action="{{ route('admin.bookings.updateStatus', $booking) }}"
                                                method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <div class="mb-2">
                                                    <label class="form-label">Update Status:</label>
                                                    <select name="status" class="form-select form-select-sm">
                                                        <option value="pending"
                                                            {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending
                                                        </option>
                                                        <option value="used"
                                                            {{ $booking->status == 'used' ? 'selected' : '' }}>Used
                                                        </option>
                                                        <option value="done"
                                                            {{ $booking->status == 'done' ? 'selected' : '' }}>Done
                                                        </option>
                                                        <option value="canceled"
                                                            {{ $booking->status == 'canceled' ? 'selected' : '' }}>Canceled
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="mb-2">
                                                    <select name="confirmation_status" class="form-select form-select-sm">
                                                        <option value="tentative"
                                                            {{ $booking->confirmation_status == 'tentative' ? 'selected' : '' }}>
                                                            Tentative</option>
                                                        <option value="confirmed"
                                                            {{ $booking->confirmation_status == 'confirmed' ? 'selected' : '' }}>
                                                            Confirmed</option>
                                                    </select>
                                                </div>
                                                <button type="submit" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-save"></i> Update Status
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- User Information -->
                                <div class="card mb-3">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">User Information</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-2">
                                            <strong>Name:</strong><br>
                                            {{ $booking->user->name }}
                                        </div>
                                        <div class="mb-2">
                                            <strong>Email:</strong><br>
                                            <a href="mailto:{{ $booking->user->email }}">{{ $booking->user->email }}</a>
                                        </div>
                                        <div class="mb-2">
                                            <strong>Role:</strong><br>
                                            <span class="badge bg-info">{{ ucfirst($booking->user->role) }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Room Information -->
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Room Information</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-2">
                                            <strong>Room Name:</strong><br>
                                            {{ $booking->room->name }}
                                        </div>
                                        <div class="mb-2">
                                            <strong>Description:</strong><br>
                                            {{ $booking->room->description }}
                                        </div>
                                        <div class="mb-2">
                                            <strong>Capacity:</strong><br>
                                            {{ $booking->room->capacity }} people
                                        </div>
                                        <div class="mb-2">
                                            <strong>Facilities:</strong><br>
                                            {{ $booking->room->facilities }}
                                        </div>
                                        <div class="mb-2">
                                            <strong>Status:</strong><br>
                                            <span class="badge bg-{{ $booking->room->is_active ? 'success' : 'danger' }}">
                                                {{ $booking->room->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </div>
                                        @if ($booking->room->photo)
                                            <div class="mb-2">
                                                <strong>Photo:</strong><br>
                                                <img src="{{ asset('storage/' . $booking->room->photo) }}"
                                                    alt="Room Photo" class="img-fluid rounded"
                                                    style="max-height: 150px;">
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

   
@endsection
