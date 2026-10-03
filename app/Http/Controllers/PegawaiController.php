<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Departemen;
use App\Models\Jabatan;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    public function index()
    {
        $pegawais = Pegawai::with(['departemen', 'jabatanData'])->latest()->get();
        return view('pegawai.index', compact('pegawais'));
    }

    public function create()
    {
        $departemens = Departemen::all();
        $jabatans = Jabatan::all();
        return view('pegawai.create', compact('departemens', 'jabatans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required|unique:pegawai,nip',
            'nama_lengkap' => 'required',
            'jenis_kelamin' => 'required',
            'id_departemen' => 'required|exists:departemens,id_departemen',
            'id_jabatan' => 'nullable|exists:jabatans,id_jabatan',
            'status_karyawan' => 'required',
        ]);

        Pegawai::create([
            'nip' => $request->nip,
            'nama_lengkap' => $request->nama_lengkap,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
            'no_telepon' => $request->no_telepon,
            'id_departemen' => $request->id_departemen,
            'id_jabatan' => $request->id_jabatan,
            'status_karyawan' => $request->status_karyawan,
            'tanggal_bergabung' => $request->tanggal_bergabung,
            'status_aktif' => $request->status_aktif == 1,
        ]);

        return redirect()->route('pegawai.index')->with('success', 'Data Pegawai berhasil ditambahkan.');
    }

    public function edit(Pegawai $pegawai)
    {
        $departemens = Departemen::all();
        $jabatans = Jabatan::all();
        return view('pegawai.edit', compact('pegawai', 'departemens', 'jabatans'));
    }

    public function update(Request $request, Pegawai $pegawai)
    {
        $request->validate([
            'nip' => 'required|unique:pegawai,nip,' . $pegawai->nip . ',nip',
            'nama_lengkap' => 'required',
            'jenis_kelamin' => 'required',
            'id_departemen' => 'required|exists:departemens,id_departemen',
            'id_jabatan' => 'nullable|exists:jabatans,id_jabatan',
            'status_karyawan' => 'required',
        ]);

        $pegawai->update([
            'nip' => $request->nip,
            'nama_lengkap' => $request->nama_lengkap,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
            'no_telepon' => $request->no_telepon,
            'id_departemen' => $request->id_departemen,
            'id_jabatan' => $request->id_jabatan,
            'status_karyawan' => $request->status_karyawan,
            'tanggal_bergabung' => $request->tanggal_bergabung,
            'status_aktif' => $request->status_aktif == 1,
        ]);

        return redirect()->route('pegawai.index')->with('success', 'Data Pegawai berhasil diubah.');
    }

    public function destroy(Pegawai $pegawai)
    {
        $pegawai->delete();
        return redirect()->route('pegawai.index')->with('success', 'Data Pegawai berhasil dihapus.');
    }
}


