<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use Illuminate\Http\Request;

class DepartemenController extends Controller
{
    public function index()
    {
        $departemens = Departemen::orderBy('id_departemen', 'asc')->get();
        return view('departemen.index', compact('departemens'));
    }

    public function create()
    {
        return view('departemen.create');
    }

    public function store(Request $request)
    {
        // Auto-generate ID if empty (checkbox was checked)
        if (empty($request->id_departemen)) {
            // Find the highest ID and increment
            $lastDept = Departemen::orderBy('id_departemen', 'desc')->first();
            if ($lastDept && preg_match('/^DPT-(\d+)$/', $lastDept->id_departemen, $matches)) {
                $nextId = (int)$matches[1] + 1;
                $request->merge(['id_departemen' => 'DPT-' . str_pad($nextId, 3, '0', STR_PAD_LEFT)]);
            } else {
                $request->merge(['id_departemen' => 'DPT-001']);
            }
        }

        $request->validate([
            'id_departemen' => 'required|unique:departemens,id_departemen',
            'nama_departemen' => 'required',
        ]);

        Departemen::create($request->all());

        return redirect()->route('departemen.index')->with('success', 'Data Departemen berhasil ditambahkan.');
    }

    public function edit(Departemen $departemen)
    {
        return view('departemen.edit', compact('departemen'));
    }

    public function update(Request $request, Departemen $departemen)
    {
        $request->validate([
            'id_departemen' => 'required|unique:departemens,id_departemen,' . $departemen->id_departemen . ',id_departemen',
            'nama_departemen' => 'required',
        ]);

        $departemen->update($request->all());

        return redirect()->route('departemen.index')->with('success', 'Data Departemen berhasil diubah.');
    }

    public function destroy(Departemen $departemen)
    {
        $departemen->delete();
        return redirect()->route('departemen.index')->with('success', 'Data Departemen berhasil dihapus.');
    }

    public function destroyBulk(Request $request)
    {
        $ids = $request->input('selected_ids', []);
        if (empty($ids)) {
            return redirect()->route('departemen.index')->with('error', 'Tidak ada data yang dipilih.');
        }

        Departemen::whereIn('id_departemen', $ids)->delete();
        return redirect()->route('departemen.index')->with('success', count($ids) . ' Data Departemen berhasil dihapus.');
    }
}

