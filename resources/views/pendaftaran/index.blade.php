@extends('layouts.app')

@section('title', 'Antrean Pendaftaran')

@section('content')
<!-- Header Halaman -->
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Antrean Pendaftaran</h1>
        <p class="text-sm text-slate-500 mt-1">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
    </div>
    <div class="flex gap-3">
        <button class="bg-white border border-slate-300 text-slate-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-slate-50 transition-colors shadow-sm">
            <i class="fa-solid fa-print mr-2"></i> Cetak Antrean
        </button>
        <a href="{{ route('pendaftaran.create') }}" class="bg-brand-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-brand-700 transition-colors shadow-sm flex items-center">
            <i class="fa-solid fa-plus mr-2"></i> Pasien Baru
        </a>
    </div>
</div>

<!-- Kartu Konten Utama -->
<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    
    <!-- Toolbar Tabel -->
    <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
        <div class="relative w-72">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fa-solid fa-magnifying-glass text-slate-400"></i>
            </div>
            <input type="text" class="block w-full pl-10 pr-3 py-2 border border-slate-300 rounded-lg leading-5 bg-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 sm:text-sm transition-all" placeholder="Cari nama atau No. RM (Ctrl+K)">
        </div>
        
        <div class="flex gap-2 text-sm">
            <select class="border border-slate-300 rounded-lg px-3 py-2 bg-white text-slate-700 focus:outline-none focus:ring-2 focus:ring-brand-500">
                <option>Semua Poli</option>
                <option>Poli Umum</option>
                <option>Poli Gigi</option>
            </select>
            <select class="border border-slate-300 rounded-lg px-3 py-2 bg-white text-slate-700 focus:outline-none focus:ring-2 focus:ring-brand-500">
                <option>Semua Status</option>
                <option>Menunggu</option>
                <option>Diperiksa</option>
                <option>Selesai</option>
            </select>
        </div>
    </div>

    <!-- Tabel Data -->
    <div class="overflow-x-auto">
        <table class="min-w-full border-collapse border border-slate-300 text-xs">
            <thead class="bg-slate-100">
                <tr>
                    <th scope="col" class="border border-slate-300 px-2 py-1.5 text-left font-bold text-slate-700 uppercase">No. Antrean</th>
                    <th scope="col" class="border border-slate-300 px-2 py-1.5 text-left font-bold text-slate-700 uppercase">No. RM</th>
                    <th scope="col" class="border border-slate-300 px-2 py-1.5 text-left font-bold text-slate-700 uppercase">Nama Pasien</th>
                    <th scope="col" class="border border-slate-300 px-2 py-1.5 text-left font-bold text-slate-700 uppercase">Tujuan</th>
                    <th scope="col" class="border border-slate-300 px-2 py-1.5 text-left font-bold text-slate-700 uppercase">Penjamin</th>
                    <th scope="col" class="border border-slate-300 px-2 py-1.5 text-left font-bold text-slate-700 uppercase">Sumber</th>
                    <th scope="col" class="border border-slate-300 px-2 py-1.5 text-left font-bold text-slate-700 uppercase">Status</th>
                    <th scope="col" class="border border-slate-300 px-2 py-1.5 text-center font-bold text-slate-700 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @forelse($antrean as $item)
                <tr class="hover:bg-brand-50 transition-colors cursor-default {{ $item->status == 'Selesai' ? 'bg-slate-50 text-slate-500' : '' }}">
                    <td class="border border-slate-300 px-2 py-1 whitespace-nowrap font-mono {{ $item->status == 'Selesai' ? 'text-slate-500' : 'text-slate-900' }}">
                        {{ $item->no_antrean }}
                    </td>
                    <td class="border border-slate-300 px-2 py-1 whitespace-nowrap {{ $item->status == 'Selesai' ? 'text-slate-500' : 'text-slate-700' }}">
                        {{ $item->pasien->no_rm }}
                    </td>
                    <td class="border border-slate-300 px-2 py-1 whitespace-nowrap font-medium {{ $item->status == 'Selesai' ? 'text-slate-500' : 'text-slate-900' }}">
                        {{ $item->pasien->nama }}
                    </td>
                    <td class="border border-slate-300 px-2 py-1 whitespace-nowrap {{ $item->status == 'Selesai' ? 'text-slate-500' : 'text-slate-700' }}">
                        {{ $item->poliklinik->nama_poli }}
                    </td>
                    <td class="border border-slate-300 px-2 py-1 whitespace-nowrap {{ $item->status == 'Selesai' ? 'text-slate-500' : 'text-slate-700' }}">
                        {{ $item->jenis_pasien }}
                    </td>
                    <td class="border border-slate-300 px-2 py-1 whitespace-nowrap {{ $item->status == 'Selesai' ? 'text-slate-500' : 'text-slate-700' }}">
                        @if($item->sumber_daftar == 'Mobile JKN')
                            <span class="px-1.5 py-0.5 rounded text-[10px] font-semibold bg-green-100 text-green-700"><i class="fa-solid fa-mobile-screen mr-1"></i>JKN</span>
                        @else
                            <span class="px-1.5 py-0.5 rounded text-[10px] font-semibold bg-slate-100 text-slate-700">On-Site</span>
                        @endif
                    </td>
                    <td class="border border-slate-300 px-2 py-1 whitespace-nowrap {{ $item->status == 'Selesai' ? 'text-slate-500' : 'text-slate-700' }}">
                        @if($item->status == 'Menunggu')
                            <span class="text-orange-600 font-medium"><i class="fa-regular fa-clock mr-1"></i>{{ $item->status }}</span>
                        @elseif($item->status == 'Diperiksa')
                            <span class="text-blue-600 font-medium"><i class="fa-solid fa-user-doctor mr-1"></i>{{ $item->status }}</span>
                        @else
                            <span class="text-slate-500 font-medium">{{ $item->status }}</span>
                        @endif
                    </td>
                    <td class="border border-slate-300 px-2 py-1 whitespace-nowrap text-center">
                        @if($item->status == 'Menunggu')
                        <button class="text-brand-600 hover:text-brand-900 font-medium"><i class="fa-solid fa-arrow-right mr-1"></i>Proses</button>
                        @else
                        <button class="text-slate-500 hover:text-slate-700 font-medium"><i class="fa-solid fa-eye mr-1"></i>Detail</button>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-4 py-8 text-center text-slate-500 border border-slate-300">
                        <i class="fa-solid fa-clipboard-list text-3xl mb-3 text-slate-300 block"></i>
                        Belum ada antrean pendaftaran hari ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
