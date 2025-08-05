@extends('components.app') 

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Daftar Mobil Tersedia</h2>

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="thead-dark">
                <tr>
                    <th>No</th>
                    <th>Foto</th>
                    <th>Plat Mobil</th>
                    <th>Merk</th>
                    <th>Jenis</th>
                    <th>Model</th>
                    <th>Kapasitas</th>
                    <th>Catatan</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($mobils as $index => $mobil)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        @if($mobil->foto_mobil)
                            <img src="{{ asset('storage/' . $mobil->foto_mobil) }}" alt="Foto Mobil" width="100">
                        @else
                            <span class="text-muted">Tidak ada</span>
                        @endif
                    </td>
                    <td>{{ $mobil->plat_mobil }}</td>
                    <td>{{ $mobil->merk->nama_merk ?? '-' }}</td>
                    <td>{{ $mobil->jenis->nama_jenis ?? '-' }}</td>
                    <td>{{ $mobil->model }}</td>
                    <td>{{ $mobil->kapasitas }} orang</td>
                    <td>{{ $mobil->catatan_lain ?? '-' }}</td>
                    <td><span class="badge bg-success">{{ $mobil->status_mobil }}</span></td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center">Tidak ada mobil tersedia.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
