<?php
namespace App\Http\Controllers;
use App\Models\Mobil;
use App\Models\Merk;
use App\Models\Jenis;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class MobilController extends Controller {
    public function index() {
        $mobils = Mobil::with(['merk', 'jenis'])->latest()->get();
        return view('mobil.index', compact('mobils'));
    }

    public function create() {
        $merks = Merk::all();
        $jenis = Jenis::all();
        return view('mobil.create', compact('merks', 'jenis'));
    }

    public function store(Request $request) {
        // 1. Validasi input
        $request->validate([
            'model' => 'required|string|max:200',
            'plat_mobil' => 'required|string|unique:mobils,plat_mobil',
            'id_merk' => 'required|exists:merks,id',
            'id_jenis' => 'required|exists:jenis,id',
            'kapasitas' => 'required|integer',
            // tambahkan validasi lain jika perlu
        ]);

        // 2. Simpan data
        Mobil::create($request->all());

        // 3. Redirect ke halaman index mobil
        return redirect()->route('mobil.index')->with('success', 'Data mobil berhasil ditambahkan.');
    }

    // ... method show, edit, update, destroy lainnya
}
