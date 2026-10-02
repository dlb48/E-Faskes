@extends('layouts.app')

@section('title', 'Data Master perawat')

@section('content')
<div class="flex justify-between items-center mb-4">
    <div class="flex items-center gap-3">
        <h1 class="text-2xl font-bold text-slate-900">Data Master perawat</h1>
        <span class="bg-brand-100 text-brand-700 py-1 px-3 rounded-full text-xs font-bold border border-brand-200">
            {{ $perawats->count() }} perawat
        </span>
    </div>
</div>

<!-- Form Pembungkus untuk Hapus Data -->
<form id="actionForm" method="POST" action="" novalidate>
    @csrf
    <input type="hidden" name="_method" id="formMethod" value="">

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden mb-2">
        <div class="overflow-auto max-h-[calc(100vh-250px)] relative">
            <table class="min-w-full border-collapse border border-slate-300 text-sm">
                <thead class="bg-slate-200 sticky top-0 z-10 shadow-sm">
                    <tr>
                        <th scope="col" class="border border-slate-300 px-3 py-2 text-center w-10">Pilih</th>
                        <th scope="col" class="border border-slate-300 px-3 py-2 text-left font-bold text-slate-700 uppercase">Kode perawat</th>
                        <th scope="col" class="border border-slate-300 px-3 py-2 text-left font-bold text-slate-700 uppercase">Nama perawat (Pegawai)</th>
                        <th scope="col" class="border border-slate-300 px-3 py-2 text-left font-bold text-slate-700 uppercase">No. STR</th>
                        <th scope="col" class="border border-slate-300 px-3 py-2 text-left font-bold text-slate-700 uppercase">Masa Berlaku STR</th>
                        <th scope="col" class="border border-slate-300 px-3 py-2 text-left font-bold text-slate-700 uppercase">Poliklinik / Spesialisasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    @forelse($perawats as $d)
                    <tr class="hover:bg-slate-50 transition-colors cursor-pointer" onclick="document.getElementById('radio_{{ $d->id_perawat }}').click()">
                        <td class="border border-slate-300 px-3 py-2 text-center">
                            <input type="radio" name="selected_d" id="radio_{{ $d->id_perawat }}" value="{{ $d->id_perawat }}" 
                                   class="w-4 h-4 text-brand-600 border-slate-300 focus:ring-brand-500 cursor-pointer"
                                   onclick="enableButtons('{{ $d->id_perawat }}', '{{ $d->pegawai->nama_lengkap }}'); event.stopPropagation();">
                        </td>
                        <td class="border border-slate-300 px-3 py-2 font-medium text-slate-900">{{ $d->id_perawat }}</td>
                        <td class="border border-slate-300 px-3 py-2 font-semibold text-brand-700">{{ $d->pegawai->nama_lengkap }}</td>
                        <td class="border border-slate-300 px-3 py-2 text-slate-700">{{ $d->no_str }}</td>
                        <td class="border border-slate-300 px-3 py-2 text-slate-700">{{ \Carbon\Carbon::parse($d->masa_berlaku_str)->format('d M Y') }}</td>
                        <td class="border border-slate-300 px-3 py-2 font-medium text-slate-800">{{ $d->poliklinik ? $d->poliklinik->nama_poli : '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-slate-500 border border-slate-300">
                            <i class="fa-solid fa-user-doctor text-4xl mb-3 text-slate-300 block"></i>
                            Belum ada data perawat yang diregistrasi dari pegawai.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Button Bar Bawah -->
    <div class="fixed bottom-0 left-0 w-full bg-white border-t border-slate-200 z-50 shadow-[0_-10px_15px_-3px_rgba(0,0,0,0.05)] transition-all" id="buttonBar">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex flex-col md:flex-row md:items-center justify-between gap-4">
            
            <div class="flex flex-col sm:flex-row sm:items-center gap-4 w-full md:w-auto">
                <div class="relative w-full sm:w-72">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fa-solid fa-search text-slate-400 text-sm"></i>
                    </div>
                    <input type="text" id="searchInput" onkeyup="filterTable()" placeholder="Cari perawat..." class="pl-9 pr-4 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 w-full transition-all bg-slate-50">
                </div>
                
                <div class="text-xs text-slate-500 hidden lg:flex items-center">
                    <i class="fa-solid fa-circle-info mr-1.5 text-brand-500"></i>
                    <span id="selectionText">Pilih data untuk diubah/dihapus.</span>
                </div>
            </div>
            
            <div class="flex items-center gap-2 overflow-x-auto shrink-0 pb-1 md:pb-0">
                <a href="{{ route('perawat.create') }}" class="whitespace-nowrap bg-brand-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-brand-700 transition-colors shadow-sm flex items-center">
                    <i class="fa-solid fa-plus mr-1.5"></i> Tambah perawat
                </a>
                
                <div class="h-6 w-px bg-slate-300 mx-1 hidden sm:block"></div>
                
                <button type="button" id="btnUbah" disabled onclick="doEdit()" class="whitespace-nowrap disabled:bg-slate-100 disabled:text-slate-400 disabled:border-slate-200 bg-amber-500 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-amber-600 transition-colors shadow-sm flex items-center disabled:cursor-not-allowed">
                    <i class="fa-solid fa-pen-to-square mr-1.5"></i> Ubah
                </button>
                
                <button type="button" id="btnHapus" disabled onclick="doDelete()" class="whitespace-nowrap disabled:bg-slate-100 disabled:text-slate-400 disabled:border-slate-200 bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-700 transition-colors shadow-sm flex items-center disabled:cursor-not-allowed">
                    <i class="fa-solid fa-trash-can mr-1.5"></i> Hapus
                </button>
            </div>
            
        </div>
    </div>
</form>

<script>
    let selectedId = null;

    function filterTable() {
        const input = document.getElementById("searchInput");
        const filter = input.value.toLowerCase();
        const tbody = document.querySelector("tbody");
        const rows = tbody.querySelectorAll("tr");

        rows.forEach(row => {
            if (row.cells.length === 1) return;
            const textContent = row.textContent.toLowerCase();
            if (textContent.includes(filter)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    }

    function enableButtons(id, name) {
        selectedId = id;
        document.getElementById('btnUbah').disabled = false;
        document.getElementById('btnHapus').disabled = false;
        
        document.getElementById('selectionText').innerHTML = `Terpilih: <strong>${name}</strong>`;
        
        document.querySelectorAll('tr').forEach(tr => tr.classList.remove('bg-blue-50'));
        const selectedRadio = document.getElementById('radio_' + id);
        if (selectedRadio) {
            selectedRadio.closest('tr').classList.add('bg-blue-50');
        }
    }

    function doEdit() {
        if (selectedId) {
            window.location.href = `/perawat/${selectedId}/edit`;
        }
    }

    function doDelete() {
        if (!selectedId) return;
        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: 'Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById('actionForm');
                form.action = `/perawat/${selectedId}`;
                document.getElementById('formMethod').value = 'DELETE';
                form.submit();
            }
        });
    }

</script>
@endsection
