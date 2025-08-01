<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mobil;
use App\Models\Merk;
use App\Models\Jenis;
use Illuminate\Http\Request;

class MobilController extends Controller
{
    public function index()
    {
        $mobils = Mobil::with(['merk', 'jenis'])->latest()->get();
        return view('admin.mobil.index', compact('mobils'));
    }

    public function create()
    {
        $merks = Merk::all();
        $jenis = Jenis::all();
        return view('admin.mobil.create', compact('merks', 'jenis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'plat_mobil' => 'required|unique:mobil',
            'id_merk' => 'required',
            'id_jenis' => 'required',
            'model' => 'required',
            'kapasitas' => 'required|integer',
            'status_mobil' => 'required|in:Tersedia,Tidak Tersedia',
            'foto_mobil' => 'nullable|image|max:2048',
        ]);

        

        $data = $request->all();

        if ($request->hasFile('foto_mobil')) {
            $data['foto_mobil'] = $request->file('foto_mobil')->store('foto_mobil', 'public');
        }

        Mobil::create($data);

        return redirect()->route('admin.mobil.index')->with('success', 'Mobil berhasil ditambahkan');
    }

    public function edit($id)
    {
        $mobil = Mobil::findOrFail($id);
        $merks = Merk::all();
        $jenis = Jenis::all();
        return view('admin.mobil.edit', compact('mobil', 'merks', 'jenis'));
    }

    public function update(Request $request, $id)
    {
        $mobil = Mobil::findOrFail($id);

        $request->validate([
            'plat_mobil' => 'required|unique:mobil,plat_mobil,' . $mobil->id,
            'id_merk' => 'required',
            'id_jenis' => 'required',
            'model' => 'required',
            'kapasitas' => 'required|integer',
            'status_mobil' => 'required|in:Tersedia,Tidak Tersedia',
            'foto_mobil' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto_mobil')) {
            $data['foto_mobil'] = $request->file('foto_mobil')->store('foto_mobil', 'public');
        }

        $mobil->update($data);

        return redirect()->route('admin.mobil.index')->with('success', 'Mobil berhasil diperbarui');
    }

    public function destroy($id)
    {
        $mobil = Mobil::findOrFail($id);
        $mobil->delete();
        return redirect()->route('admin.mobil.index')->with('success', 'Mobil berhasil dihapus');
    }
}
