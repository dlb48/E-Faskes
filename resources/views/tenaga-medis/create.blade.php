@extends('layouts.app')

@section('title', 'Tambah Tenaga Medis')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('tenaga-medis.index') }}" class="text-slate-400 hover:text-brand-600 transition-colors">
            <i class="fa-solid fa-arrow-left text-xl"></i>
        </a>
        <h1 class="text-2xl font-bold text-slate-900">Tambah Tenaga Medis</h1>
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

    <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
        <div class="border-b border-slate-200 bg-slate-50 px-6 py-4">
            <h2 class="font-semibold text-slate-800"><i class="fa-solid fa-user-doctor text-brand-500 mr-2"></i>Identitas Nakes</h2>
        </div>
        
        <form action="{{ route('tenaga-medis.store') }}" method="POST" class="p-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Kode Nakes <span class="text-red-500">*</span></label>
                    <input type="text" name="kode_tenaga_medis" value="{{ old('kode_tenaga_medis') }}" required class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500" placeholder="Contoh: D01">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Nama Lengkap & Gelar <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500" placeholder="Contoh: Dr. Andi, Sp.PD">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">NIK (KTP)</label>
                    <input type="text" name="nik" value="{{ old('nik') }}" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500" placeholder="16 Digit NIK">
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">No. SIP (Surat Izin Praktik)</label>
                    <input type="text" name="no_sip" value="{{ old('no_sip') }}" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Profesi <span class="text-red-500">*</span></label>
                    <select name="profesi" required class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 bg-white">
                        <option value="">-- Pilih Profesi --</option>
                        <option value="Dokter Umum" {{ old('profesi') == 'Dokter Umum' ? 'selected' : '' }}>Dokter Umum</option>
                        <option value="Dokter Gigi" {{ old('profesi') == 'Dokter Gigi' ? 'selected' : '' }}>Dokter Gigi</option>
                        <option value="Dokter Spesialis" {{ old('profesi') == 'Dokter Spesialis' ? 'selected' : '' }}>Dokter Spesialis</option>
                        <option value="Perawat" {{ old('profesi') == 'Perawat' ? 'selected' : '' }}>Perawat</option>
                        <option value="Bidan" {{ old('profesi') == 'Bidan' ? 'selected' : '' }}>Bidan</option>
                        <option value="Lainnya" {{ old('profesi') == 'Lainnya' ? 'selected' : '' }}>Tenaga Medis Lainnya</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Spesialisasi</label>
                    <input type="text" name="spesialisasi" value="{{ old('spesialisasi') }}" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500" placeholder="Isi jika Dokter Spesialis">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">No. Telepon / HP</label>
                    <input type="text" name="no_telepon" value="{{ old('no_telepon') }}" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Penugasan Poliklinik</label>
                    <select name="poliklinik_id" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 bg-white">
                        <option value="">-- Tidak Ditugaskan di Poli --</option>
                        @foreach($polikliniks as $poli)
                            <option value="{{ $poli->id }}" {{ old('poliklinik_id') == $poli->id ? 'selected' : '' }}>
                                {{ $poli->kode_poli }} - {{ $poli->nama_poli }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Status Tenaga Medis <span class="text-red-500">*</span></label>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-2 cursor-pointer p-3 border border-slate-200 rounded-lg hover:bg-slate-50 transition-colors w-full sm:w-auto">
                            <input type="radio" name="status_aktif" value="1" class="w-4 h-4 text-brand-600 border-slate-300 focus:ring-brand-500" checked>
                            <span class="text-sm font-medium text-slate-700">Aktif Praktik</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer p-3 border border-slate-200 rounded-lg hover:bg-slate-50 transition-colors w-full sm:w-auto">
                            <input type="radio" name="status_aktif" value="0" class="w-4 h-4 text-red-600 border-slate-300 focus:ring-red-500">
                            <span class="text-sm font-medium text-slate-700">Tidak Aktif / Cuti</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-6 border-t border-slate-200">
                <a href="{{ route('tenaga-medis.index') }}" class="px-5 py-2.5 bg-white border border-slate-300 text-slate-700 rounded-lg text-sm font-medium hover:bg-slate-50 transition-colors">Batal</a>
                <button type="submit" class="px-5 py-2.5 bg-brand-600 text-white rounded-lg text-sm font-medium hover:bg-brand-700 transition-colors shadow-sm flex items-center">
                    <i class="fa-solid fa-save mr-2"></i> Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
