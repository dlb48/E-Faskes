@extends('layouts.app')

@section('title', 'Tambah Data perawat')

@section('content')
<div class="max-w-4xl mx-auto pb-20">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('perawat.index') }}" class="text-slate-400 hover:text-brand-600 transition-colors">
            <i class="fa-solid fa-arrow-left text-xl"></i>
        </a>
        <h1 class="text-2xl font-bold text-slate-900">Registrasi perawat Baru</h1>
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

    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-6 flex items-start">
        <i class="fa-solid fa-circle-info text-blue-500 text-xl mr-3 mt-0.5"></i>
        <p class="text-sm text-blue-800">
            <strong>Informasi:</strong> Data perawat harus merujuk pada <strong>Data Pegawai</strong> yang sudah diinput sebelumnya. Hanya pegawai berstatus Aktif dengan departemen "Pelayanan Medis" yang akan muncul di pilihan bawah ini. 
            <a href="{{ route('pegawai.create') }}" class="font-bold underline hover:text-blue-900 transition-colors ml-1">Tambahkan data pegawai sekarang &rarr;</a>
        </p>
    </div>

    <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden mb-6">
        <div class="border-b border-slate-200 bg-slate-50 px-6 py-4">
            <h2 class="font-semibold text-slate-800"><i class="fa-solid fa-stethoscope text-brand-500 mr-2"></i>Input Data perawat</h2>
        </div>
        
        <form action="{{ route('perawat.store') }}" method="POST" class="p-6" id="formCreate" novalidate>
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Kode perawat (ID) <span class="text-red-500">*</span></label>
                    <input type="text" name="id_perawat" value="{{ old('id_perawat') }}" required class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500" placeholder="Contoh: D-001">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Pilih Pegawai (Calon perawat) <span class="text-red-500">*</span></label>
                    <select name="nip" required class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 bg-white">
                        <option value="">-- Silakan Pilih Pegawai --</option>
                        @foreach($pegawais as $pegawai)
                            <option value="{{ $pegawai->nip }}" {{ old('nip') == $pegawai->nip ? 'selected' : '' }}>
                                {{ $pegawai->nip }} - {{ $pegawai->nama_lengkap }} ({{ $pegawai->jabatan }})
                            </option>
                        @endforeach
                    </select>
                    @if($pegawais->isEmpty())
                        <p class="text-xs text-red-500 mt-1"><i class="fa-solid fa-triangle-exclamation mr-1"></i>Tidak ada pegawai yang memenuhi syarat atau semua pegawai yang memenuhi syarat sudah diregistrasikan sebagai perawat.</p>
                    @endif
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">No. STR (Surat Izin Praktik) <span class="text-red-500">*</span></label>
                    <input type="text" name="no_str" value="{{ old('no_str') }}" required class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500" placeholder="Contoh: 445/123/SIP.D/2026">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Masa Berlaku STR <span class="text-red-500">*</span></label>
                    <input type="date" name="masa_berlaku_str" value="{{ old('masa_berlaku_str') }}" required class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500">
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Poliklinik / Spesialisasi <span class="text-red-500">*</span></label>
                    <select name="poliklinik_id" required class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 bg-white">
                        <option value="">-- Pilih Poliklinik Tujuan --</option>
                        @foreach($polikliniks as $poli)
                            <option value="{{ $poli->kode_poli }}" {{ old('poliklinik_id') == $poli->kode_poli ? 'selected' : '' }}>
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
            <a href="{{ route('perawat.index') }}" class="px-5 py-2.5 bg-white border border-slate-300 text-slate-700 rounded-lg text-sm font-medium hover:bg-slate-50 transition-colors">Batal</a>
            <button type="submit" form="formCreate" class="px-5 py-2.5 bg-brand-600 text-white rounded-lg text-sm font-medium hover:bg-brand-700 transition-colors shadow-sm flex items-center" {{ $pegawais->isEmpty() ? 'disabled' : '' }}>
                <i class="fa-solid fa-save mr-2"></i> Simpan Data perawat
            </button>
        </div>
    </div>
</div>
@endsection
