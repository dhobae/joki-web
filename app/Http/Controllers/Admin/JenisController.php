<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jenis;
use Illuminate\Http\Request;

class JenisController extends Controller
{
    public function index()
    {
        $jenis = Jenis::all();
        return view('admin.jenis.index', compact('jenis'));
    }

    public function create()
    {
        return view('admin.jenis.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_jenis' => 'required|string|max:255',
        ]);

        Jenis::create([
            'nama_jenis' => $request->nama_jenis,
        ]);

        return redirect()->route('admin.jenis.index')->with('success', 'Jenis berhasil ditambahkan.');
    }

    public function edit(Jenis $jeni)
    {
        return view('admin.jenis.edit', compact('jeni'));
    }

    public function update(Request $request, Jenis $jeni)
    {
        $request->validate([
            'nama_jenis' => 'required|string|max:255',
        ]);

        $jeni->update([
            'nama_jenis' => $request->nama_jenis,
        ]);

        return redirect()->route('admin.jenis.index')->with('success', 'Jenis berhasil diperbarui.');
    }

    public function destroy(Jenis $jeni)
    {
        $jeni->delete();
        return redirect()->route('admin.jenis.index')->with('success', 'Jenis berhasil dihapus.');
    }
}
