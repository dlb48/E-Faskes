@extends('layouts.app')

@section('title', 'Asesmen Keperawatan: ' . $pendaftaran->pasien->nama)

@section('content')
<!-- FULL SCREEN LAYOUT CONTAINER -->
<div class="flex h-[calc(100vh-4rem)] -mx-6 -mt-6 -mb-4 bg-slate-50 text-sm border-t border-slate-200">
    
    <!-- SIDEBAR KIRI -->
    <div class="w-64 bg-white border-r border-slate-200 flex flex-col shrink-0 z-10">
        <!-- Info Pasien (Data Pasien) -->
        <div class="p-5 border-b border-slate-200 bg-white">
            <h3 class="font-semibold text-slate-900 text-base leading-tight">{{ $pendaftaran->pasien->nama }}</h3>
            <p class="text-xs text-slate-500 mt-2">RM: <span class="font-bold text-slate-700">{{ $pendaftaran->pasien->no_rm ?? '-' }}</span></p>
            <p class="text-xs text-slate-500 mt-1">{{ \Carbon\Carbon::parse($pendaftaran->pasien->tanggal_lahir)->age }} Thn &bull; {{ $pendaftaran->pasien->jenis_kelamin }}</p>
            <div class="mt-3">
                 <span class="px-2.5 py-1 {{ $pendaftaran->penjamin && str_contains(strtolower($pendaftaran->penjamin->nama_penjamin), 'bpjs') ? 'bg-sky-100 text-sky-900' : 'bg-slate-100 text-slate-700' }} text-[11px] font-bold rounded-md uppercase tracking-wide">
                    {{ $pendaftaran->penjamin ? $pendaftaran->penjamin->nama_penjamin : 'UMUM' }}
                </span>
            </div>
        </div>

        <!-- Daftar Menu -->
        <nav class="flex-1 p-3 space-y-1 overflow-y-auto">
            <a href="{{ route('rawat_jalan.assesmen', $pendaftaran->id) }}" class="flex items-center px-4 py-3 bg-brand-50 text-brand-700 border border-brand-100 font-bold text-[11px] rounded-lg shadow-sm leading-tight">
                <i class="fa-solid fa-user-nurse w-5 text-center mr-2"></i> 1. Asesmen Awal<br>Keperawatan
            </a>
            <a href="{{ route('rawat_jalan.anamnesa', $pendaftaran->id) }}" class="flex items-center px-4 py-3 text-slate-600 hover:bg-slate-50 border border-transparent font-bold text-[11px] rounded-lg transition-colors leading-tight">
                <i class="fa-solid fa-user-doctor w-5 text-center mr-2 text-slate-400"></i> 2. Anamnesa &<br>Diagnosa
            </a>
            <a href="#" class="flex items-center px-4 py-3 text-slate-600 hover:bg-slate-50 border border-transparent font-bold text-[11px] rounded-lg transition-colors leading-tight">
                <i class="fa-solid fa-syringe w-5 text-center mr-2 text-slate-400"></i> 3. Tindakan
            </a>
            <a href="#" class="flex items-center px-4 py-3 text-slate-600 hover:bg-slate-50 border border-transparent font-bold text-[11px] rounded-lg transition-colors leading-tight">
                <i class="fa-solid fa-microscope w-5 text-center mr-2 text-slate-400"></i> 4. Pemeriksaan<br>Penunjang
            </a>
            <a href="#" class="flex items-center px-4 py-3 text-slate-600 hover:bg-slate-50 border border-transparent font-bold text-[11px] rounded-lg transition-colors leading-tight">
                <i class="fa-solid fa-pills w-5 text-center mr-2 text-slate-400"></i> 5. Resep Dokter
            </a>
            <a href="#" class="flex items-center px-4 py-3 text-slate-600 hover:bg-slate-50 border border-transparent font-bold text-[11px] rounded-lg transition-colors leading-tight">
                <i class="fa-solid fa-notes-medical w-5 text-center mr-2 text-slate-400"></i> 6. Catatan Dokter
            </a>
            <a href="#" class="flex items-center px-4 py-3 text-slate-600 hover:bg-slate-50 border border-transparent font-bold text-[11px] rounded-lg transition-colors leading-tight">
                <i class="fa-solid fa-clock-rotate-left w-5 text-center mr-2 text-slate-400"></i> 7. Riwayat Pasien
            </a>
        </nav>
        
        <!-- Tombol Kembali -->
        <div class="p-4 border-t border-slate-200 bg-slate-50">
            <a href="{{ route('rawat_jalan.index') }}" class="w-full flex items-center justify-center px-4 py-2 text-xs font-bold text-slate-600 bg-white border border-slate-300 hover:bg-slate-100 rounded-lg transition-colors shadow-sm">
                <i class="fa-solid fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>
    </div>

    <!-- KONTEN UTAMA KANAN -->
    <div class="flex-1 flex flex-col relative min-w-0">
        
        <!-- JUDUL HEADER -->
        <div class="px-6 py-4 bg-white border-b border-slate-200 shrink-0 z-10">
            <h1 class="text-xl font-bold text-slate-900 leading-tight">Asesmen Awal Keperawatan</h1>
            <p class="text-xs text-slate-500 mt-1">Pemeriksaan fisik dasar oleh perawat sebelum masuk poli.</p>
        </div>

        <!-- AREA SCROLL KONTEN TENGAH -->
        <div class="flex-1 overflow-y-auto p-6">
            
            <!-- TABEL RIWAYAT ASESMEN TERSIMPAN -->
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm flex flex-col mb-6">
                <div class="px-5 py-3 border-b border-slate-100 bg-slate-50 flex justify-between items-center rounded-t-xl">
                    <h2 class="font-bold text-slate-700 text-xs flex items-center">
                        <i class="fa-solid fa-clock-rotate-left mr-2 text-slate-400"></i> Data Asesmen Keperawatan Tersimpan
                    </h2>
                    <span class="text-[10px] text-slate-500 font-medium bg-slate-200 px-2 py-0.5 rounded-full">Total: {{ $riwayatAssesmen->count() }} Data</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full border-collapse border border-slate-300 text-xs" id="dataTable">
                        <thead class="bg-slate-200 sticky top-0 z-10 shadow-sm">
                            <tr>
                                <th scope="col" class="border border-slate-300 px-3 py-2 text-left font-bold text-slate-700 uppercase w-10 text-center">No</th>
                                <th scope="col" class="border border-slate-300 px-3 py-2 text-left font-bold text-slate-700 uppercase">Tanggal / Waktu</th>
                                <th scope="col" class="border border-slate-300 px-3 py-2 text-left font-bold text-slate-700 uppercase">Poli Tujuan</th>
                                <th scope="col" class="border border-slate-300 px-3 py-2 text-center font-bold text-slate-700 uppercase">Tensi</th>
                                <th scope="col" class="border border-slate-300 px-3 py-2 text-center font-bold text-slate-700 uppercase">Nadi</th>
                                <th scope="col" class="border border-slate-300 px-3 py-2 text-center font-bold text-slate-700 uppercase">Suhu</th>
                                <th scope="col" class="border border-slate-300 px-3 py-2 text-center font-bold text-slate-700 uppercase">Napas</th>
                                <th scope="col" class="border border-slate-300 px-3 py-2 text-center font-bold text-slate-700 uppercase">BB</th>
                                <th scope="col" class="border border-slate-300 px-3 py-2 text-center font-bold text-slate-700 uppercase">TB</th>
                                <th scope="col" class="border border-slate-300 px-3 py-2 text-center font-bold text-slate-700 uppercase">LP</th>
                                <th scope="col" class="border border-slate-300 px-3 py-2 text-center font-bold text-slate-700 uppercase">Nyeri</th>
                                <th scope="col" class="border border-slate-300 px-3 py-2 text-center font-bold text-slate-700 uppercase">Jatuh</th>
                                <th scope="col" class="border border-slate-300 px-3 py-2 text-left font-bold text-slate-700 uppercase">Alergi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200 bg-white">
                            @forelse($riwayatAssesmen as $index => $riwayat)
                            <tr class="hover:bg-slate-50 transition-colors {{ $riwayat->pendaftaran_id == $pendaftaran->id ? 'bg-blue-50/20' : '' }}">
                                <td class="border border-slate-300 px-3 py-2 text-center">{{ $index + 1 }}</td>
                                <td class="border border-slate-300 px-3 py-2 font-medium text-slate-800">{{ \Carbon\Carbon::parse($riwayat->tanggal)->format('d M Y H:i') }}</td>
                                <td class="border border-slate-300 px-3 py-2 text-slate-600">{{ $riwayat->pendaftaran->poliklinik->nama_poli ?? '-' }}</td>
                                <td class="border border-slate-300 px-3 py-2 text-center font-medium">{{ $riwayat->tekanan_darah ?? '-' }}</td>
                                <td class="border border-slate-300 px-3 py-2 text-center">{{ $riwayat->denyut_nadi ?? '-' }}</td>
                                <td class="border border-slate-300 px-3 py-2 text-center">{!! $riwayat->suhu_tubuh ?? '-' !!}</td>
                                <td class="border border-slate-300 px-3 py-2 text-center">{{ $riwayat->frekuensi_napas ?? '-' }}</td>
                                <td class="border border-slate-300 px-3 py-2 text-center">{{ $riwayat->berat_badan ?? '-' }}</td>
                                <td class="border border-slate-300 px-3 py-2 text-center">{{ $riwayat->tinggi_badan ?? '-' }}</td>
                                <td class="border border-slate-300 px-3 py-2 text-center">{{ $riwayat->lingkar_perut ?? '-' }}</td>
                                <td class="border border-slate-300 px-3 py-2 text-center">{{ $riwayat->skala_nyeri !== null ? $riwayat->skala_nyeri : '-' }}</td>
                                <td class="border border-slate-300 px-3 py-2 text-center text-[10px]">{{ $riwayat->resiko_jatuh ?? '-' }}</td>
                                <td class="border border-slate-300 px-3 py-2 text-left truncate max-w-[100px]" title="{{ $riwayat->riwayat_alergi }}">{{ $riwayat->riwayat_alergi ?? '-' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="13" class="border border-slate-300 px-5 py-6 text-center text-slate-400 italic">Belum ada data asesmen keperawatan.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- FORM ASESMEN (TTV) -->
            <form id="formAssesmen" action="{{ route('rawat_jalan.store_assesmen', $pendaftaran->id) }}" method="POST">
                @csrf
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm flex flex-col mb-4">
                    
                    <div class="px-5 py-4 border-b border-emerald-100 bg-emerald-50 flex justify-between items-center rounded-t-xl">
                        <h2 class="font-bold text-emerald-800 text-sm flex items-center">
                            <i class="fa-solid fa-stethoscope mr-2 text-emerald-600"></i> Form Input TTV (Kunjungan Saat Ini)
                        </h2>
                        <div class="flex items-center gap-2 bg-white px-3 py-1.5 rounded-lg border border-slate-200 shadow-sm">
                            <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">Tanggal:</label>
                            <input type="date" name="tanggal" value="{{ \Carbon\Carbon::parse($assesmen->tanggal)->format('Y-m-d') }}" class="border-0 focus:ring-0 text-xs p-0 w-28 font-medium text-slate-700 bg-transparent">
                        </div>
                    </div>

                    <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-x-8 gap-y-6">
                        
                        <!-- KOLOM 1 -->
                        <div class="space-y-6">
                            <div>
                                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">Tekanan Darah</label>
                                <div class="flex items-center gap-3">
                                    <input type="text" name="tekanan_darah" value="{{ $assesmen->tekanan_darah }}" class="flex-1 rounded-lg border-slate-300 focus:border-brand-500 focus:ring-brand-500 text-sm p-2.5" placeholder="120/80">
                                    <span class="text-xs font-medium text-slate-400 w-12">mmHg</span>
                                </div>
                                <p class="text-[10px] text-slate-400 mt-1.5">Menggunakan tensimeter.</p>
                            </div>
                            
                            <div>
                                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">Suhu Tubuh</label>
                                <div class="flex items-center gap-3">
                                    <input type="number" step="0.1" name="suhu_tubuh" value="{{ $assesmen->suhu_tubuh }}" class="flex-1 rounded-lg border-slate-300 focus:border-brand-500 focus:ring-brand-500 text-sm p-2.5" placeholder="36.5">
                                    <span class="text-xs font-medium text-slate-400 w-12">°C</span>
                                </div>
                            </div>
                        </div>

                        <!-- KOLOM 2 -->
                        <div class="space-y-6">
                            <div>
                                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">Denyut Nadi</label>
                                <div class="flex items-center gap-3">
                                    <input type="number" name="denyut_nadi" value="{{ $assesmen->denyut_nadi }}" class="flex-1 rounded-lg border-slate-300 focus:border-brand-500 focus:ring-brand-500 text-sm p-2.5" placeholder="80">
                                    <span class="text-xs font-medium text-slate-400 w-12">x/mnt</span>
                                </div>
                            </div>

                            <div>
                                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">Berat Badan</label>
                                <div class="flex items-center gap-3">
                                    <input type="number" step="0.1" name="berat_badan" value="{{ $assesmen->berat_badan }}" class="flex-1 rounded-lg border-slate-300 focus:border-brand-500 focus:ring-brand-500 text-sm p-2.5" placeholder="60">
                                    <span class="text-xs font-medium text-slate-400 w-12">Kg</span>
                                </div>
                            </div>
                        </div>

                        <!-- KOLOM 3 -->
                        <div class="space-y-6">
                            <div>
                                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">Frekuensi Napas</label>
                                <div class="flex items-center gap-3">
                                    <input type="number" name="frekuensi_napas" value="{{ $assesmen->frekuensi_napas }}" class="flex-1 rounded-lg border-slate-300 focus:border-brand-500 focus:ring-brand-500 text-sm p-2.5" placeholder="20">
                                    <span class="text-xs font-medium text-slate-400 w-12">x/mnt</span>
                                </div>
                            </div>

                            <div>
                                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">Tinggi Badan</label>
                                <div class="flex items-center gap-3">
                                    <input type="number" step="0.1" name="tinggi_badan" value="{{ $assesmen->tinggi_badan }}" class="flex-1 rounded-lg border-slate-300 focus:border-brand-500 focus:ring-brand-500 text-sm p-2.5" placeholder="165">
                                    <span class="text-xs font-medium text-slate-400 w-12">cm</span>
                                </div>
                            </div>

                            <div>
                                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">Lingkar Perut</label>
                                <div class="flex items-center gap-3">
                                    <input type="number" step="0.1" name="lingkar_perut" value="{{ $assesmen->lingkar_perut }}" class="flex-1 rounded-lg border-slate-300 focus:border-brand-500 focus:ring-brand-500 text-sm p-2.5" placeholder="80">
                                    <span class="text-xs font-medium text-slate-400 w-12">cm</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- SKRINING TAMBAHAN -->
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm flex flex-col mb-4">
                    <div class="px-5 py-4 border-b border-indigo-100 bg-indigo-50 flex justify-between items-center rounded-t-xl">
                        <h2 class="font-bold text-indigo-800 text-sm flex items-center">
                            <i class="fa-solid fa-clipboard-check mr-2 text-indigo-600"></i> Skrining Tambahan (Keperawatan)
                        </h2>
                    </div>
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                        <div>
                            <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">Skala Nyeri (0 - 10)</label>
                            <input type="number" id="skala_nyeri_input" name="skala_nyeri" value="{{ $assesmen->skala_nyeri }}" min="0" max="10" class="w-full rounded-lg border-slate-300 focus:border-brand-500 focus:ring-brand-500 text-sm p-2.5" placeholder="0 (Tidak nyeri)">
                            
                            <!-- Visual Pain Scale -->
                            <div class="mt-3 flex justify-between items-center text-center bg-slate-50 p-2.5 rounded-lg border border-slate-200">
                                <div class="flex flex-col items-center cursor-pointer hover:scale-110 transition-transform pain-scale-btn p-1 rounded-lg hover:bg-slate-200" onclick="document.getElementById('skala_nyeri_input').value = this.querySelector('span').innerText">
                                    <i class="fa-regular fa-face-laugh text-emerald-500 text-xl mb-1"></i>
                                    <span class="text-xs font-bold text-slate-700">0</span>
                                    <span class="text-[9px] text-slate-500 leading-tight mt-0.5">Tidak<br>Nyeri</span>
                                </div>
                                <div class="flex flex-col items-center cursor-pointer hover:scale-110 transition-transform pain-scale-btn p-1 rounded-lg hover:bg-slate-200" onclick="document.getElementById('skala_nyeri_input').value = this.querySelector('span').innerText">
                                    <i class="fa-regular fa-face-smile text-lime-500 text-xl mb-1"></i>
                                    <span class="text-xs font-bold text-slate-700">2</span>
                                    <span class="text-[9px] text-slate-500 leading-tight mt-0.5">Sedikit</span>
                                </div>
                                <div class="flex flex-col items-center cursor-pointer hover:scale-110 transition-transform pain-scale-btn p-1 rounded-lg hover:bg-slate-200" onclick="document.getElementById('skala_nyeri_input').value = this.querySelector('span').innerText">
                                    <i class="fa-regular fa-face-meh text-yellow-500 text-xl mb-1"></i>
                                    <span class="text-xs font-bold text-slate-700">4</span>
                                    <span class="text-[9px] text-slate-500 leading-tight mt-0.5">Sedang</span>
                                </div>
                                <div class="flex flex-col items-center cursor-pointer hover:scale-110 transition-transform pain-scale-btn p-1 rounded-lg hover:bg-slate-200" onclick="document.getElementById('skala_nyeri_input').value = this.querySelector('span').innerText">
                                    <i class="fa-regular fa-face-frown text-orange-500 text-xl mb-1"></i>
                                    <span class="text-xs font-bold text-slate-700">6</span>
                                    <span class="text-[9px] text-slate-500 leading-tight mt-0.5">Lumayan</span>
                                </div>
                                <div class="flex flex-col items-center cursor-pointer hover:scale-110 transition-transform pain-scale-btn p-1 rounded-lg hover:bg-slate-200" onclick="document.getElementById('skala_nyeri_input').value = this.querySelector('span').innerText">
                                    <i class="fa-regular fa-face-sad-tear text-rose-500 text-xl mb-1"></i>
                                    <span class="text-xs font-bold text-slate-700">8</span>
                                    <span class="text-[9px] text-slate-500 leading-tight mt-0.5">Sangat</span>
                                </div>
                                <div class="flex flex-col items-center cursor-pointer hover:scale-110 transition-transform pain-scale-btn p-1 rounded-lg hover:bg-slate-200" onclick="document.getElementById('skala_nyeri_input').value = this.querySelector('span').innerText">
                                    <i class="fa-regular fa-face-sad-cry text-red-600 text-xl mb-1"></i>
                                    <span class="text-xs font-bold text-slate-700">10</span>
                                    <span class="text-[9px] text-slate-500 leading-tight mt-0.5">Hebat</span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">Resiko Jatuh</label>
                            <select name="resiko_jatuh" class="w-full rounded-lg border-slate-300 focus:border-brand-500 focus:ring-brand-500 text-sm p-2.5">
                                <option value="">-- Pilih Resiko --</option>
                                <option value="Tidak Berisiko" {{ $assesmen->resiko_jatuh == 'Tidak Berisiko' ? 'selected' : '' }}>Tidak Berisiko</option>
                                <option value="Risiko Rendah" {{ $assesmen->resiko_jatuh == 'Risiko Rendah' ? 'selected' : '' }}>Risiko Rendah</option>
                                <option value="Risiko Tinggi" {{ $assesmen->resiko_jatuh == 'Risiko Tinggi' ? 'selected' : '' }}>Risiko Tinggi</option>
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">Riwayat Alergi Makanan / Obat</label>
                            <input type="text" name="riwayat_alergi" value="{{ $assesmen->riwayat_alergi }}" class="w-full rounded-lg border-slate-300 focus:border-brand-500 focus:ring-brand-500 text-sm p-2.5" placeholder="Ketik jenis alergi (contoh: Amoxicillin, Udang) atau '-' jika tidak ada">
                        </div>
                    </div>
                </div>
            </form>

        </div>

        <!-- FOOTER (TOMBOL SIMPAN UBAH HAPUS) -->
        <div class="px-6 py-4 bg-white border-t border-slate-200 shrink-0 z-10 flex justify-end gap-3 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)]">
            <button type="button" onclick="document.getElementById('formAssesmen').submit();" class="whitespace-nowrap bg-brand-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-brand-700 transition-colors shadow-sm flex items-center">
                <i class="fa-solid fa-save mr-1.5"></i> Simpan
            </button>
        </div>

    </div>
    
</div>
@endsection

