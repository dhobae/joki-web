<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Mobil;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::with('mobil')->where('id_user', Auth::id())->latest()->get();
        return view('karyawan.peminjaman.index', compact('peminjamans'));
    }

    public function create()
    {
        $mobils = Mobil::where('status_mobil', 'Tersedia')->get();
        return view('karyawan.peminjaman.create', compact('mobils'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_mobil' => 'required|exists:mobil,id',
            'tanggal_pinjam' => 'required|date|after_or_equal:today',
        ]);

        Peminjaman::create([
            'id_user' => Auth::id(),
            'id_mobil' => $request->id_mobil,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'status_peminjaman' => 'diajukan',
        ]);

        return redirect()->route('karyawan.peminjaman.index')->with('success', 'Peminjaman berhasil diajukan.');
    }

    public function show(Peminjaman $peminjaman)
    {
        // Pastikan hanya pemilik yang bisa lihat detailnya
        abort_if($peminjaman->id_user !== Auth::id(), 403);

        return view('karyawan.peminjaman.show', compact('peminjaman'));
    }

    public function pengembalianForm($id)
    {
        $peminjaman = Peminjaman::with('mobil')->findOrFail($id);

        // Pastikan hanya peminjam yang bisa mengakses
        abort_if($peminjaman->id_user !== Auth::id(), 403);
        abort_if($peminjaman->status_peminjaman !== 'disetujui' && $peminjaman->status_peminjaman !== 'digunakan', 403);

        return view('karyawan.peminjaman.pengembalian', compact('peminjaman'));
    }

    public function pengembalianStore(Request $request, $id)
    {
        $peminjaman = Peminjaman::with('mobil')->findOrFail($id);
        abort_if($peminjaman->id_user !== Auth::id(), 403);

        $request->validate([
            'bukti_pengembalian' => 'required|image|max:2048',
        ]);

        // Simpan bukti pengembalian
        $path = $request->file('bukti_pengembalian')->store('bukti_pengembalian', 'public');

        // Update data
        $peminjaman->update([
            'status_peminjaman' => 'dikembalikan',
            'tanggal_pengembalian' => now(),
            'bukti_pengembalian' => $path,
        ]);

        // Ubah status mobil menjadi Tersedia kembali
        $peminjaman->mobil->update([
            'status_mobil' => 'Tersedia',
            // 'foto_mobil' => $path, // ← Sesuai permintaan kamu: update juga kolom `foto_mobil` dengan bukti pengembalian
        ]);

        return redirect()->route('karyawan.peminjaman.index')->with('success', 'Mobil berhasil dikembalikan.');
    }

}
