@extends('layouts.app')

@section('title', 'Input Pasien Baru')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('pasien.index') }}" class="text-slate-400 hover:text-slate-600 transition-colors">
            <i class="fa-solid fa-arrow-left text-xl"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Input Pasien Baru</h1>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <form action="{{ route('pasien.store') }}" method="POST" class="p-6" novalidate>
            @csrf
            
            <!-- SECTION 1: Identitas Utama -->
            <h3 class="text-lg font-semibold text-slate-800 mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                <i class="fa-solid fa-id-card text-brand-500"></i> Identitas Utama
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-8">
                <!-- Kolom Kiri: No RM, Jenis Pasien & NIK -->
                <div>
                    <div class="mb-5">
                        <div class="flex justify-between items-center mb-1">
                            <label class="block text-sm font-medium text-slate-700">No. Rekam Medis (RM)</label>
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" id="auto_rm" checked class="w-4 h-4 text-brand-600 border-slate-300 rounded focus:ring-brand-500" onchange="toggleRmInput()">
                                <span class="ml-2 text-xs font-medium text-slate-600">Buat Otomatis (Auto-Generate)</span>
                            </label>
                        </div>
                        <input type="text" id="no_rm" name="no_rm" value="{{ old('no_rm') }}" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-500 transition-all bg-slate-100 text-slate-500 font-mono cursor-not-allowed @error('no_rm') border-red-500 @enderror" placeholder="Otomatis (Misal: RM-2610-0001)" readonly>
                        @error('no_rm') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-5">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Jenis Pasien (Penjamin Utama) *</label>
                        <select name="id_penjamin" id="select_jenis_pasien" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-500 transition-all bg-white" onchange="toggleBpjs()">
                            <option value="">Pilih Data Penjamin</option>
                            @foreach($penjamins as $p)
                                <option value="{{ $p->id_penjamin }}" {{ old('id_penjamin') == $p->id_penjamin ? 'selected' : '' }}>{{ $p->id_penjamin }} - {{ $p->nama_penjamin }}</option>
                            @endforeach
                        </select>
                        <p class="text-xs text-slate-500 mt-1">Pilih penjamin untuk menentukan relasi BPJS atau Umum.</p>
                        @error('id_penjamin') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">NIK (Nomor Induk Kependudukan) *</label>
                        <input type="text" name="nik" required placeholder="16 digit NIK" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-500 transition-all @error('nik') border-red-500 @enderror" value="{{ old('nik') }}">
                        @error('nik') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Kolom Kanan: Nomor BPJS -->
                <div>
                    <div id="container_bpjs" style="display: none;">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Nomor Kartu BPJS *</label>
                        <input type="text" id="input_bpjs" name="no_kartu_bpjs" placeholder="13 digit nomor BPJS" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-500 transition-all @error('no_kartu_bpjs') border-red-500 @enderror" value="{{ old('no_kartu_bpjs') }}">
                        @error('no_kartu_bpjs') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
                
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap Sesuai KTP *</label>
                    <input type="text" name="nama" required placeholder="Nama Lengkap Pasien" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-all" value="{{ old('nama') }}">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" placeholder="Kota/Kabupaten" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-all" value="{{ old('tempat_lahir') }}">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Tanggal Lahir *</label>
                    <input type="date" name="tanggal_lahir" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-all" value="{{ old('tanggal_lahir') }}">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Jenis Kelamin *</label>
                    <select name="jenis_kelamin" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-all bg-white">
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Golongan Darah</label>
                    <select name="golongan_darah" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-all bg-white">
                        <option value="Tidak Tahu">Tidak Tahu</option>
                        <option value="A" {{ old('golongan_darah') == 'A' ? 'selected' : '' }}>A</option>
                        <option value="B" {{ old('golongan_darah') == 'B' ? 'selected' : '' }}>B</option>
                        <option value="AB" {{ old('golongan_darah') == 'AB' ? 'selected' : '' }}>AB</option>
                        <option value="O" {{ old('golongan_darah') == 'O' ? 'selected' : '' }}>O</option>
                    </select>
                </div>
            </div>

            <!-- SECTION 2: Data Demografi & Alamat -->
            <h3 class="text-lg font-semibold text-slate-800 mb-4 pb-2 border-b border-slate-100 flex items-center gap-2 mt-8">
                <i class="fa-solid fa-map-location-dot text-brand-500"></i> Demografi & Alamat
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
                <div class="lg:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Agama</label>
                    <select name="agama" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-500 transition-all bg-white">
                        <option value="">Pilih Agama</option>
                        <option value="Islam">Islam</option>
                        <option value="Kristen">Kristen</option>
                        <option value="Katolik">Katolik</option>
                        <option value="Hindu">Hindu</option>
                        <option value="Buddha">Buddha</option>
                        <option value="Konghucu">Konghucu</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Status Pernikahan</label>
                    <select name="status_pernikahan" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-500 transition-all bg-white">
                        <option value="">Pilih Status</option>
                        <option value="Belum Kawin">Belum Kawin</option>
                        <option value="Kawin">Kawin</option>
                        <option value="Cerai Hidup">Cerai Hidup</option>
                        <option value="Cerai Mati">Cerai Mati</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Kewarganegaraan</label>
                    <select name="kewarganegaraan" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-500 transition-all bg-white">
                        <option value="WNI" selected>WNI</option>
                        <option value="WNA">WNA</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Pendidikan Terakhir</label>
                    <select name="pendidikan" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-500 transition-all bg-white">
                        <option value="">Pilih Pendidikan</option>
                        <option value="Tidak Sekolah">Tidak Sekolah</option>
                        <option value="SD">SD Sederajat</option>
                        <option value="SMP">SMP Sederajat</option>
                        <option value="SMA">SMA Sederajat</option>
                        <option value="D3">Diploma (D1-D3)</option>
                        <option value="S1">Sarjana (S1)</option>
                        <option value="S2">Magister (S2)</option>
                        <option value="S3">Doktor (S3)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Pekerjaan</label>
                    <input type="text" name="pekerjaan" placeholder="Contoh: PNS, Swasta, Petani" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-500 transition-all" value="{{ old('pekerjaan') }}">
                </div>

                <div class="lg:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nama Ibu Kandung</label>
                    <input type="text" name="nama_ibu_kandung" placeholder="Nama lengkap ibu kandung" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-500 transition-all" value="{{ old('nama_ibu_kandung') }}">
                </div>

                <!-- API Wilayah Dropdowns -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Provinsi</label>
                    <select id="select_provinsi" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-500 bg-white" onchange="loadKabupaten(this)">
                        <option value="">Pilih Provinsi</option>
                    </select>
                    <input type="hidden" name="provinsi" id="hidden_provinsi">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Kabupaten/Kota</label>
                    <select id="select_kabupaten" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-500 bg-white" onchange="loadKecamatan(this)" disabled>
                        <option value="">Pilih Kabupaten</option>
                    </select>
                    <input type="hidden" name="kabupaten" id="hidden_kabupaten">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Kecamatan</label>
                    <select id="select_kecamatan" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-500 bg-white" onchange="loadDesa(this)" disabled>
                        <option value="">Pilih Kecamatan</option>
                    </select>
                    <input type="hidden" name="kecamatan" id="hidden_kecamatan">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Desa/Kelurahan</label>
                    <select id="select_desa" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-500 bg-white" onchange="setDesa(this)" disabled>
                        <option value="">Pilih Desa</option>
                    </select>
                    <input type="hidden" name="desa" id="hidden_desa">
                </div>

                <!-- Detail Alamat -->
                <div class="lg:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Alamat Jalan</label>
                    <input type="text" name="alamat" placeholder="Nama Jalan, Gedung, No. Rumah" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-500 transition-all" value="{{ old('alamat') }}">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">RT</label>
                    <input type="text" name="rt" placeholder="001" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-500 transition-all" value="{{ old('rt') }}">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">RW</label>
                    <input type="text" name="rw" placeholder="002" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-500 transition-all" value="{{ old('rw') }}">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Kode Pos</label>
                    <input type="text" name="kode_pos" placeholder="12345" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-500 transition-all" value="{{ old('kode_pos') }}">
                </div>
                
                <div class="lg:col-span-3">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nomor Telepon/HP</label>
                    <input type="text" name="no_telepon" placeholder="0812..." class="w-full md:w-1/2 lg:w-1/3 px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-500 transition-all" value="{{ old('no_telepon') }}">
                </div>
            </div>

            <!-- SECTION 3: Penanggung Jawab (Darurat / Wali) -->
            <h3 class="text-lg font-semibold text-slate-800 mb-4 pb-2 border-b border-slate-100 flex items-center gap-2 mt-8">
                <i class="fa-solid fa-user-shield text-brand-500"></i> Kontak Darurat / Penanggung Jawab
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-8">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nama Penanggung Jawab</label>
                    <input type="text" name="nama_penanggung_jawab" placeholder="Nama lengkap wali/penanggung jawab" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-500 transition-all" value="{{ old('nama_penanggung_jawab') }}">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Hubungan dengan Pasien</label>
                    <select name="hubungan_penanggung_jawab" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-500 transition-all bg-white">
                        <option value="">Pilih Hubungan</option>
                        <option value="Suami">Suami</option>
                        <option value="Istri">Istri</option>
                        <option value="Ayah">Ayah</option>
                        <option value="Ibu">Ibu</option>
                        <option value="Anak">Anak</option>
                        <option value="Saudara">Saudara</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nomor Telepon Penanggung Jawab</label>
                    <input type="text" name="no_telepon_penanggung_jawab" placeholder="08..." class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-500 transition-all" value="{{ old('no_telepon_penanggung_jawab') }}">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Alamat Penanggung Jawab</label>
                    <textarea name="alamat_penanggung_jawab" rows="2" placeholder="Alamat lengkap penanggung jawab" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-500 transition-all">{{ old('alamat_penanggung_jawab') }}</textarea>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('pasien.index') }}" class="px-5 py-2 border border-slate-300 rounded-lg text-slate-700 text-sm font-medium hover:bg-slate-50 transition-colors">Batal</a>
                <button type="submit" class="px-5 py-2 bg-brand-600 text-white rounded-lg text-sm font-medium hover:bg-brand-700 shadow-sm flex items-center transition-colors">
                    <i class="fa-solid fa-save mr-2"></i> Simpan Data Pasien
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const urlApi = 'https://www.emsifa.com/api-wilayah-indonesia/api';

    // 1. Load Provinsi on page load
    fetch(`${urlApi}/provinces.json`)
        .then(response => response.json())
        .then(provinces => {
            const select = document.getElementById('select_provinsi');
            provinces.forEach(prov => {
                let option = document.createElement('option');
                option.value = prov.id;
                option.text = prov.name;
                select.appendChild(option);
            });
        });

    function loadKabupaten(el) {
        document.getElementById('hidden_provinsi').value = el.options[el.selectedIndex].text;
        const idProv = el.value;
        const selectKab = document.getElementById('select_kabupaten');
        const selectKec = document.getElementById('select_kecamatan');
        const selectDesa = document.getElementById('select_desa');

        selectKab.innerHTML = '<option value="">Pilih Kabupaten</option>';
        selectKec.innerHTML = '<option value="">Pilih Kecamatan</option>';
        selectDesa.innerHTML = '<option value="">Pilih Desa</option>';
        
        if (!idProv) {
            selectKab.disabled = true; selectKec.disabled = true; selectDesa.disabled = true;
            return;
        }

        fetch(`${urlApi}/regencies/${idProv}.json`)
            .then(response => response.json())
            .then(regencies => {
                regencies.forEach(reg => {
                    let option = document.createElement('option');
                    option.value = reg.id;
                    option.text = reg.name;
                    selectKab.appendChild(option);
                });
                selectKab.disabled = false;
            });
    }

    function loadKecamatan(el) {
        document.getElementById('hidden_kabupaten').value = el.options[el.selectedIndex].text;
        const idKab = el.value;
        const selectKec = document.getElementById('select_kecamatan');
        const selectDesa = document.getElementById('select_desa');

        selectKec.innerHTML = '<option value="">Pilih Kecamatan</option>';
        selectDesa.innerHTML = '<option value="">Pilih Desa</option>';

        if (!idKab) {
            selectKec.disabled = true; selectDesa.disabled = true;
            return;
        }

        fetch(`${urlApi}/districts/${idKab}.json`)
            .then(response => response.json())
            .then(districts => {
                districts.forEach(dist => {
                    let option = document.createElement('option');
                    option.value = dist.id;
                    option.text = dist.name;
                    selectKec.appendChild(option);
                });
                selectKec.disabled = false;
            });
    }

    function loadDesa(el) {
        document.getElementById('hidden_kecamatan').value = el.options[el.selectedIndex].text;
        const idKec = el.value;
        const selectDesa = document.getElementById('select_desa');

        selectDesa.innerHTML = '<option value="">Pilih Desa</option>';

        if (!idKec) {
            selectDesa.disabled = true;
            return;
        }

        fetch(`${urlApi}/villages/${idKec}.json`)
            .then(response => response.json())
            .then(villages => {
                villages.forEach(vill => {
                    let option = document.createElement('option');
                    option.value = vill.id;
                    option.text = vill.name;
                    selectDesa.appendChild(option);
                });
                selectDesa.disabled = false;
            });
    }

    function setDesa(el) {
        document.getElementById('hidden_desa').value = el.options[el.selectedIndex].text;
    }

    function toggleBpjs() {
        const select = document.getElementById('select_jenis_pasien');
        const containerBpjs = document.getElementById('container_bpjs');
        const inputBpjs = document.getElementById('input_bpjs');

        if (select.selectedIndex === -1) return;
        
        const selectedText = select.options[select.selectedIndex].text.toLowerCase();
        
        if (selectedText.includes('bpjs')) {
            containerBpjs.style.display = 'block';
            inputBpjs.required = true;
        } else {
            containerBpjs.style.display = 'none';
            inputBpjs.required = false;
            inputBpjs.value = ''; // Kosongkan inputan jika diganti ke umum
        }
    }

    function toggleRmInput() {
        const checkbox = document.getElementById('auto_rm');
        const input = document.getElementById('no_rm');
        
        if (checkbox.checked) {
            input.readOnly = true;
            input.classList.add('bg-slate-100', 'cursor-not-allowed', 'text-slate-500');
            input.value = '';
            input.placeholder = 'Otomatis (Misal: RM-2610-0001)';
        } else {
            input.readOnly = false;
            input.classList.remove('bg-slate-100', 'cursor-not-allowed', 'text-slate-500');
            input.placeholder = 'Ketik No RM secara manual';
        }
    }

    // Run on load in case of validation error (old input)
    document.addEventListener('DOMContentLoaded', function() {
        const input = document.getElementById('no_rm');
        const checkbox = document.getElementById('auto_rm');
        if (input.value.trim() !== '') {
            checkbox.checked = false;
            toggleRmInput();
        }
        toggleBpjs();
    });
</script>
@endsection
