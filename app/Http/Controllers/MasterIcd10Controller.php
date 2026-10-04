<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterIcd10;

class MasterIcd10Controller extends Controller
{
    public function index(Request $request)
    {
        // Retrieve all active records for client-side search
        $icds = MasterIcd10::orderBy('kode_icd10', 'asc')->get();
        return view('master_icd10.index', compact('icds'));
    }
    
    // Endpoint khusus untuk pencarian via AJAX Select2
    public function search(Request $request)
    {
        $term = $request->input('q');
        
        $query = MasterIcd10::query();
        
        if ($term) {
            $query->where(function($q) use ($term) {
                $q->where('kode_icd10', 'like', "%{$term}%")
                  ->orWhere('nama_diagnosa', 'like', "%{$term}%");
            });
        }
        
        $results = $query->limit(30)->get()->map(function($item) {
            return [
                'id' => $item->kode_icd10, // Simpan kode ICD-10 sebagai value/id
                'text' => $item->kode_icd10 . ' - ' . $item->nama_diagnosa, // Teks yang tampil di dropdown
                'nama' => $item->nama_diagnosa // Data extra untuk mengisi kolom nama otomatis
            ];
        });
        
        return response()->json([
            'results' => $results
        ]);
    }

    public function create()
    {
        return view('master_icd10.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_icd10' => 'required|unique:master_icd10s',
            'nama_diagnosa' => 'required',
        ]);
        MasterIcd10::create($request->all());
        return redirect()->route('icd10.index')->with('success', 'Data ICD-10 berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $icd = MasterIcd10::findOrFail($id);
        return view('master_icd10.edit', compact('icd'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(['nama_diagnosa' => 'required']);
        $icd = MasterIcd10::findOrFail($id);
        // exclude kode_icd10 if it's protected from edit, or allow it but validate unique ignoring itself
        $icd->update($request->only(['nama_diagnosa', 'is_active']));
        return redirect()->route('icd10.index')->with('success', 'Data ICD-10 berhasil diubah.');
    }

    public function destroy($id)
    {
        MasterIcd10::destroy($id);
        return redirect()->route('icd10.index')->with('success', 'Data ICD-10 berhasil dihapus.');
    }
    
    public function destroyBulk(Request $request)
    {
        $ids = $request->input('ids');
        if($ids && is_array($ids)) {
            MasterIcd10::destroy($ids);
            return redirect()->route('icd10.index')->with('success', count($ids) . ' data ICD-10 berhasil dihapus.');
        }
        return redirect()->route('icd10.index')->with('error', 'Tidak ada data yang dipilih.');
    }
}
