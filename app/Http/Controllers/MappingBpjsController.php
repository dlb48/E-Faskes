<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Poliklinik;
use App\Models\Dokter;
use Illuminate\Support\Facades\DB;

class MappingBpjsController extends Controller
{
    // --- MAPPING POLI ---
    
    // Data Simulasi (Mock) dari BPJS untuk Poli
    private $mockBpjsPoli = [
        ['kdpoli' => 'ANA', 'nmpoli' => 'ANAK'],
        ['kdpoli' => 'GIG', 'nmpoli' => 'GIGI DAN MULUT'],
        ['kdpoli' => 'UMU', 'nmpoli' => 'UMUM'],
        ['kdpoli' => 'INT', 'nmpoli' => 'PENYAKIT DALAM'],
        ['kdpoli' => 'MAT', 'nmpoli' => 'MATA'],
        ['kdpoli' => 'SAR', 'nmpoli' => 'SARAF'],
    ];

    public function mappingPoli()
    {
        // Tampilkan hanya poli yang SUDAH di-mapping
        $mappedPolis = Poliklinik::whereNotNull('kode_bpjs')->get();
        $mockData = collect($this->mockBpjsPoli);
        
        return view('mapping.poli.index', compact('mappedPolis', 'mockData'));
    }

    public function createMappingPoli()
    {
        // Tampilkan poli lokal yang BELUM di-mapping
        $unmappedPolis = Poliklinik::whereNull('kode_bpjs')->get();
        $mockData = $this->mockBpjsPoli;

        return view('mapping.poli.create', compact('unmappedPolis', 'mockData'));
    }


    public function searchBpjsPoli(Request $request)
    {
        $keyword = strtolower($request->query("keyword", ""));
        if (strlen($keyword) < 3) {
            return response()->json(["success" => false, "message" => "Minimal 3 karakter"]);
        }

        $bpjsService = new \App\Services\BpjsService();
        $response = $bpjsService->getReferensiPoli();

        // Cek response BPJS (biasanya data ada di response atau list)
        if (isset($response["metadata"]) && !in_array($response["metadata"]["code"], [1, 200, "1", "200"])) {
            return response()->json(["success" => false, "message" => $response["metadata"]["message"] ?? "Gagal mengambil data dari BPJS"]);
        }

        $dataPoli = $response["response"] ?? [];
        
        $results = collect($dataPoli)->filter(function ($item) use ($keyword) {
            return str_contains(strtolower($item["kdpoli"] ?? ""), $keyword) || 
                   str_contains(strtolower($item["nmpoli"] ?? ""), $keyword) ||
                   str_contains(strtolower($item["kdsubspesialis"] ?? ""), $keyword) ||
                   str_contains(strtolower($item["nmsubspesialis"] ?? ""), $keyword);
        })->values();

        // Normalisasi response agar frontend tidak rusak (karena frontend ekspektasi kdpoli dan nmpoli)
        $mappedResults = $results->map(function($item) {
            return [
                "kdpoli" => $item["kdpoli"] ?? $item["kdsubspesialis"] ?? "",
                "nmpoli" => $item["nmpoli"] ?? $item["nmsubspesialis"] ?? ""
            ];
        });

        return response()->json(["success" => true, "data" => $mappedResults]);
    }


    public function editMappingPoli($kode_poli)
    {
        $poli = Poliklinik::where('kode_poli', $kode_poli)->firstOrFail();
        $mockData = collect($this->mockBpjsPoli);

        return view('mapping.poli.edit', compact('poli', 'mockData'));
    }

    public function storeMappingPoli(Request $request)
    {
        $request->validate([
            'kode_poli_lokal' => 'required|exists:poliklinik,kode_poli',
            'kode_poli_bpjs' => 'required',
        ]);

        Poliklinik::where('kode_poli', $request->kode_poli_lokal)->update([
            'kode_bpjs' => $request->kode_poli_bpjs
        ]);

        return redirect()->route('mapping.poli')->with('success', 'Mapping Poliklinik BPJS berhasil ditambahkan!');
    }

