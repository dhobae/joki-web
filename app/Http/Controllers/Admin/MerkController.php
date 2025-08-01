<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Merk;
use Illuminate\Http\Request;

class MerkController extends Controller
{
    public function index()
    {
        $merk = Merk::all();
        return view('admin.merk.index', compact('merk'));
    }

    public function create()
    {
        return view('admin.merk.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_merk' => 'required|string|max:255',
        ]);

        Merk::create([
            'nama_merk' => $request->nama_merk,
        ]);

        return redirect()->route('admin.merk.index')->with('success', 'Merk berhasil ditambahkan.');
    }

    public function edit(Merk $merk)
    {
        return view('admin.merk.edit', compact('merk'));
    }

    public function update(Request $request, Merk $merk)
    {
        $request->validate([
            'nama_merk' => 'required|string|max:255',
        ]);

        $merk->update([
            'nama_merk' => $request->nama_merk,
        ]);

        return redirect()->route('admin.merk.index')->with('success', 'Merk berhasil diperbarui.');
    }

    public function destroy(Merk $merk)
    {
        $merk->delete();
        return redirect()->route('admin.merk.index')->with('success', 'Merk berhasil dihapus.');
    }
}
