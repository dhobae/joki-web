<?php
namespace App\Http\Controllers;
use App\Models\Peminjaman;
use App\Models\Mobil;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller {
    public function index() {
        $peminjamans = Peminjaman::with(['mobil', 'user'])->latest()->get();
        return view('peminjaman.index', compact('peminjamans'));
    }

    public function create() {
        $mobils = Mobil::where('status_mobil', 'Tersedia')->get();
        return view('peminjaman.create', compact('mobils'));
    }

    public function store(Request $request) {
        // Validasi
        $request->validate([
            'id_mobil' => 'required|exists:mobils,id',
            'tanggal_pinjam' => 'required|date',
        ]);

        // Buat data peminjaman
        Peminjaman::create([
            'id_user' => Auth::id(), // Ambil ID user yang sedang login
            'id_mobil' => $request->id_mobil,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'status_peminjaman' => 'diajukan',
        ]);

        // Update status mobil
        Mobil::find($request->id_mobil)->update(['status_mobil' => 'Tidak Tersedia']);

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil diajukan.');
    }

    // ... method lainnya untuk approve, return, dll.
}
