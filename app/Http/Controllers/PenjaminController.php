<?php

namespace App\Http\Controllers;

use App\Models\Penjamin;
use Illuminate\Http\Request;

class PenjaminController extends Controller
{
    public function index()
    {
        $Penjamins = Penjamin::orderBy('id_penjamin', 'asc')->get();
        return view('penjamin.index', compact('Penjamins'));
    }

    public function create()
    {
        return view('penjamin.create');
    }

    public function store(Request $request)
    {
        // Auto-generate ID if empty (checkbox was checked)
        if (empty($request->id_penjamin)) {
            $lastPenjamin = Penjamin::withTrashed()->where('id_penjamin', 'like', 'PJM-%')->orderBy('id_penjamin', 'desc')->first();
            if ($lastPenjamin && preg_match('/^PJM-(\d+)$/', $lastPenjamin->id_penjamin, $matches)) {
                $nextId = (int)$matches[1] + 1;
                $request->merge(['id_penjamin' => 'PJM-' . str_pad($nextId, 3, '0', STR_PAD_LEFT)]);
            } else {
                $request->merge(['id_penjamin' => 'PJM-001']);
            }
        }

        $request->validate([
            'id_penjamin' => 'required|unique:Penjamins,id_penjamin',
            'nama_penjamin' => 'required',
        ]);

        Penjamin::create($request->all());

        return redirect()->route('penjamin.index')->with('success', 'Data Penjamin berhasil ditambahkan.');
    }

    public function edit(Penjamin $Penjamin)
    {
        return view('penjamin.edit', compact('Penjamin'));
    }

    public function update(Request $request, Penjamin $Penjamin)
    {
        $request->validate([
            'id_penjamin' => 'required|unique:Penjamins,id_penjamin,' . $Penjamin->id_penjamin . ',id_penjamin',
            'nama_penjamin' => 'required',
        ]);

        $Penjamin->update($request->all());

        return redirect()->route('penjamin.index')->with('success', 'Data Penjamin berhasil diubah.');
    }

    public function destroy(Penjamin $Penjamin)
    {
        $Penjamin->delete();
        return redirect()->route('penjamin.index')->with('success', 'Data Penjamin berhasil dihapus.');
    }

    public function destroyBulk(Request $request)
    {
        $ids = $request->input('selected_ids', []);
        if (empty($ids)) {
            return redirect()->route('penjamin.index')->with('error', 'Tidak ada data yang dipilih.');
        }

        Penjamin::withTrashed()->whereIn('id_penjamin', $ids)->delete();
        return redirect()->route('penjamin.index')->with('success', count($ids) . ' Data Penjamin berhasil dihapus.');
    }
}





