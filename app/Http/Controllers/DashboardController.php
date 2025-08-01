<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Mobil;
use App\Models\Peminjaman;
use Illuminate\Routing\Controller;

class DashboardController extends Controller {
    public function index() {
        return view('admin.dashboard');
    }
}
