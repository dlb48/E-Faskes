@extends('layouts.app')

@section('title', 'Ubah Antrean')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex items-center gap-4 mb-4">
        <a href="{{ route('pendaftaran.index') }}" class="text-slate-400 hover:text-slate-600 transition-colors">
            <i class="fa-solid fa-arrow-left text-xl"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Ubah Antrean</h1>
            <p class="text-sm text-slate-500 mt-1">Mengubah data antrean pendaftaran pasien</p>
        </div>
    </div>

    <form action="/pendaftaran/{{ $pendaftaran->id }}" method="POST" id="mainForm" novalidate>
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">
            
            <!-- Kolom Kiri: Pasien -->
            <div class="lg:col-span-4 flex flex-col h-[calc(100vh-220px)]">
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden flex flex-col h-full">
                    
                    <div class="px-4 py-3 border-b border-slate-100 bg-slate-50 flex items-center justify-between gap-3 h-[60px]">
                        <h3 class="text-sm font-bold text-slate-800 flex-shrink-0"><i class="fa-solid fa-user mr-2 text-brand-500"></i> Data Pasien</h3>
                    </div>

                    <div class="flex flex-col flex-1 overflow-hidden relative bg-slate-50 p-4">
                        <!-- Patient Card mimicking the list -->
                        <div class="block border-2 border-brand-500 bg-brand-50/50 rounded-xl p-3 cursor-not-allowed shadow-sm relative">
                            <div class="absolute -top-2 -right-2 bg-brand-500 text-white rounded-full w-6 h-6 flex items-center justify-center shadow">
                                <i class="fa-solid fa-check text-xs"></i>
                            </div>
                            <div class="flex justify-between items-start mb-1">
                                <span class="block text-[13px] font-bold text-slate-900 truncate pr-2">{{ $pendaftaran->pasien->nama }}</span>
                                <span class="block text-[10px] font-mono font-bold text-brand-700 bg-brand-50 border border-brand-200 px-1 py-0.5 rounded">{{ $pendaftaran->pasien->no_rm }}</span>
                            </div>
                            <div class="text-[10px] text-slate-500 mt-0.5">NIK: {{ $pendaftaran->pasien->nik }} | {{ $pendaftaran->pasien->penjamin->nama_penjamin ?? '-' }}{{ $pendaftaran->pasien->no_kartu_bpjs ? ' (' . $pendaftaran->pasien->no_kartu_bpjs . ')' : '' }}</div>
                        </div>
                        
                        <div class="mt-4 text-center">
                            <span class="inline-flex items-center justify-center px-3 py-1.5 bg-yellow-100 border border-yellow-200 text-yellow-700 text-xs font-bold rounded-full shadow-sm">
                                <i class="fa-solid fa-lock mr-1.5"></i> Pasien Tidak Dapat Diubah
                            </span>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Kolom Kanan: Poliklinik & Simpan -->
            <div class="lg:col-span-8 flex flex-col h-[calc(100vh-220px)]">
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden flex flex-col h-full">
                    
                    <div class="px-4 py-3 border-b border-slate-100 bg-slate-50 flex items-center justify-between h-[60px]">
                        <h3 class="text-sm font-bold text-slate-800"><i class="fa-solid fa-stethoscope mr-2 text-brand-500"></i> Informasi Layanan</h3>
                        <span class="px-2.5 py-1 bg-brand-100 text-brand-700 text-xs font-bold rounded">No Antrean: {{ $pendaftaran->no_antrean }}</span>
                    </div>

                    <div class="flex-1 overflow-y-auto p-5">
                        
                        <div class="mb-5">
                            <label class="block text-sm font-bold text-slate-700 mb-2">Penjamin <span class="text-rose-500">*</span></label>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                @foreach($penjamins as $penj)
                                <label class="flex items-center p-3 border border-slate-200 rounded-lg cursor-pointer hover:bg-slate-50 transition-colors">
                                    <input type="radio" name="id_penjamin" value="{{ $penj->id_penjamin }}" class="w-4 h-4 text-brand-600 focus:ring-brand-500" required {{ $pendaftaran->id_penjamin == $penj->id_penjamin ? 'checked' : '' }}>
                                    <span class="ml-2 text-sm font-medium text-slate-700">{{ $penj->nama_penjamin }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Pilih Poliklinik Tujuan <span class="text-rose-500">*</span></label>
                            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3">
                                @foreach($polikliniks as $poli)
                                <label class="relative flex items-center justify-center p-3 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-50 transition-colors">
                                    <input type="radio" name="kode_poli" value="{{ $poli->kode_poli }}" class="absolute h-0 w-0 opacity-0 peer" required {{ $pendaftaran->kode_poli == $poli->kode_poli ? 'checked' : '' }}>
                                    <div class="peer-checked:border-brand-500 peer-checked:bg-brand-50 peer-checked:ring-1 peer-checked:ring-brand-500 absolute inset-0 rounded-xl transition-all"></div>
                                    <div class="relative z-10 text-center">
                                        <div class="text-brand-600 mb-1"><i class="fa-solid fa-user-doctor text-xl"></i></div>
                                        <span class="block text-[13px] font-bold text-slate-700">{{ $poli->nama_poli }}</span>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>

                    </div>

                    <div class="px-4 py-3 border-t border-slate-100 bg-slate-50 flex items-center justify-end h-[60px]">
                        <button type="submit" class="px-6 py-2 bg-brand-600 text-white rounded-lg text-sm font-bold hover:bg-brand-700 shadow-sm flex items-center transition-all disabled:opacity-50">
                            <i class="fa-solid fa-save mr-2"></i> Simpan Perubahan
                        </button>
                    </div>

                </div>
            </div>

        </div>
    </form>
</div>
@endsection
