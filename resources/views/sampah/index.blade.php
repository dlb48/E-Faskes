@extends('layouts.app')

@section('title', 'Tempat Sampah')

@section('content')
<div class="max-w-7xl mx-auto pb-20">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('home') }}" class="text-slate-400 hover:text-slate-600 transition-colors">
            <i class="fa-solid fa-arrow-left text-xl"></i>
        </a>
        <h1 class="text-2xl font-bold text-slate-900">Tempat Sampah</h1>
    </div>

    <!-- Form Pembungkus untuk Restore/Force Delete -->
    <form id="actionForm" method="POST" action="" novalidate>
        @csrf
        <input type="hidden" name="_method" id="formMethod" value="">

        <!-- Data Pasien -->
        @if($data['pasien']->count() > 0)
        <div class="mb-8">
            <h2 class="text-lg font-bold text-slate-800 mb-3"><i class="fa-solid fa-users mr-2 text-slate-400"></i> Pasien ({{ $data['pasien']->count() }})</h2>
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <table class="min-w-full border-collapse border border-slate-300 text-sm">
                    <thead class="bg-slate-200 sticky top-0 z-10 shadow-sm">
                        <tr>
                            <th scope="col" class="border border-slate-300 px-3 py-2 text-center w-10"><input type="checkbox" class="w-4 h-4 text-brand-600 border-slate-300 focus:ring-brand-500 rounded cursor-pointer select-all-cb" onclick="toggleAll(this)"></th>
                            <th class="border border-slate-300 px-3 py-2 text-left font-bold text-slate-700 uppercase">NIK</th>
                            <th class="border border-slate-300 px-3 py-2 text-left font-bold text-slate-700 uppercase">Nama</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        @foreach($data['pasien'] as $d)
                        <tr class="hover:bg-slate-50 transition-colors cursor-pointer" onclick="document.getElementById('check_pasien_{{ $d->nik }}').click()">
                            <td class="border border-slate-300 px-3 py-2 text-center">
                                <input type="checkbox" name="selected_items[]" id="check_pasien_{{ $d->nik }}" value="pasien|{{ $d->nik }}" class="w-4 h-4 text-brand-600 border-slate-300 focus:ring-brand-500 rounded cursor-pointer row-checkbox" onclick="updateSelection(); event.stopPropagation();">
                            </td>
                            <td class="border border-slate-300 px-3 py-2 font-medium text-slate-900">{{ $d->nik }}</td>
                            <td class="border border-slate-300 px-3 py-2 text-slate-700">{{ $d->nama_pasien }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        <!-- Data Pegawai -->
        @if($data['pegawai']->count() > 0)
        <div class="mb-8">
            <h2 class="text-lg font-bold text-slate-800 mb-3"><i class="fa-solid fa-user-tie mr-2 text-slate-400"></i> Pegawai ({{ $data['pegawai']->count() }})</h2>
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <table class="min-w-full border-collapse border border-slate-300 text-sm">
                    <thead class="bg-slate-200 sticky top-0 z-10 shadow-sm">
                        <tr>
                            <th scope="col" class="border border-slate-300 px-3 py-2 text-center w-10"><input type="checkbox" class="w-4 h-4 text-brand-600 border-slate-300 focus:ring-brand-500 rounded cursor-pointer select-all-cb" onclick="toggleAll(this)"></th>
                            <th class="border border-slate-300 px-3 py-2 text-left font-bold text-slate-700 uppercase">NIP</th>
                            <th class="border border-slate-300 px-3 py-2 text-left font-bold text-slate-700 uppercase">Nama Lengkap</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        @foreach($data['pegawai'] as $d)
                        <tr class="hover:bg-slate-50 transition-colors cursor-pointer" onclick="document.getElementById('check_pegawai_{{ $d->nip }}').click()">
                            <td class="border border-slate-300 px-3 py-2 text-center">
                                <input type="checkbox" name="selected_items[]" id="check_pegawai_{{ $d->nip }}" value="pegawai|{{ $d->nip }}" class="w-4 h-4 text-brand-600 border-slate-300 focus:ring-brand-500 rounded cursor-pointer row-checkbox" onclick="updateSelection(); event.stopPropagation();">
                            </td>
                            <td class="border border-slate-300 px-3 py-2 font-medium text-slate-900">{{ $d->nip }}</td>
                            <td class="border border-slate-300 px-3 py-2 text-slate-700">{{ $d->nama_lengkap }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        <!-- Data Dokter -->
        @if($data['dokter']->count() > 0)
        <div class="mb-8">
            <h2 class="text-lg font-bold text-slate-800 mb-3"><i class="fa-solid fa-user-doctor mr-2 text-slate-400"></i> Dokter ({{ $data['dokter']->count() }})</h2>
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <table class="min-w-full border-collapse border border-slate-300 text-sm">
                    <thead class="bg-slate-200 sticky top-0 z-10 shadow-sm">
                        <tr>
                            <th scope="col" class="border border-slate-300 px-3 py-2 text-center w-10"><input type="checkbox" class="w-4 h-4 text-brand-600 border-slate-300 focus:ring-brand-500 rounded cursor-pointer select-all-cb" onclick="toggleAll(this)"></th>
                            <th class="border border-slate-300 px-3 py-2 text-left font-bold text-slate-700 uppercase">ID Dokter</th>
                            <th class="border border-slate-300 px-3 py-2 text-left font-bold text-slate-700 uppercase">Nama</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        @foreach($data['dokter'] as $d)
                        @php $name = $d->pegawai ? $d->pegawai->nama_lengkap : $d->nip; @endphp
                        <tr class="hover:bg-slate-50 transition-colors cursor-pointer" onclick="document.getElementById('check_dokter_{{ $d->id_dokter }}').click()">
                            <td class="border border-slate-300 px-3 py-2 text-center">
                                <input type="checkbox" name="selected_items[]" id="check_dokter_{{ $d->id_dokter }}" value="dokter|{{ $d->id_dokter }}" class="w-4 h-4 text-brand-600 border-slate-300 focus:ring-brand-500 rounded cursor-pointer row-checkbox" onclick="updateSelection(); event.stopPropagation();">
                            </td>
                            <td class="border border-slate-300 px-3 py-2 font-medium text-slate-900">{{ $d->id_dokter }}</td>
                            <td class="border border-slate-300 px-3 py-2 text-slate-700">{{ $name }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        <!-- Data Perawat -->
        @if($data['perawat']->count() > 0)
        <div class="mb-8">
            <h2 class="text-lg font-bold text-slate-800 mb-3"><i class="fa-solid fa-user-nurse mr-2 text-slate-400"></i> Perawat ({{ $data['perawat']->count() }})</h2>
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <table class="min-w-full border-collapse border border-slate-300 text-sm">
                    <thead class="bg-slate-200 sticky top-0 z-10 shadow-sm">
                        <tr>
                            <th scope="col" class="border border-slate-300 px-3 py-2 text-center w-10"><input type="checkbox" class="w-4 h-4 text-brand-600 border-slate-300 focus:ring-brand-500 rounded cursor-pointer select-all-cb" onclick="toggleAll(this)"></th>
                            <th class="border border-slate-300 px-3 py-2 text-left font-bold text-slate-700 uppercase">ID Perawat</th>
                            <th class="border border-slate-300 px-3 py-2 text-left font-bold text-slate-700 uppercase">Nama</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        @foreach($data['perawat'] as $d)
                        @php $name = $d->pegawai ? $d->pegawai->nama_lengkap : $d->nip; @endphp
                        <tr class="hover:bg-slate-50 transition-colors cursor-pointer" onclick="document.getElementById('check_perawat_{{ $d->id_perawat }}').click()">
                            <td class="border border-slate-300 px-3 py-2 text-center">
                                <input type="checkbox" name="selected_items[]" id="check_perawat_{{ $d->id_perawat }}" value="perawat|{{ $d->id_perawat }}" class="w-4 h-4 text-brand-600 border-slate-300 focus:ring-brand-500 rounded cursor-pointer row-checkbox" onclick="updateSelection(); event.stopPropagation();">
                            </td>
                            <td class="border border-slate-300 px-3 py-2 font-medium text-slate-900">{{ $d->id_perawat }}</td>
                            <td class="border border-slate-300 px-3 py-2 text-slate-700">{{ $name }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

                <!-- Data Penjamin -->
        @if($data['penjamin']->count() > 0)
        <div class="mb-8">
            <h2 class="text-lg font-bold text-slate-800 mb-3"><i class="fa-solid fa-hand-holding-dollar mr-2 text-slate-400"></i> Penjamin ({{ $data['penjamin']->count() }})</h2>
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <table class="min-w-full border-collapse border border-slate-300 text-sm">
                    <thead class="bg-slate-200 sticky top-0 z-10 shadow-sm">
                        <tr>
                            <th scope="col" class="border border-slate-300 px-3 py-2 text-center w-10"><input type="checkbox" class="w-4 h-4 text-brand-600 border-slate-300 focus:ring-brand-500 rounded cursor-pointer select-all-cb" onclick="toggleAll(this)"></th>
                            <th class="border border-slate-300 px-3 py-2 text-left font-bold text-slate-700 uppercase">ID Penjamin</th>
                            <th class="border border-slate-300 px-3 py-2 text-left font-bold text-slate-700 uppercase">Nama Penjamin</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        @foreach($data['penjamin'] as $d)
                        <tr class="hover:bg-slate-50 transition-colors cursor-pointer" onclick="document.getElementById('check_penjamin_{{ $d->id_penjamin }}').click()">
                            <td class="border border-slate-300 px-3 py-2 text-center">
                                <input type="checkbox" name="selected_items[]" id="check_penjamin_{{ $d->id_penjamin }}" value="penjamin|{{ $d->id_penjamin }}" class="w-4 h-4 text-brand-600 border-slate-300 focus:ring-brand-500 rounded cursor-pointer row-checkbox" onclick="updateSelection(); event.stopPropagation();">
                            </td>
                            <td class="border border-slate-300 px-3 py-2 font-medium text-slate-900">{{ $d->id_penjamin }}</td>
                            <td class="border border-slate-300 px-3 py-2 text-slate-700">{{ $d->nama_penjamin }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif


        <!-- Data Jabatan -->
        @if($data['jabatan']->count() > 0)
        <div class="mb-8">
            <h2 class="text-lg font-bold text-slate-800 mb-3"><i class="fa-solid fa-id-badge mr-2 text-slate-400"></i> Jabatan ({{ $data['jabatan']->count() }})</h2>
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <table class="min-w-full border-collapse border border-slate-300 text-sm">
                    <thead class="bg-slate-200 sticky top-0 z-10 shadow-sm">
                        <tr>
                            <th scope="col" class="border border-slate-300 px-3 py-2 text-center w-10"><input type="checkbox" class="w-4 h-4 text-brand-600 border-slate-300 focus:ring-brand-500 rounded cursor-pointer select-all-cb" onclick="toggleAll(this)"></th>
                            <th class="border border-slate-300 px-3 py-2 text-left font-bold text-slate-700 uppercase">ID Jabatan</th>
                            <th class="border border-slate-300 px-3 py-2 text-left font-bold text-slate-700 uppercase">Nama Jabatan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        @foreach($data['jabatan'] as $d)
                        <tr class="hover:bg-slate-50 transition-colors cursor-pointer" onclick="document.getElementById('check_jabatan_{{ $d->id_jabatan }}').click()">
                            <td class="border border-slate-300 px-3 py-2 text-center">
                                <input type="checkbox" name="selected_items[]" id="check_jabatan_{{ $d->id_jabatan }}" value="jabatan|{{ $d->id_jabatan }}" class="w-4 h-4 text-brand-600 border-slate-300 focus:ring-brand-500 rounded cursor-pointer row-checkbox" onclick="updateSelection(); event.stopPropagation();">
                            </td>
                            <td class="border border-slate-300 px-3 py-2 font-medium text-slate-900">{{ $d->id_jabatan }}</td>
                            <td class="border border-slate-300 px-3 py-2 text-slate-700">{{ $d->nama_jabatan }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        <!-- Data Departemen -->
        @if($data['departemen']->count() > 0)
        <div class="mb-8">
            <h2 class="text-lg font-bold text-slate-800 mb-3"><i class="fa-solid fa-building-user mr-2 text-slate-400"></i> Departemen ({{ $data['departemen']->count() }})</h2>
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <table class="min-w-full border-collapse border border-slate-300 text-sm">
                    <thead class="bg-slate-200 sticky top-0 z-10 shadow-sm">
                        <tr>
                            <th scope="col" class="border border-slate-300 px-3 py-2 text-center w-10"><input type="checkbox" class="w-4 h-4 text-brand-600 border-slate-300 focus:ring-brand-500 rounded cursor-pointer select-all-cb" onclick="toggleAll(this)"></th>
                            <th class="border border-slate-300 px-3 py-2 text-left font-bold text-slate-700 uppercase">ID Departemen</th>
                            <th class="border border-slate-300 px-3 py-2 text-left font-bold text-slate-700 uppercase">Nama Departemen</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        @foreach($data['departemen'] as $d)
                        <tr class="hover:bg-slate-50 transition-colors cursor-pointer" onclick="document.getElementById('check_departemen_{{ $d->id_departemen }}').click()">
                            <td class="border border-slate-300 px-3 py-2 text-center">
                                <input type="checkbox" name="selected_items[]" id="check_departemen_{{ $d->id_departemen }}" value="departemen|{{ $d->id_departemen }}" class="w-4 h-4 text-brand-600 border-slate-300 focus:ring-brand-500 rounded cursor-pointer row-checkbox" onclick="updateSelection(); event.stopPropagation();">
                            </td>
                            <td class="border border-slate-300 px-3 py-2 font-medium text-slate-900">{{ $d->id_departemen }}</td>
                            <td class="border border-slate-300 px-3 py-2 text-slate-700">{{ $d->nama_departemen }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        <!-- Data Poliklinik -->
        @if($data['poliklinik']->count() > 0)
        <div class="mb-8">
            <h2 class="text-lg font-bold text-slate-800 mb-3"><i class="fa-solid fa-house-medical mr-2 text-slate-400"></i> Poliklinik ({{ $data['poliklinik']->count() }})</h2>
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                <table class="min-w-full border-collapse border border-slate-300 text-sm">
                    <thead class="bg-slate-200 sticky top-0 z-10 shadow-sm">
                        <tr>
                            <th scope="col" class="border border-slate-300 px-3 py-2 text-center w-10"><input type="checkbox" class="w-4 h-4 text-brand-600 border-slate-300 focus:ring-brand-500 rounded cursor-pointer select-all-cb" onclick="toggleAll(this)"></th>
                            <th class="border border-slate-300 px-3 py-2 text-left font-bold text-slate-700 uppercase">Kode Poli</th>
                            <th class="border border-slate-300 px-3 py-2 text-left font-bold text-slate-700 uppercase">Nama Poli</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        @foreach($data['poliklinik'] as $d)
                        <tr class="hover:bg-slate-50 transition-colors cursor-pointer" onclick="document.getElementById('check_poliklinik_{{ $d->kode_poli }}').click()">
                            <td class="border border-slate-300 px-3 py-2 text-center">
                                <input type="checkbox" name="selected_items[]" id="check_poliklinik_{{ $d->kode_poli }}" value="poliklinik|{{ $d->kode_poli }}" class="w-4 h-4 text-brand-600 border-slate-300 focus:ring-brand-500 rounded cursor-pointer row-checkbox" onclick="updateSelection(); event.stopPropagation();">
                            </td>
                            <td class="border border-slate-300 px-3 py-2 font-medium text-slate-900">{{ $d->kode_poli }}</td>
                            <td class="border border-slate-300 px-3 py-2 text-slate-700">{{ $d->nama_poli }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        <!-- Button Bar Bawah (Action Bar) -->
        <div class="fixed bottom-0 left-0 w-full bg-white border-t border-slate-200 z-50 shadow-[0_-10px_15px_-3px_rgba(0,0,0,0.05)] transition-all">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex flex-col md:flex-row md:items-center justify-between gap-4">
                
                <div class="text-xs text-slate-500 flex items-center">
                    <i class="fa-solid fa-circle-info mr-1.5 text-brand-500"></i>
                    <span id="selectionText">Pilih satu data untuk dipulihkan atau dihapus permanen.</span>
                </div>
                
                <div class="flex items-center gap-2">
                    <button type="button" id="btnPulihkan" disabled onclick="doRestore()" class="disabled:bg-slate-100 disabled:text-slate-400 disabled:border-slate-200 bg-brand-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-brand-700 transition-colors shadow-sm flex items-center disabled:cursor-not-allowed">
                        <i class="fa-solid fa-rotate-left mr-1.5"></i> Pulihkan
                    </button>
                    
                    <button type="button" id="btnHapus" disabled onclick="doForceDelete()" class="disabled:bg-slate-100 disabled:text-slate-400 disabled:border-slate-200 bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-700 transition-colors shadow-sm flex items-center disabled:cursor-not-allowed">
                        <i class="fa-solid fa-trash-can mr-1.5"></i> Hapus Permanen
                    </button>
                </div>
                
            </div>
        </div>
    </form>

    @if($data['pasien']->count() == 0 && $data['pegawai']->count() == 0 && $data['dokter']->count() == 0 && $data['perawat']->count() == 0 && $data['poliklinik']->count() == 0 && $data['departemen']->count() == 0 && $data['jabatan']->count() == 0)
    <div class="text-center py-20 bg-white rounded-xl shadow-sm border border-slate-200">
        <i class="fa-solid fa-trash-can-arrow-up text-5xl text-slate-300 mb-4 block"></i>
        <h3 class="text-xl font-bold text-slate-700">Tempat Sampah Kosong</h3>
        <p class="text-slate-500 mt-2">Tidak ada data yang dihapus saat ini.</p>
    </div>
    @endif
</div>

<script>
    function toggleAll(source) {
        const table = source.closest('table');
        const checkboxes = table.querySelectorAll('.row-checkbox');
        checkboxes.forEach(cb => {
            cb.checked = source.checked;
        });
        updateSelection();
    }

    function updateSelection() {
        const checkboxes = document.querySelectorAll('.row-checkbox:checked');
        const selectedCount = checkboxes.length;
        
        document.querySelectorAll('tr').forEach(tr => tr.classList.remove('bg-blue-50'));
        checkboxes.forEach(cb => cb.closest('tr').classList.add('bg-blue-50'));

        const btnPulihkan = document.getElementById('btnPulihkan');
        const btnHapus = document.getElementById('btnHapus');
        const selectionText = document.getElementById('selectionText');

        if (selectedCount === 0) {
            btnPulihkan.disabled = true;
            btnHapus.disabled = true;
            selectionText.innerHTML = 'Pilih satu atau lebih data untuk dipulihkan atau dihapus permanen.';
        } else {
            btnPulihkan.disabled = false;
            btnHapus.disabled = false;
            selectionText.innerHTML = `<strong>${selectedCount}</strong> data terpilih.`;
        }
    }

    function doRestore() {
        const selectedCount = document.querySelectorAll('.row-checkbox:checked').length;
        if (selectedCount === 0) return;
        
        const form = document.getElementById('actionForm');
        form.action = `{{ route('sampah.restoreBulk') }}`;
        document.getElementById('formMethod').value = 'POST';
        form.submit();
    }

    function doForceDelete() {
        const selectedCount = document.querySelectorAll('.row-checkbox:checked').length;
        if (selectedCount === 0) return;
        
        Swal.fire({
            title: 'Hapus Permanen?',
            text: `Apakah Anda yakin ingin menghapus permanen ${selectedCount} data? Data ini tidak dapat dikembalikan!`,
            icon: 'error',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus Permanen!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById('actionForm');
                form.action = `{{ route('sampah.forceDeleteBulk') }}`;
                document.getElementById('formMethod').value = 'DELETE';
                form.submit();
            }
        });
    }
</script>
@endsection





