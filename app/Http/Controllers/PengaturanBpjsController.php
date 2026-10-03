<?php

namespace App\Http\Controllers;

use App\Models\PengaturanBpjs;
use Illuminate\Http\Request;

class PengaturanBpjsController extends Controller
{
    public function index()
    {
        // Ambil data pertama, jika belum ada buat instance kosong
        $pengaturan = PengaturanBpjs::first() ?? new PengaturanBpjs();
        
        return view('pengaturan.bpjs', compact('pengaturan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cons_id' => 'nullable|string|max:255',
            'secret_key' => 'nullable|string|max:255',
            'user_key' => 'nullable|string|max:255',
            'kode_ppk' => 'nullable|string|max:255',
            'is_production' => 'nullable|boolean',
        ]);

        $pengaturan = PengaturanBpjs::first();
        
        $data = [
            'cons_id' => $request->cons_id,
            'secret_key' => $request->secret_key,
            'user_key' => $request->user_key,
            'kode_ppk' => $request->kode_ppk,
            'is_production' => $request->has('is_production'),
        ];

        if ($pengaturan) {
            $pengaturan->update($data);
        } else {
            PengaturanBpjs::create($data);
        }

        return redirect()->route('pengaturan.bpjs.index')
            ->with('success', 'Konfigurasi Bridging BPJS JKN berhasil disimpan!');
    }
}
