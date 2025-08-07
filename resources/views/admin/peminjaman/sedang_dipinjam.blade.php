@extends('components.app')
]

@section('content')
    <div class="container-fluid mt-4">
        <h3>Daftar Peminjaman yang Sedang Dipinjam</h3>

        <div class="table-responsive">
            <table class="table table-bordered" id="peminjamanTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama User</th>
                        <th>Email</th>
                        <th>No. Telepon</th>
                        <th>Mobil</th>
                        <th>Plat Nomor</th>
                        <th>Kapasitas Orang</th>
                        <th>Tanggal Pinjam</th>
                        <th>Foto Mobil</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->user->name }}</td>
                            <td>{{ $item->user->email }}</td>
                            <td>{{ $item->user->no_telp }}</td>
                            <td>{{ $item->mobil->model }}</td>
                            <td>{{ $item->mobil->plat_mobil }}</td>
                            <td>{{ $item->mobil->kapasitas }} Orang</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d-m-Y H:i') }}</td>
                            <td>
                                @if ($item->mobil->foto_mobil)
                                    <button class="btn btn-sm btn-info" data-bs-toggle="modal"
                                        data-bs-target="#modalFoto{{ $item->id }}">
                                        Lihat Foto
                                    </button>

                                    <!-- Modal Foto Mobil -->
                                    <div class="modal fade" id="modalFoto{{ $item->id }}" tabindex="-1"
                                        aria-labelledby="modalFotoLabel{{ $item->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-xl modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="modalFotoLabel{{ $item->id }}">
                                                        Foto
                                                        Mobil - {{ $item->mobil->model }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Tutup"></button>
                                                </div>
                                                <div class="modal-body text-center">
                                                    <img src="{{ asset('storage/' . $item->mobil->foto_mobil) }}"
                                                        alt="Foto Mobil" class="img-fluid rounded">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-muted">Tidak Ada</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="row">
            <div class="col">
                <a href="{{ route('admin.peminjaman.index') }}" class="btn btn-sm btn-secondary">Kembali ke semua
                    Riwayat Peminjaman</a>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
   

    <!-- Inisialisasi DataTables -->
    <script>
        $(document).ready(function() {
            $('#peminjamanTable').DataTable({
                columnDefs: [{
                    targets: 8, // Kolom 'No'
                    orderable: false,
                    searchable: false,
                    className: 'text-center',
                }, ]
            });
        });
    </script>
@endpush
