
@extends('layouts.app')

@section('title', 'Rawat Jalan')

@section('content')
<div class="flex justify-between items-center mb-4">
    <div class="flex items-center gap-3">
        <h1 class="text-2xl font-bold text-slate-900">Rawat Jalan</h1>
        <span class="bg-brand-100 text-brand-700 py-1 px-3 rounded-full text-xs font-bold border border-brand-200">
            {{ $antrean->count() }} Total
        </span>
    </div>
    <div>
        <p class="text-sm text-slate-500 font-medium">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
    </div>
</div>

<form id="actionForm" method="POST" action="" novalidate class="pb-24">
    @csrf
    <input type="hidden" name="_method" id="formMethod" value="">

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden mb-2">
        <div class="overflow-auto max-h-[calc(100vh-250px)] relative">
            <table class="min-w-full border-collapse border border-slate-300 text-xs" id="dataTable">
                <thead class="bg-slate-200 sticky top-0 z-10 shadow-sm">
                    <tr>
                        <th scope="col" class="border border-slate-300 px-3 py-2 text-center w-10">
                            <input type="checkbox" id="selectAll" class="w-4 h-4 text-brand-600 border-slate-300 focus:ring-brand-500 rounded cursor-pointer" onclick="toggleAll(this)">
                        </th>
                        <th scope="col" class="border border-slate-300 px-3 py-2 text-left font-bold text-slate-700 uppercase">No. Antrean</th>
                        <th scope="col" class="border border-slate-300 px-3 py-2 text-left font-bold text-slate-700 uppercase">No. RM</th>
                        <th scope="col" class="border border-slate-300 px-3 py-2 text-left font-bold text-slate-700 uppercase">Nama Pasien</th>
                        <th scope="col" class="border border-slate-300 px-3 py-2 text-left font-bold text-slate-700 uppercase">Tujuan</th>
                        <th scope="col" class="border border-slate-300 px-3 py-2 text-left font-bold text-slate-700 uppercase">Penjamin</th>
                        <th scope="col" class="border border-slate-300 px-3 py-2 text-left font-bold text-slate-700 uppercase">Sumber</th>
                        <th scope="col" class="border border-slate-300 px-3 py-2 text-left font-bold text-slate-700 uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    @forelse($antrean as $item)
                    <tr class="hover:bg-slate-50 transition-colors cursor-pointer {{ $item->status == 'Selesai' ? 'bg-slate-50' : '' }}" onclick="document.getElementById('check_{{ $item->id }}').click()">
                        <td class="border border-slate-300 px-3 py-2 text-center">
                            <input type="checkbox" name="selected_ids[]" id="check_{{ $item->id }}" value="{{ $item->id }}" 
                                   class="w-4 h-4 text-brand-600 border-slate-300 focus:ring-brand-500 rounded cursor-pointer row-checkbox"
                                   onclick="updateSelection(); event.stopPropagation();">
                        </td>
                        <td class="border border-slate-300 px-3 py-2 font-mono {{ $item->status == 'Selesai' ? 'text-slate-500' : 'text-slate-900 font-bold' }}">
                            {{ $item->no_antrean }}
                        </td>
                        <td class="border border-slate-300 px-3 py-2 {{ $item->status == 'Selesai' ? 'text-slate-500' : 'text-slate-700' }}">
                            {{ $item->pasien->no_rm }}
                        </td>
                        <td class="border border-slate-300 px-3 py-2 font-medium {{ $item->status == 'Selesai' ? 'text-slate-500' : 'text-slate-900' }}">
                            {{ $item->pasien->nama }}
                        </td>
                        <td class="border border-slate-300 px-3 py-2 poli-col {{ $item->status == 'Selesai' ? 'text-slate-500' : 'text-slate-700' }}">
                            {{ $item->poliklinik->nama_poli }}
                        </td>
                        <td class="border border-slate-300 px-3 py-2 {{ $item->status == 'Selesai' ? 'text-slate-500' : 'text-slate-700' }}">
                            {{ $item->penjamin->nama_penjamin ?? '-' }}
                        </td>
                        <td class="border border-slate-300 px-3 py-2 {{ $item->status == 'Selesai' ? 'text-slate-500' : 'text-slate-700' }}">
                            @if($item->sumber_daftar == 'Mobile JKN')
                                <span class="px-1.5 py-0.5 rounded text-[10px] font-semibold bg-green-100 text-green-700"><i class="fa-solid fa-mobile-screen mr-1"></i>JKN</span>
                            @else
                                <span class="px-1.5 py-0.5 rounded text-[10px] font-semibold bg-slate-100 text-slate-700">On-Site</span>
                            @endif
                        </td>
                        <td class="border border-slate-300 px-3 py-2 status-col {{ $item->status == 'Selesai' ? 'text-slate-500' : 'text-slate-700' }}">
                            @if($item->status == 'Menunggu')
                                <span class="text-orange-600 font-bold"><i class="fa-regular fa-clock mr-1"></i>{{ $item->status }}</span>
                            @elseif($item->status == 'Diperiksa')
                                <span class="text-blue-600 font-bold"><i class="fa-solid fa-user-doctor mr-1"></i>{{ $item->status }}</span>
                            @else
                                <span class="text-slate-500 font-medium">{{ $item->status }}</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="border border-slate-300 px-4 py-12 text-center text-slate-500">
                            <i class="fa-solid fa-clipboard-list text-4xl mb-3 text-slate-300 block"></i>
                            <span class="font-medium">Belum ada pasien rawat jalan hari ini.</span>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Button Bar Bawah (Fixed di Bawah Layar) -->
    <div class="fixed bottom-0 left-0 w-full bg-white border-t border-slate-200 z-50 shadow-[0_-10px_15px_-3px_rgba(0,0,0,0.05)] transition-all" id="buttonBar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex flex-col xl:flex-row xl:items-center justify-between gap-4">
            
            <div class="flex flex-col md:flex-row md:items-center gap-3 w-full xl:w-auto">
                
                <div class="relative w-full md:w-64">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fa-solid fa-search text-slate-400 text-sm"></i>
                    </div>
                    <input type="text" id="searchInput" onkeyup="filterTable()" placeholder="Cari nama atau RM..." class="pl-9 pr-4 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 w-full bg-slate-50 transition-all">
                </div>

                <div class="flex gap-2">
                    <select id="poliFilter" onchange="filterTable()" class="border border-slate-300 rounded-lg px-3 py-2 bg-slate-50 text-slate-700 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
                        <option value="">Semua Poli</option>
                        @php
                            $polis = \App\Models\Poliklinik::where('status_aktif', true)->orderBy('nama_poli')->get();
                        @endphp
                        @foreach($polis as $poli)
                            <option value="{{ $poli->nama_poli }}">{{ $poli->nama_poli }}</option>
                        @endforeach
                    </select>

                    <select id="statusFilter" onchange="filterTable()" class="border border-slate-300 rounded-lg px-3 py-2 bg-slate-50 text-slate-700 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500">
                        <option value="">Semua Status</option>
                        <option value="Menunggu">Menunggu</option>
                        <option value="Diperiksa">Diperiksa</option>
                        <option value="Selesai">Selesai</option>
                        <option value="Batal">Batal</option>
                    </select>
                </div>
                
                <div class="text-xs text-slate-500 hidden xl:flex items-center ml-2">
                    <i class="fa-solid fa-circle-info mr-1.5 text-brand-500"></i>
                    <span id="selectionText">Pilih data antrean.</span>
                </div>
            </div>
            
            <div class="flex items-center gap-2 overflow-x-auto shrink-0 pb-1 xl:pb-0">
                <button type="button" id="btnProses" disabled onclick="prosesSelected()" class="whitespace-nowrap disabled:bg-slate-100 disabled:text-slate-400 disabled:border-slate-200 bg-brand-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-brand-700 transition-colors shadow-sm flex items-center disabled:cursor-not-allowed">
                    <i class="fa-solid fa-stethoscope mr-1.5"></i> Proses Pemeriksaan
                </button>
            </div>
            
        </div>
    </div>
