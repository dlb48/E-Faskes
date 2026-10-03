
<div class="flex-1 overflow-y-auto p-0 bg-white" id="pasienListItems">
    @forelse($pasiens as $pasien)
    <label class="flex items-center p-2 border-b border-slate-100 hover:bg-slate-50 cursor-pointer transition-colors" id="label_pasien_{{ $pasien->nik }}">
        <div class="flex-shrink-0 mr-2 ml-1">
            <input type="radio" name="nik_pasien" value="{{ $pasien->nik }}" class="w-3.5 h-3.5 text-brand-600 focus:ring-brand-500 cursor-pointer" required {{ count($pasiens) == 1 ? 'checked' : '' }}>
        </div>
        <div class="flex-1 min-w-0">
            <div class="flex items-center justify-between">
                <span class="block text-[13px] font-bold text-slate-900 truncate pr-2">{{ $pasien->nama }}</span>
                <span class="block text-[10px] font-mono font-bold text-brand-700 bg-brand-50 border border-brand-200 px-1 py-0.5 rounded">{{ $pasien->no_rm }}</span>
            </div>
            <div class="text-[10px] text-slate-500 mt-0.5">NIK: {{ $pasien->nik }} | {{ $pasien->penjamin->nama_penjamin ?? '-' }}{{ $pasien->no_kartu_bpjs ? ' (' . $pasien->no_kartu_bpjs . ')' : '' }}</div>
        </div>
    </label>
    @empty
    <div class="p-8 text-center text-slate-500" id="emptyPasienState">
        <i class="fa-solid fa-user-xmark text-2xl mb-2 text-slate-300 block"></i>
        <span class="text-xs">Data pasien tidak ditemukan.</span>
    </div>
    @endforelse
</div>

<div class="px-4 py-3 border-t border-slate-100 bg-slate-50 flex items-center justify-between gap-3 h-[60px]">
    <div class="text-[11px] text-slate-500">
        <span id="pasienCountText">Menampilkan <strong class="text-slate-700">{{ $pasiens->count() }}</strong> dari <strong class="text-slate-700">{{ $pasiens->total() }}</strong></span>
    </div>
    
    @if($pasiens->hasPages())
    @php $pasiens->appends(['search' => $search]); @endphp
    <div class="pasien-pagination flex gap-1.5">
        @if ($pasiens->onFirstPage())
            <span class="inline-flex items-center justify-center w-6 h-6 text-[10px] font-bold text-slate-300 bg-white border border-slate-200 rounded cursor-not-allowed">
                <i class="fa-solid fa-chevron-left"></i>
            </span>
        @else
            <a href="{{ $pasiens->previousPageUrl() }}" class="inline-flex items-center justify-center w-6 h-6 text-[10px] font-bold text-slate-600 bg-white border border-slate-300 rounded hover:bg-slate-100 transition-colors shadow-sm">
                <i class="fa-solid fa-chevron-left"></i>
            </a>
        @endif

        @if ($pasiens->hasMorePages())
            <a href="{{ $pasiens->nextPageUrl() }}" class="inline-flex items-center justify-center w-6 h-6 text-[10px] font-bold text-slate-600 bg-white border border-slate-300 rounded hover:bg-slate-100 transition-colors shadow-sm">
                <i class="fa-solid fa-chevron-right"></i>
            </a>
        @else
            <span class="inline-flex items-center justify-center w-6 h-6 text-[10px] font-bold text-slate-300 bg-white border border-slate-200 rounded cursor-not-allowed">
                <i class="fa-solid fa-chevron-right"></i>
            </span>
        @endif
    </div>
    @endif
</div>


