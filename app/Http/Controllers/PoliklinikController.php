<?php

namespace App\Http\Controllers;

use App\Models\Poliklinik;
use Illuminate\Http\Request;

class PoliklinikController extends Controller
{
    public function index()
    {
        $polikliniks = Poliklinik::latest()->get();
        return view('poliklinik.index', compact('polikliniks'));
    }

    public function create()
    {
        return view('poliklinik.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_poli' => 'required|unique:poliklinik,kode_poli',
            'nama_poli' => 'required',
        ]);

        Poliklinik::create([
            'kode_poli' => $request->kode_poli,
            'nama_poli' => $request->nama_poli,
            'deskripsi' => $request->deskripsi,
            'status_aktif' => $request->status_aktif == 1,
        ]);

        return redirect()->route('poliklinik.index')->with('success', 'Data Poliklinik berhasil ditambahkan.');
    }

    public function edit(Poliklinik $poliklinik)
    {
        return view('poliklinik.edit', compact('poliklinik'));
    }

    public function update(Request $request, Poliklinik $poliklinik)
    {
        $request->validate([
            'kode_poli' => 'required|unique:poliklinik,kode_poli,' . $poliklinik->id,
            'nama_poli' => 'required',
        ]);

        $poliklinik->update([
            'kode_poli' => $request->kode_poli,
            'nama_poli' => $request->nama_poli,
            'deskripsi' => $request->deskripsi,
            'status_aktif' => $request->status_aktif == 1,
        ]);

        return redirect()->route('poliklinik.index')->with('success', 'Data Poliklinik berhasil diubah.');
    }

    public function destroy(Poliklinik $poliklinik)
    {
        $poliklinik->delete();
        return redirect()->route('poliklinik.index')->with('success', 'Data Poliklinik berhasil dihapus.');
    }
}