</form>

<script>
    function filterTable() {
        const keyword = document.getElementById("searchInput").value.toLowerCase();
        const poliFilter = document.getElementById("poliFilter").value.toLowerCase();
        const statusFilter = document.getElementById("statusFilter").value.toLowerCase();
        
        const tbody = document.querySelector("tbody");
        const rows = tbody.querySelectorAll("tr");

        rows.forEach(row => {
            if (row.cells.length === 1) return; // Empty row
            
            const textContent = row.textContent.toLowerCase();
            const poliCell = row.querySelector(".poli-col")?.textContent.toLowerCase() || "";
            const statusCell = row.querySelector(".status-col")?.textContent.toLowerCase() || "";

            const matchKeyword = textContent.includes(keyword);
            const matchPoli = poliFilter === "" || poliCell.includes(poliFilter);
            const matchStatus = statusFilter === "" || statusCell.includes(statusFilter);

            if (matchKeyword && matchPoli && matchStatus) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    }

    function toggleAll(source) {
        const checkboxes = document.querySelectorAll(".row-checkbox");
        checkboxes.forEach(cb => {
            // Hanya centang baris yang tidak disembunyikan oleh filter
            const row = cb.closest("tr");
            if (row.style.display !== "none") {
                cb.checked = source.checked;
            } else {
                cb.checked = false;
            }
        });
        updateSelection();
    }

    function updateSelection() {
        const checked = document.querySelectorAll(".row-checkbox:checked");
        const btnProses = document.getElementById("btnProses");
        const selectionText = document.getElementById("selectionText");

        if (checked.length > 0) {
            selectionText.innerHTML = `<span class="font-bold text-slate-800">${checked.length} data</span> dipilih.`;
            
            if (checked.length === 1) {
                btnProses.disabled = false;
            } else {
                btnProses.disabled = true;
            }
        } else {
            selectionText.innerHTML = "Pilih data pasien rawat jalan.";
            document.getElementById("selectAll").checked = false;
            
            btnProses.disabled = true;
        }
    }

    function prosesSelected() {
        const checked = document.querySelectorAll(".row-checkbox:checked");
        if (checked.length === 1) {
            const id = checked[0].value;
            window.location.href = `/rawat-jalan/${id}/assesmen`;
        }
    }
</script>
@endsection


