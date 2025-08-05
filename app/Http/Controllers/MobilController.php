<?php

namespace App\Http\Controllers;

use App\Models\Mobil;
use Illuminate\Http\Request;

class MobilController extends Controller
{
   public function index()
{
    $mobils = Mobil::with(['merk', 'jenis'])
        ->where('status_mobil', 'Tersedia')
        ->latest()
        ->get();

    return view('karyawan.mobil.index', compact('mobils'));
}
}
