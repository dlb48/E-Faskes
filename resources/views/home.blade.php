@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<div class="pt-4">

    <!-- Daftar Menu -->
    <div class="flex flex-wrap justify-start gap-4 sm:gap-6">
        <a href="{{ route('pendaftaran.index') }}" class="px-8 py-4 bg-white border-2 border-slate-100 rounded-2xl shadow-sm hover:shadow-lg hover:border-brand-400 hover:bg-brand-50 transition-all font-bold text-slate-700 hover:text-brand-700 text-lg flex flex-col items-center min-w-[160px] group">
            <i class="fa-solid fa-clipboard-user mb-3 text-slate-400 group-hover:text-brand-500 text-3xl transition-colors"></i> 
            Pendaftaran
        </a>
        
        <a href="{{ route('pasien.index') }}" class="px-8 py-4 bg-white border-2 border-slate-100 rounded-2xl shadow-sm hover:shadow-lg hover:border-brand-400 hover:bg-brand-50 transition-all font-bold text-slate-700 hover:text-brand-700 text-lg flex flex-col items-center min-w-[160px] group">
            <i class="fa-solid fa-users mb-3 text-slate-400 group-hover:text-brand-500 text-3xl transition-colors"></i> 
            Data Pasien
        </a>
        
        <a href="{{ route('poliklinik.index') }}" class="px-8 py-4 bg-white border-2 border-slate-100 rounded-2xl shadow-sm hover:shadow-lg hover:border-brand-400 hover:bg-brand-50 transition-all font-bold text-slate-700 hover:text-brand-700 text-lg flex flex-col items-center min-w-[160px] group">
            <i class="fa-solid fa-stethoscope mb-3 text-slate-400 group-hover:text-brand-500 text-3xl transition-colors"></i> 
            Poliklinik
        </a>
        
        <a href="{{ route('tenaga-medis.index') }}" class="px-8 py-4 bg-white border-2 border-slate-100 rounded-2xl shadow-sm hover:shadow-lg hover:border-brand-400 hover:bg-brand-50 transition-all font-bold text-slate-700 hover:text-brand-700 text-lg flex flex-col items-center min-w-[160px] group">
            <i class="fa-solid fa-user-doctor mb-3 text-slate-400 group-hover:text-brand-500 text-3xl transition-colors"></i> 
            Tenaga Medis
        </a>
        
        <a href="#" class="px-8 py-4 bg-white border-2 border-slate-100 rounded-2xl shadow-sm hover:shadow-lg hover:border-brand-400 hover:bg-brand-50 transition-all font-bold text-slate-700 hover:text-brand-700 text-lg flex flex-col items-center min-w-[160px] group">
            <i class="fa-solid fa-pills mb-3 text-slate-400 group-hover:text-brand-500 text-3xl transition-colors"></i> 
            Apotek
        </a>
        
        <a href="#" class="px-8 py-4 bg-white border-2 border-slate-100 rounded-2xl shadow-sm hover:shadow-lg hover:border-brand-400 hover:bg-brand-50 transition-all font-bold text-slate-700 hover:text-brand-700 text-lg flex flex-col items-center min-w-[160px] group">
            <i class="fa-solid fa-cash-register mb-3 text-slate-400 group-hover:text-brand-500 text-3xl transition-colors"></i> 
            Kasir
        </a>
    </div>

</div>
@endsection
