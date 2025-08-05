@extends('components.app')

@section('content')
    <div class="container mt-4">
        <h3>Pinjam Mobil</h3>

        <form action="{{ route('karyawan.peminjaman.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="id_mobil" class="form-label">Pilih Mobil</label>
                <select name="id_mobil" class="form-select" required>
                    <option value="">-- Pilih Mobil --</option>
                    @foreach ($mobils as $mobil)
                        <option value="{{ $mobil->id }}" data-foto="{{ asset('storage/' . $mobil->foto_mobil) }}">
                            {{ $mobil->model }} - {{ $mobil->plat_mobil }}
                        </option>
                    @endforeach
                </select>
                <div id="preview-foto" class="mt-3" style="display: none;">
                    <label class="form-label">Foto Mobil:</label><br>
                    <img id="foto-mobil" src="" alt="Foto Mobil" style="max-width: 300px; height: auto;"
                        class="img-thumbnail">
                </div>
                @error('id_mobil')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="tanggal_pinjam" class="form-label">Tanggal Pinjam</label>
                <input type="datetime-local" name="tanggal_pinjam" class="form-control" required>
                @error('tanggal_pinjam')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-success">Ajukan</button>
            <a href="{{ route('karyawan.peminjaman.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        document.querySelector('select[name="id_mobil"]').addEventListener('change', function() {
            const selected = this.options[this.selectedIndex];
            const foto = selected.getAttribute('data-foto');
            const previewContainer = document.getElementById('preview-foto');
            const img = document.getElementById('foto-mobil');

            if (foto) {
                img.src = foto;
                previewContainer.style.display = 'block';
                console.log(foto);
            } else {
                previewContainer.style.display = 'none';
                img.src = '';
            }
        });
    </script>
@endpush
