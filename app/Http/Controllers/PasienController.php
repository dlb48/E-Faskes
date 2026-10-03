<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use Illuminate\Http\Request;

class PasienController extends Controller
{
    public function index()
    {
        $pasiens = Pasien::with('penjamin')->latest()->get();
        return view('pasien.index', compact('pasiens'));
    }

    public function create()
    {
        $penjamins = \App\Models\Penjamin::all();
        return view('pasien.create', compact('penjamins'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_rm' => 'nullable|string|max:20|unique:pasien,no_rm',
            'id_penjamin' => 'required|exists:penjamins,id_penjamin',
            'nik' => 'required|string|max:16|unique:pasien,nik',
            'no_kartu_bpjs' => 'nullable|string|max:13|unique:pasien,no_kartu_bpjs',
            'nama' => 'required|string|max:255',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'golongan_darah' => 'nullable|in:A,B,AB,O,Tidak Tahu',
            'agama' => 'nullable|string|max:50',
            'status_pernikahan' => 'nullable|string|max:50',
            'kewarganegaraan' => 'nullable|string|max:50',
            'nama_ibu_kandung' => 'nullable|string|max:255',
            'pendidikan' => 'nullable|string|max:100',
            'pekerjaan' => 'nullable|string|max:100',
            'alamat' => 'nullable|string',
            'provinsi' => 'nullable|string|max:255',
            'kabupaten' => 'nullable|string|max:255',
            'kecamatan' => 'nullable|string|max:255',
            'desa' => 'nullable|string|max:255',
            'rt' => 'nullable|string|max:5',
            'rw' => 'nullable|string|max:5',
            'kode_pos' => 'nullable|string|max:5',
            'no_telepon' => 'nullable|string|max:20',
            'nama_penanggung_jawab' => 'nullable|string|max:255',
            'hubungan_penanggung_jawab' => 'nullable|string|max:255',
            'alamat_penanggung_jawab' => 'nullable|string',
            'no_telepon_penanggung_jawab' => 'nullable|string|max:20'
        ]);

        $no_rm = $request->no_rm;
        if (empty($no_rm)) {
            $prefix = 'RM-' . date('ym') . '-';
            $lastPasien = Pasien::withTrashed()->where('no_rm', 'like', $prefix . '%')->orderBy('no_rm', 'desc')->first();
            if ($lastPasien && preg_match('/^' . preg_quote($prefix, '/') . '(\d+)$/', $lastPasien->no_rm, $matches)) {
                $no_rm = $prefix . str_pad((int)$matches[1] + 1, 4, '0', STR_PAD_LEFT);
            } else {
                $no_rm = $prefix . '0001';
            }
        }
        
        $penjamin_obj = \App\Models\Penjamin::find($request->id_penjamin);
        $jenis_pasien = $penjamin_obj ? $penjamin_obj->nama_penjamin : 'Umum';
        
        Pasien::create([
            'no_rm' => $no_rm,
            'id_penjamin' => $request->id_penjamin,
            'jenis_pasien' => $jenis_pasien,
            'nik' => $request->nik,
            'no_kartu_bpjs' => $request->no_kartu_bpjs,
            'nama' => $request->nama,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'golongan_darah' => $request->golongan_darah ?? 'Tidak Tahu',
            'agama' => $request->agama,
            'status_pernikahan' => $request->status_pernikahan,
            'kewarganegaraan' => $request->kewarganegaraan ?? 'WNI',
            'nama_ibu_kandung' => $request->nama_ibu_kandung,
            'pendidikan' => $request->pendidikan,
            'pekerjaan' => $request->pekerjaan,
            'alamat' => $request->alamat,
            'provinsi' => $request->provinsi,
            'kabupaten' => $request->kabupaten,
            'kecamatan' => $request->kecamatan,
            'desa' => $request->desa,
            'rt' => $request->rt,
            'rw' => $request->rw,
            'kode_pos' => $request->kode_pos,
            'no_telepon' => $request->no_telepon,
            'nama_penanggung_jawab' => $request->nama_penanggung_jawab,
            'hubungan_penanggung_jawab' => $request->hubungan_penanggung_jawab,
            'alamat_penanggung_jawab' => $request->alamat_penanggung_jawab,
            'no_telepon_penanggung_jawab' => $request->no_telepon_penanggung_jawab
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Data Pasien Baru berhasil disimpan dengan No. RM: ' . $no_rm
            ]);
        }
        return redirect()->route('pasien.index')->with('success', 'Data Pasien Baru berhasil disimpan dengan No. RM: ' . $no_rm);
    }

    public function edit($nik)
    {
        $pasien = Pasien::findOrFail($nik);
        $penjamins = \App\Models\Penjamin::all();
        return view('pasien.edit', compact('pasien', 'penjamins'));
    }

    public function update(Request $request, $nik)
    {
        $pasien = Pasien::findOrFail($nik);
        
        $request->validate([
            'no_rm' => 'required|string|max:20|unique:pasien,no_rm,'.$pasien->nik.',nik',
            'id_penjamin' => 'required|exists:penjamins,id_penjamin',
            'nik' => 'required|string|max:16|unique:pasien,nik,'.$pasien->nik.',nik',
            'no_kartu_bpjs' => 'nullable|string|max:13|unique:pasien,no_kartu_bpjs,'.$pasien->nik.',nik',
            'nama' => 'required|string|max:255',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'golongan_darah' => 'nullable|in:A,B,AB,O,Tidak Tahu',
            'agama' => 'nullable|string|max:50',
            'status_pernikahan' => 'nullable|string|max:50',
            'kewarganegaraan' => 'nullable|string|max:50',
            'nama_ibu_kandung' => 'nullable|string|max:255',
            'pendidikan' => 'nullable|string|max:100',
            'pekerjaan' => 'nullable|string|max:100',
            'alamat' => 'nullable|string',
            'provinsi' => 'nullable|string|max:255',
            'kabupaten' => 'nullable|string|max:255',
            'kecamatan' => 'nullable|string|max:255',
            'desa' => 'nullable|string|max:255',
            'rt' => 'nullable|string|max:5',
            'rw' => 'nullable|string|max:5',
            'kode_pos' => 'nullable|string|max:5',
            'no_telepon' => 'nullable|string|max:20',
            'nama_penanggung_jawab' => 'nullable|string|max:255',
            'hubungan_penanggung_jawab' => 'nullable|string|max:255',
            'alamat_penanggung_jawab' => 'nullable|string',
            'no_telepon_penanggung_jawab' => 'nullable|string|max:20'
        ]);

        $penjamin_obj = \App\Models\Penjamin::find($request->id_penjamin);
        $jenis_pasien = $penjamin_obj ? $penjamin_obj->nama_penjamin : 'Umum';
        $request->merge(['jenis_pasien' => $jenis_pasien]);

        $pasien->update($request->all());

        return redirect()->route('pasien.index')->with('success', 'Data Pasien berhasil diperbarui.');
    }

    public function destroy($nik)
    {
        $pasien = Pasien::findOrFail($nik);
        $pasien->delete();

        return redirect()->route('pasien.index')->with('success', 'Data Pasien berhasil dihapus.');
    }
}



