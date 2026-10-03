<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    public function index()
    {
        $jabatans = Jabatan::orderBy('id_jabatan', 'asc')->get();
        return view('jabatan.index', compact('jabatans'));
    }

    public function create()
    {
        return view('jabatan.create');
    }

    public function store(Request $request)
    {
        // Auto-generate ID if empty (checkbox was checked)
        if (empty($request->id_jabatan)) {
            $lastJabatan = Jabatan::withTrashed()->orderBy('id_jabatan', 'desc')->first();
            if ($lastJabatan && preg_match('/^JBT-(\d+)$/', $lastJabatan->id_jabatan, $matches)) {
                $nextId = (int)$matches[1] + 1;
                $request->merge(['id_jabatan' => 'JBT-' . str_pad($nextId, 3, '0', STR_PAD_LEFT)]);
            } else {
                $request->merge(['id_jabatan' => 'JBT-001']);
            }
        }

        $request->validate([
            'id_jabatan' => 'required|unique:jabatans,id_jabatan',
            'nama_jabatan' => 'required',
        ]);

        Jabatan::create($request->all());

        return redirect()->route('jabatan.index')->with('success', 'Data Jabatan berhasil ditambahkan.');
    }

    public function edit(Jabatan $jabatan)
    {
        return view('jabatan.edit', compact('jabatan'));
    }

    public function update(Request $request, Jabatan $jabatan)
    {
        $request->validate([
            'id_jabatan' => 'required|unique:jabatans,id_jabatan,' . $jabatan->id_jabatan . ',id_jabatan',
            'nama_jabatan' => 'required',
        ]);

        $jabatan->update($request->all());

        return redirect()->route('jabatan.index')->with('success', 'Data Jabatan berhasil diubah.');
    }

    public function destroy(Jabatan $jabatan)
    {
        $jabatan->delete();
        return redirect()->route('jabatan.index')->with('success', 'Data Jabatan berhasil dihapus.');
    }

    public function destroyBulk(Request $request)
    {
        $ids = $request->input('selected_ids', []);
        if (empty($ids)) {
            return redirect()->route('jabatan.index')->with('error', 'Tidak ada data yang dipilih.');
        }

        Jabatan::whereIn('id_jabatan', $ids)->delete();
        return redirect()->route('jabatan.index')->with('success', count($ids) . ' Data Jabatan berhasil dihapus.');
    }
}


