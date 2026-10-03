@extends('layouts.app')

@section('title', 'Ubah Data Dokter')

@section('content')
<div class="max-w-4xl mx-auto pb-20">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('dokter.index') }}" class="text-slate-400 hover:text-brand-600 transition-colors">
            <i class="fa-solid fa-arrow-left text-xl"></i>
        </a>
        <h1 class="text-2xl font-bold text-slate-900">Ubah Data Dokter</h1>
    </div>

    @if($errors->any())
    <div class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200">
        <div class="flex items-center mb-2">
            <i class="fa-solid fa-circle-exclamation text-red-500 mr-2"></i>
            <span class="text-red-800 font-bold text-sm">Terdapat kesalahan pengisian:</span>
        </div>
        <ul class="list-disc list-inside text-sm text-red-700">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 mb-6 flex items-start">
        <i class="fa-solid fa-circle-info text-amber-500 text-xl mr-3 mt-0.5"></i>
        <p class="text-sm text-amber-800">
            <strong>Informasi:</strong> Profil dasar dokter (seperti nama, NIP, alamat) tidak dapat diubah di halaman ini. Jika ingin mengubah profil dasar, silakan ubah melalui menu <strong>Data Pegawai</strong>.
        </p>
    </div>

    <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden mb-6">
        <div class="border-b border-slate-200 bg-slate-50 px-6 py-4">
            <h2 class="font-semibold text-slate-800"><i class="fa-solid fa-stethoscope text-amber-500 mr-2"></i>Input Data Dokter</h2>
        </div>
        
        <form novalidate action="{{ route('dokter.update', $dokter->id_dokter) }}" method="POST" class="p-6" id="formEdit">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Kode Dokter (ID)</label>
                    <input type="text" name="id_dokter" value="{{ $dokter->id_dokter }}" required class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Pegawai (Dokter)</label>
                    <select name="nip" required class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500">
                        @foreach($pegawais as $pegawai)
                            <option value="{{ $pegawai->nip }}" selected>
                                {{ $pegawai->nip }} - {{ $pegawai->nama_lengkap }} ({{ $pegawai->jabatan }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">No. SIP (Surat Izin Praktik) <span class="text-red-500">*</span></label>
                    <input type="text" name="no_sip" value="{{ old('no_sip', $dokter->no_sip) }}" required class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Masa Berlaku SIP <span class="text-red-500">*</span></label>
                    <input type="date" name="masa_berlaku_sip" value="{{ old('masa_berlaku_sip', $dokter->masa_berlaku_sip) }}" required class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500">
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Poliklinik / Spesialisasi <span class="text-red-500">*</span></label>
                    <select name="poliklinik_id" required class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 bg-white">
                        <option value="">-- Pilih Poliklinik Tujuan --</option>
                        @foreach($polikliniks as $poli)
                            <option value="{{ $poli->kode_poli }}" {{ old('poliklinik_id', $dokter->poliklinik_id) == $poli->kode_poli ? 'selected' : '' }}>
                                {{ $poli->kode_poli }} - {{ $poli->nama_poli }}
                            </option>
                        @endforeach
                    </select>
                </div>


            </div>
        </form>
    </div>

    <!-- Fixed action buttons -->
    <div class="fixed bottom-0 left-0 w-full bg-white border-t border-slate-200 z-50 shadow-[0_-10px_15px_-3px_rgba(0,0,0,0.05)]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex justify-end gap-3">
            <a href="{{ route('dokter.index') }}" class="px-5 py-2.5 bg-white border border-slate-300 text-slate-700 rounded-lg text-sm font-medium hover:bg-slate-50 transition-colors">Batal</a>
            <button type="submit" form="formEdit" class="px-5 py-2.5 bg-amber-500 text-white rounded-lg text-sm font-medium hover:bg-amber-600 transition-colors shadow-sm flex items-center">
                <i class="fa-solid fa-save mr-2"></i> Simpan Perubahan
            </button>
        </div>
    </div>
</div>
@endsection


