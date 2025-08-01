<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Mobil;
use App\Models\Peminjaman;
use Illuminate\Routing\Controller;

class DashboardController extends Controller {
    public function index() {
        $mobilTersedia = Mobil::where('status_mobil', 'Tersedia')->count();
        $mobilDipinjam = Mobil::where('status_mobil', 'Tidak Tersedia')->count();
        $pengajuanBaru = Peminjaman::where('status_peminjam', 'diajukan')->count();

        // Kirim data ke view 'dashboard.blade.php'
        return view('dashboard', compact('mobilTersedia', 'mobilDipinjam', 'pengajuanBaru'));
    }
}
