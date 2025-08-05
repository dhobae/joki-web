<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;

class PeminjamanController extends Controller
{
       public function index()
    {
        $peminjamans = Peminjaman::with('user', 'mobil')->latest()->get();
        return view('admin.peminjaman.index', compact('peminjamans'));
    }

    public function setujui($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->status_peminjaman = 'disetujui';
        $peminjaman->save();

        // Set mobil jadi tidak tersedia
        $peminjaman->mobil->update(['status_mobil' => 'Tidak Tersedia']);

        return back()->with('success', 'Peminjaman disetujui.');
    }

    public function tolak($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->status_peminjaman = 'ditolak';
        $peminjaman->save();

        return back()->with('success', 'Peminjaman ditolak.');
    }

  
    public function lihatBukti($id)
    {
        $peminjaman = Peminjaman::with('user', 'mobil')->findOrFail($id);

        // Pastikan hanya bisa dilihat jika status = dikembalikan dan ada bukti
        abort_if($peminjaman->status_peminjaman !== 'dikembalikan' || !$peminjaman->bukti_pengembalian, 404);

        return view('admin.peminjaman.bukti', compact('peminjaman'));
    }

}
