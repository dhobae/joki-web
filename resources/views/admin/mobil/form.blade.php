<div class="form-group">
    <label>Plat Mobil</label>
    <input type="text" name="plat_mobil" class="form-control" value="{{ old('plat_mobil', $mobil->plat_mobil ?? '') }}" required>
</div>

<div class="form-group">
    <label>Merk</label>
    <select name="id_merk" class="form-control" required>
        <option value="">Pilih Merk</option>
        @foreach($merks as $merk)
            <option value="{{ $merk->id }}" {{ old('id_merk', $mobil->id_merk ?? '') == $merk->id ? 'selected' : '' }}>
                {{ $merk->nama_merk }}
            </option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label>Jenis</label>
    <select name="id_jenis" class="form-control" required>
        <option value="">Pilih Jenis</option>
        @foreach($jenis as $j)
            <option value="{{ $j->id }}" {{ old('id_jenis', $mobil->id_jenis ?? '') == $j->id ? 'selected' : '' }}>
                {{ $j->nama_jenis }}
            </option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label>Model</label>
    <input type="text" name="model" class="form-control" value="{{ old('model', $mobil->model ?? '') }}" required>
</div>

<div class="form-group">
    <label>Kapasitas</label>
    <input type="number" name="kapasitas" class="form-control" value="{{ old('kapasitas', $mobil->kapasitas ?? '') }}" required>
</div>

<div class="form-group">
    <label>Status Mobil</label>
    <select name="status_mobil" class="form-control" required>
        <option value="Tersedia" {{ old('status_mobil', $mobil->status_mobil ?? '') == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
        <option value="Tidak Tersedia" {{ old('status_mobil', $mobil->status_mobil ?? '') == 'Tidak Tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
    </select>
</div>

<div class="form-group">
    <label>Foto Mobil</label>
    <input type="file" name="foto_mobil" class="form-control-file">
    @if(isset($mobil) && $mobil->foto_mobil)
        <img src="{{ asset('storage/' . $mobil->foto_mobil) }}" width="100" class="mt-2">
    @endif
</div>
