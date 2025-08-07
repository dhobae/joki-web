@extends('components.app')


@section('content')
    <div class="container mt-4">
        <h2 class="mb-4">Detail Ruangan</h2>

        <div class="card">
            <div class="row no-gutters">
                <div class="col-md-5">
                    @if ($room->photo)
                        <img src="{{ asset('/storage/' . $room->photo) }}"
                            class="img-fluid rounded-start w-100 h-100 object-fit-cover" alt="{{ $room->name }}">
                    @else
                      No Images
                    @endif
                </div>
                <div class="col-md-7">
                    <div class="card-body">
                        <h4 class="card-title">Nama Room :{{ $room->name }}</h4>
                        <p class="card-text"><strong>Deskripsi:</strong> {{ $room->description }}</p>
                        <p class="card-text"><strong>Kapasitas:</strong> {{ $room->capacity }} orang</p>
                        <p class="card-text"><strong>Fasilitas:</strong> {{ $room->facilities }}</p>
                        <p class="card-text"><strong>Status:</strong>
                            @if ($room->is_active)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Tidak Aktif</span>
                            @endif
                        </p>
                        <p class="card-text"><small class="text-muted">Dibuat pada:
                                {{ \Carbon\Carbon::parse($room->created_at)->format('d M Y, H:i') }}</small></p>
                        <p class="card-text"><small class="text-muted">Terakhir diupdate:
                                {{ \Carbon\Carbon::parse($room->updated_at)->format('d M Y, H:i') }}</small></p>

                        <a href="{{ route('admin.rooms.index') }}" class="btn btn-secondary mt-3">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
