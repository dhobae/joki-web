@extends('components.app')

@section('content')
    <div class="container mt-4">
        <h3>Daftar Peminjaman yang Sudah Dikembalikan</h3>

        @if (session('success'))
            <div class="alert alert-success mt-2">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered mt-3" id="tabelDikembalikan">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama User</th>
                    <th>Email</th>
                    <th>No. Telepon</th>
                    <th>Mobil</th>
                    <th>Plat Nomor</th>
                    <th>Tgl. Pinjam</th>
                    <th>Tgl. Pengembalian</th>
                    <th>Foto Mobil</th>
                    <th>Bukti Pengembalian</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->user->name }}</td>
                        <td>{{ $item->user->email }}</td>
                        <td>{{ $item->user->no_telp }}</td>
                        <td>{{ $item->mobil->model }}</td>
                        <td>{{ $item->mobil->plat_mobil }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d-m-Y H:i') }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_pengembalian)->format('d-m-Y H:i') }}</td>
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
                        <td>
                            @if ($item->bukti_pengembalian)
                                <button class="btn btn-sm btn-primary" data-toggle="modal"
                                    data-target="#modalBukti{{ $item->id }}">
                                    Lihat Bukti
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="modalBukti{{ $item->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="buktiLabel{{ $item->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="buktiLabel{{ $item->id }}">Bukti
                                                    Pengembalian</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body text-center">
                                                <img src="{{ asset('storage/' . $item->bukti_pengembalian) }}"
                                                    alt="Bukti" class="img-fluid">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <span class="text-muted">Tidak Ada</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center">Belum ada data peminjaman yang dikembalikan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>


        <div class="row">
            <div class="col">
                <a href="{{ route('admin.peminjaman.index') }}" class="btn btn-sm btn-secondary">Kembali ke semua Riwayat
                    Peminjaman</a>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Inisialisasi DataTables -->
    <script>
        $(document).ready(function() {
            $('#tabelDikembalikan').DataTable({
                columnDefs: [{
                    targets: [8,9], // Kolom 'No'
                    orderable: false,
                    searchable: false,
                    className: 'text-center',
                }, ]
            });
        });
    </script>
@endpush
