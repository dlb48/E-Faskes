@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<div class="pt-6 pb-12 max-w-7xl mx-auto">

    <!-- Kelompok 1: Layanan & Operasional -->
    <div class="mb-10">
        <div class="flex items-center mb-5">
            <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center mr-3 shadow-sm">
                <i class="fa-solid fa-stethoscope"></i>
            </div>
            <h2 class="text-xl font-bold text-slate-800">Layanan & Operasional</h2>
            <div class="h-px bg-slate-200 flex-grow ml-6"></div>
        </div>
        
        <div class="flex flex-wrap justify-start gap-4 sm:gap-6">
            <a href="{{ route('pendaftaran.index') }}" class="px-8 py-5 bg-white border border-slate-200 rounded-2xl shadow-sm hover:shadow-lg hover:border-blue-400 hover:bg-blue-50 transition-all font-bold text-slate-700 hover:text-blue-700 text-lg flex flex-col items-center min-w-[170px] group">
                <i class="fa-solid fa-clipboard-user mb-4 text-slate-400 group-hover:text-blue-500 text-4xl transition-colors"></i> 
                Pendaftaran
            </a>
            
            <a href="#" class="px-8 py-5 bg-white border border-slate-200 rounded-2xl shadow-sm hover:shadow-lg hover:border-blue-400 hover:bg-blue-50 transition-all font-bold text-slate-700 hover:text-blue-700 text-lg flex flex-col items-center min-w-[170px] group">
                <i class="fa-solid fa-stethoscope mb-4 text-slate-400 group-hover:text-blue-500 text-4xl transition-colors"></i> 
                Rawat Jalan
            </a>

            <a href="#" class="px-8 py-5 bg-white border border-slate-200 rounded-2xl shadow-sm hover:shadow-lg hover:border-blue-400 hover:bg-blue-50 transition-all font-bold text-slate-700 hover:text-blue-700 text-lg flex flex-col items-center min-w-[170px] group">
                <i class="fa-solid fa-bed-pulse mb-4 text-slate-400 group-hover:text-blue-500 text-4xl transition-colors"></i> 
                Rawat Inap
            </a>
        </div>
    </div>

    <!-- Kelompok 2: Master Data -->
    <div class="mb-10">
        <div class="flex items-center mb-5">
            <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center mr-3 shadow-sm">
                <i class="fa-solid fa-database"></i>
            </div>
            <h2 class="text-xl font-bold text-slate-800">Master Data</h2>
            <div class="h-px bg-slate-200 flex-grow ml-6"></div>
        </div>
        
        <div class="flex flex-wrap justify-start gap-4 sm:gap-6">
            <a href="{{ route('poliklinik.index') }}" class="px-8 py-5 bg-white border border-slate-200 rounded-2xl shadow-sm hover:shadow-lg hover:border-emerald-400 hover:bg-emerald-50 transition-all font-bold text-slate-700 hover:text-emerald-700 text-lg flex flex-col items-center min-w-[170px] group">
                <i class="fa-solid fa-house-medical mb-4 text-slate-400 group-hover:text-emerald-500 text-4xl transition-colors"></i> 
                Poliklinik
            </a>

            <a href="{{ route('pasien.index') }}" class="px-8 py-5 bg-white border border-slate-200 rounded-2xl shadow-sm hover:shadow-lg hover:border-emerald-400 hover:bg-emerald-50 transition-all font-bold text-slate-700 hover:text-emerald-700 text-lg flex flex-col items-center min-w-[170px] group">
                <i class="fa-solid fa-users mb-4 text-slate-400 group-hover:text-emerald-500 text-4xl transition-colors"></i> 
                Data Pasien
            </a>
            
            <a href="{{ route('pegawai.index') }}" class="px-8 py-5 bg-white border border-slate-200 rounded-2xl shadow-sm hover:shadow-lg hover:border-emerald-400 hover:bg-emerald-50 transition-all font-bold text-slate-700 hover:text-emerald-700 text-lg flex flex-col items-center min-w-[170px] group">
                <i class="fa-solid fa-user-tie mb-4 text-slate-400 group-hover:text-emerald-500 text-4xl transition-colors"></i> 
                Data Pegawai
            </a>

            <a href="{{ route('dokter.index') }}" class="px-8 py-5 bg-white border border-slate-200 rounded-2xl shadow-sm hover:shadow-lg hover:border-emerald-400 hover:bg-emerald-50 transition-all font-bold text-slate-700 hover:text-emerald-700 text-lg flex flex-col items-center min-w-[170px] group">
                <i class="fa-solid fa-user-doctor mb-4 text-slate-400 group-hover:text-emerald-500 text-4xl transition-colors"></i> 
                Dokter
            </a>

            <a href="#" class="px-8 py-5 bg-white border border-slate-200 rounded-2xl shadow-sm hover:shadow-lg hover:border-emerald-400 hover:bg-emerald-50 transition-all font-bold text-slate-700 hover:text-emerald-700 text-lg flex flex-col items-center min-w-[170px] group">
                <i class="fa-solid fa-user-nurse mb-4 text-slate-400 group-hover:text-emerald-500 text-4xl transition-colors"></i> 
                Perawat
            </a>
        </div>
    </div>

    <!-- Kelompok 3: Farmasi & Keuangan -->
    <div>
        <div class="flex items-center mb-5">
            <div class="w-8 h-8 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center mr-3 shadow-sm">
                <i class="fa-solid fa-pills"></i>
            </div>
            <h2 class="text-xl font-bold text-slate-800">Farmasi & Keuangan</h2>
            <div class="h-px bg-slate-200 flex-grow ml-6"></div>
        </div>
        
        <div class="flex flex-wrap justify-start gap-4 sm:gap-6">
            <a href="#" class="px-8 py-5 bg-white border border-slate-200 rounded-2xl shadow-sm hover:shadow-lg hover:border-amber-400 hover:bg-amber-50 transition-all font-bold text-slate-700 hover:text-amber-700 text-lg flex flex-col items-center min-w-[170px] group">
                <i class="fa-solid fa-prescription-bottle-medical mb-4 text-slate-400 group-hover:text-amber-500 text-4xl transition-colors"></i> 
                Apotek
            </a>
            
            <a href="#" class="px-8 py-5 bg-white border border-slate-200 rounded-2xl shadow-sm hover:shadow-lg hover:border-amber-400 hover:bg-amber-50 transition-all font-bold text-slate-700 hover:text-amber-700 text-lg flex flex-col items-center min-w-[170px] group">
                <i class="fa-solid fa-cash-register mb-4 text-slate-400 group-hover:text-amber-500 text-4xl transition-colors"></i> 
                Kasir
            </a>
        </div>
    </div>

</div>
@endsection
