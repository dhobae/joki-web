@extends('components.app')

@section('title', 'Manajemen Booking')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">Manajemen Booking</h1>
                <a href="{{ route('admin.bookings.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Booking
                </a>
            </div>

            <!-- Alert Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                    <button type="button" class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                </div>
            @endif

            <!-- Filter Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Filter & Pencarian</h6>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.bookings.index') }}">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control">
                                        <option value="">Semua Status</option>
                                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                       
                                        <option value="used" {{ request('status') == 'used' ? 'selected' : '' }}>Used</option>
                                        <option value="done" {{ request('status') == 'done' ? 'selected' : '' }}>Done</option>
                                        <option value="canceled" {{ request('status') == 'canceled' ? 'selected' : '' }}>Canceled</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Status Konfirmasi</label>
                                    <select name="confirmation_status" class="form-control">
                                        <option value="">Semua Status</option>
                                        <option value="tentative" {{ request('confirmation_status') == 'tentative' ? 'selected' : '' }}>Tentative</option>
                                        <option value="confirmed" {{ request('confirmation_status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Dari Tanggal</label>
                                    <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Sampai Tanggal</label>
                                    <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Pencarian</label>
                                    <input type="text" name="search" class="form-control" placeholder="Cari title/user..." value="{{ request('search') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Filter
                                </button>
                                <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-undo"></i> Reset
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Data Table -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Data Booking</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>User</th>
                                    <th>Ruangan</th>
                                    <th>Check-in</th>
                                    <th>Check-out</th>
                                    <th>Jumlah Orang</th>
                                    <th>Status</th>
                                    <th>Konfirmasi</th>
                                    <th>Type</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bookings as $booking)
                                <tr>
                                    <td>{{ $booking->id }}</td>
                                    <td>
                                        <strong>{{ $booking->title }}</strong>
                                        @if($booking->fullday)
                                            <span class="badge badge-info">Full Day</span>
                                        @endif
                                    </td>
                                    <td>{{ $booking->user->name }}</td>
                                    <td>{{ $booking->room->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($booking->checkin_date)->format('d/m/Y H:i') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($booking->checkout_date)->format('d/m/Y H:i') }}</td>
                                    <td>{{ $booking->person_number }} orang</td>
                                    <td>
                                        @if($booking->status == 'pending')
                                            <div class="btn-group" role="group">
                                                <button class="btn btn-sm btn-success approve-btn" data-id="{{ $booking->id }}" title="Approve">
                                                    <i class="fas fa-check"></i> Approve
                                                </button>
                                                <button class="btn btn-sm btn-danger reject-btn" data-id="{{ $booking->id }}" title="Reject">
                                                    <i class="fas fa-times"></i> Reject
                                                </button>
                                            </div>
                                        @else
                                            <select class="form-control form-control-sm status-select" data-id="{{ $booking->id }}"
                                                    {{ in_array($booking->status, ['rejected', 'canceled']) ? 'disabled' : '' }}>
                                                <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="approved" {{ $booking->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                                <option value="rejected" {{ $booking->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                                <option value="used" {{ $booking->status == 'used' ? 'selected' : '' }}>Used</option>
                                                <option value="done" {{ $booking->status == 'done' ? 'selected' : '' }}>Done</option>
                                                <option value="canceled" {{ $booking->status == 'canceled' ? 'selected' : '' }}>Canceled</option>
                                            </select>
                                        @endif
                                    </td>
                                    <td>
                                        <select class="form-control form-control-sm confirmation-select" data-id="{{ $booking->id }}">
                                            <option value="tentative" {{ $booking->confirmation_status == 'tentative' ? 'selected' : '' }}>Tentative</option>
                                            <option value="confirmed" {{ $booking->confirmation_status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                        </select>
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $booking->type == 'internal' ? 'success' : 'warning' }}">
                                            {{ ucfirst($booking->type) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.bookings.show', $booking) }}" class="btn btn-sm btn-info" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.bookings.edit', $booking) }}" class="btn btn-sm btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-danger delete-btn"
                                                    data-id="{{ $booking->id }}"
                                                    data-title="{{ $booking->title }}"
                                                    title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="11" class="text-center">Tidak ada data booking</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center">
                        {{ $bookings->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Hapus</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus booking "<span id="delete-title"></span>"?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <form id="delete-form" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Delete confirmation
    $('.delete-btn').click(function() {
        const id = $(this).data('id');
        const title = $(this).data('title');

        $('#delete-title').text(title);
        $('#delete-form').attr('action', `/admin/bookings/${id}`);
        $('#deleteModal').modal('show');
    });

    // Approve booking
    $('.approve-btn').click(function() {
        const id = $(this).data('id');

        if (confirm('Apakah Anda yakin ingin menyetujui booking ini?')) {
            $.ajax({
                url: `/admin/bookings/${id}/approve`,
                method: 'PATCH',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    location.reload();
                },
                error: function() {
                    alert('Terjadi kesalahan');
                }
            });
        }
    });

    // Reject booking
    $('.reject-btn').click(function() {
        const id = $(this).data('id');

        if (confirm('Apakah Anda yakin ingin menolak booking ini?')) {
            $.ajax({
                url: `/admin/bookings/${id}/reject`,
                method: 'PATCH',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    location.reload();
                },
                error: function() {
                    alert('Terjadi kesalahan');
                }
            });
        }
    });
    $('.status-select').change(function() {
        const id = $(this).data('id');
        const status = $(this).val();

        $.ajax({
            url: `/admin/bookings/${id}/status`,
            method: 'PATCH',
            data: {
                _token: '{{ csrf_token() }}',
                status: status
            },
            success: function(response) {
                if (response.success) {
                    toastr.success(response.message);
                } else {
                    toastr.error(response.message);
                }
            },
            error: function() {
                toastr.error('Terjadi kesalahan');
            }
        });
    });

    // Update confirmation status via AJAX
    $('.confirmation-select').change(function() {
        const id = $(this).data('id');
        const confirmationStatus = $(this).val();

        $.ajax({
            url: `/admin/bookings/${id}/confirmation`,
            method: 'PATCH',
            data: {
                _token: '{{ csrf_token() }}',
                confirmation_status: confirmationStatus
            },
            success: function(response) {
                if (response.success) {
                    toastr.success(response.message);
                } else {
                    toastr.error(response.message);
                }
            },
            error: function() {
                toastr.error('Terjadi kesalahan');
            }
        });
    });
});
</script>
@endpush