    public function destroyMappingPoli(Request $request)
    {
        $request->validate(['selected_ids' => 'required|array']);
        
        Poliklinik::whereIn('kode_poli', $request->selected_ids)->update([
            'kode_bpjs' => null
        ]);

        return redirect()->back()->with('success', 'Mapping Poliklinik BPJS berhasil dihapus!');
    }

    // --- MAPPING DOKTER ---

    // Data Simulasi (Mock) dari BPJS untuk Dokter
    private $mockBpjsDokter = [
        ['kddokter' => '10001', 'nmdokter' => 'dr. Budi Santoso, Sp.A'],
        ['kddokter' => '10002', 'nmdokter' => 'drg. Siti Aminah'],
        ['kddokter' => '10003', 'nmdokter' => 'dr. Andi Wijaya'],
        ['kddokter' => '10004', 'nmdokter' => 'dr. Rina Mulyani, Sp.PD'],
    ];

    public function mappingDokter()
    {
        // Tampilkan hanya dokter yang SUDAH di-mapping
        $mappedDokters = Dokter::with(['pegawai', 'poliklinik'])->whereNotNull('kode_bpjs')->get();
        $mockData = collect($this->mockBpjsDokter);
        
        return view('mapping.dokter.index', compact('mappedDokters', 'mockData'));
    }

    public function createMappingDokter()
    {
        // Tampilkan dokter lokal yang BELUM di-mapping
        $unmappedDokters = Dokter::with(['pegawai', 'poliklinik'])->whereNull('kode_bpjs')->get();
        $mockData = $this->mockBpjsDokter;

        return view('mapping.dokter.create', compact('unmappedDokters', 'mockData'));
    }


    public function searchBpjsDokter(Request $request)
    {
        $keyword = strtolower($request->query("keyword", ""));
        if (strlen($keyword) < 3) {
            return response()->json(["success" => false, "message" => "Minimal 3 karakter"]);
        }

        $bpjsService = new \App\Services\BpjsService();
        $response = $bpjsService->getReferensiDokter();

        if (isset($response["metadata"]) && !in_array($response["metadata"]["code"], [1, 200, "1", "200"])) {
            return response()->json(["success" => false, "message" => $response["metadata"]["message"] ?? "Gagal mengambil data dari BPJS"]);
        }

        $dataDokter = $response["response"] ?? [];

        $results = collect($dataDokter)->filter(function ($item) use ($keyword) {
            return str_contains(strtolower($item["kodedokter"] ?? ""), $keyword) || 
                   str_contains(strtolower($item["namadokter"] ?? ""), $keyword);
        })->values();

        // Normalisasi response agar frontend tidak rusak
        $mappedResults = $results->map(function($item) {
            return [
                "kddokter" => $item["kodedokter"] ?? "",
                "nmdokter" => $item["namadokter"] ?? ""
            ];
        });

        return response()->json(["success" => true, "data" => $mappedResults]);
    }


    public function editMappingDokter($id_dokter)
    {
        $dokter = Dokter::with(['pegawai', 'poliklinik'])->where('id_dokter', $id_dokter)->firstOrFail();
        $mockData = collect($this->mockBpjsDokter);

        return view('mapping.dokter.edit', compact('dokter', 'mockData'));
    }

    public function storeMappingDokter(Request $request)
    {
        $request->validate([
            'id_dokter_lokal' => 'required|exists:dokters,id_dokter',
            'kode_dokter_bpjs' => 'required',
        ]);

        Dokter::where('id_dokter', $request->id_dokter_lokal)->update([
            'kode_bpjs' => $request->kode_dokter_bpjs
        ]);

        return redirect()->route('mapping.dokter')->with('success', 'Mapping Dokter BPJS berhasil ditambahkan!');
    }

    public function destroyMappingDokter(Request $request)
    {
        $request->validate(['selected_ids' => 'required|array']);
        
        Dokter::whereIn('id_dokter', $request->selected_ids)->update([
            'kode_bpjs' => null
        ]);

        return redirect()->back()->with('success', 'Mapping Dokter BPJS berhasil dihapus!');
    }
}









