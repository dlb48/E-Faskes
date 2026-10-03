@extends('layouts.app')

@section('title', 'Ubah Data Pasien')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('pasien.index') }}" class="text-slate-400 hover:text-slate-600 transition-colors">
            <i class="fa-solid fa-arrow-left text-xl"></i>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Ubah Data Pasien</h1>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <form novalidate action="{{ route('pasien.update', $pasien->nik) }}" method="POST" class="p-6">
            @csrf
            @method('PUT')
            
            <!-- SECTION 1: Identitas Utama -->
            <h3 class="text-lg font-semibold text-slate-800 mb-4 pb-2 border-b border-slate-100 flex items-center gap-2">
                <i class="fa-solid fa-id-card text-brand-500"></i> Identitas Utama
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-8">
                <!-- Kolom Kiri: No RM, Jenis Pasien & NIK -->
                <div>
                    <div class="mb-5">
                        <label class="block text-sm font-medium text-slate-700 mb-1">No. Rekam Medis (RM)</label>
                        <input type="text" name="no_rm" value="{{ old('no_rm', $pasien->no_rm) }}" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-500 transition-all bg-white @error('no_rm') border-red-500 @enderror">
                        @error('no_rm') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-5">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Jenis Pasien (Penjamin Utama) *</label>
                        <select name="id_penjamin" id="select_jenis_pasien" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-500 transition-all bg-white" onchange="toggleBpjs()">
                            <option value="">Pilih Data Penjamin</option>
                            @foreach($penjamins as $p)
                                <option value="{{ $p->id_penjamin }}" {{ old('id_penjamin', $pasien->id_penjamin) == $p->id_penjamin ? 'selected' : '' }}>{{ $p->id_penjamin }} - {{ $p->nama_penjamin }}</option>
                            @endforeach
                        </select>
                        <p class="text-xs text-slate-500 mt-1">Pilih penjamin untuk menentukan relasi BPJS atau Umum.</p>
                        @error('id_penjamin') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">NIK (Nomor Induk Kependudukan) *</label>
                        <input type="text" name="nik" required placeholder="16 digit NIK" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-500 transition-all @error('nik') border-red-500 @enderror" value="{{ old('nik', $pasien->nik) }}">
                        @error('nik') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Kolom Kanan: Nomor BPJS -->
                <div>
                    <div id="container_bpjs" style="display: none;">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Nomor Kartu BPJS *</label>
                        <input type="text" id="input_bpjs" name="no_kartu_bpjs" placeholder="13 digit nomor BPJS" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-500 transition-all @error('no_kartu_bpjs') border-red-500 @enderror" value="{{ old('no_kartu_bpjs', $pasien->no_kartu_bpjs) }}">
                        @error('no_kartu_bpjs') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
                
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap Sesuai KTP *</label>
                    <input type="text" name="nama" required placeholder="Nama Lengkap Pasien" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-all" value="{{ old('nama', $pasien->nama) }}">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" placeholder="Kota/Kabupaten" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-all" value="{{ old('tempat_lahir', $pasien->tempat_lahir) }}">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Tanggal Lahir *</label>
                    <input type="date" name="tanggal_lahir" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-all" value="{{ old('tanggal_lahir', $pasien->tanggal_lahir) }}">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Jenis Kelamin *</label>
                    <select name="jenis_kelamin" required class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-all bg-white">
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="Laki-laki" {{ old('jenis_kelamin', $pasien->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('jenis_kelamin', $pasien->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Golongan Darah</label>
                    <select name="golongan_darah" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 transition-all bg-white">
                        <option value="Tidak Tahu">Tidak Tahu</option>
                        <option value="A" {{ old('golongan_darah', $pasien->golongan_darah) == 'A' ? 'selected' : '' }}>A</option>
                        <option value="B" {{ old('golongan_darah', $pasien->golongan_darah) == 'B' ? 'selected' : '' }}>B</option>
                        <option value="AB" {{ old('golongan_darah', $pasien->golongan_darah) == 'AB' ? 'selected' : '' }}>AB</option>
                        <option value="O" {{ old('golongan_darah', $pasien->golongan_darah) == 'O' ? 'selected' : '' }}>O</option>
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
                        <option value="Islam" {{ old('agama', $pasien->agama) == 'Islam' ? 'selected' : '' }}>Islam</option>
                        <option value="Kristen" {{ old('agama', $pasien->agama) == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                        <option value="Katolik" {{ old('agama', $pasien->agama) == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                        <option value="Hindu" {{ old('agama', $pasien->agama) == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                        <option value="Buddha" {{ old('agama', $pasien->agama) == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                        <option value="Konghucu" {{ old('agama', $pasien->agama) == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Status Pernikahan</label>
                    <select name="status_pernikahan" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-500 transition-all bg-white">
                        <option value="">Pilih Status</option>
                        <option value="Belum Kawin" {{ old('status_pernikahan', $pasien->status_pernikahan) == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin</option>
                        <option value="Kawin" {{ old('status_pernikahan', $pasien->status_pernikahan) == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                        <option value="Cerai Hidup" {{ old('status_pernikahan', $pasien->status_pernikahan) == 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                        <option value="Cerai Mati" {{ old('status_pernikahan', $pasien->status_pernikahan) == 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Kewarganegaraan</label>
                    <select name="kewarganegaraan" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-500 transition-all bg-white">
                        <option value="WNI" {{ old('kewarganegaraan', $pasien->kewarganegaraan) == 'WNI' ? 'selected' : '' }}>WNI</option>
                        <option value="WNA" {{ old('kewarganegaraan', $pasien->kewarganegaraan) == 'WNA' ? 'selected' : '' }}>WNA</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Pendidikan Terakhir</label>
                    <select name="pendidikan" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-500 transition-all bg-white">
                        <option value="">Pilih Pendidikan</option>
                        <option value="Tidak Sekolah" {{ old('pendidikan', $pasien->pendidikan) == 'Tidak Sekolah' ? 'selected' : '' }}>Tidak Sekolah</option>
                        <option value="SD" {{ old('pendidikan', $pasien->pendidikan) == 'SD' ? 'selected' : '' }}>SD Sederajat</option>
                        <option value="SMP" {{ old('pendidikan', $pasien->pendidikan) == 'SMP' ? 'selected' : '' }}>SMP Sederajat</option>
                        <option value="SMA" {{ old('pendidikan', $pasien->pendidikan) == 'SMA' ? 'selected' : '' }}>SMA Sederajat</option>
                        <option value="D3" {{ old('pendidikan', $pasien->pendidikan) == 'D3' ? 'selected' : '' }}>Diploma (D1-D3)</option>
                        <option value="S1" {{ old('pendidikan', $pasien->pendidikan) == 'S1' ? 'selected' : '' }}>Sarjana (S1)</option>
                        <option value="S2" {{ old('pendidikan', $pasien->pendidikan) == 'S2' ? 'selected' : '' }}>Magister (S2)</option>
                        <option value="S3" {{ old('pendidikan', $pasien->pendidikan) == 'S3' ? 'selected' : '' }}>Doktor (S3)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Pekerjaan</label>
                    <input type="text" name="pekerjaan" placeholder="Contoh: PNS, Swasta, Petani" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-500 transition-all" value="{{ old('pekerjaan', $pasien->pekerjaan) }}">
                </div>

                <div class="lg:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nama Ibu Kandung</label>
                    <input type="text" name="nama_ibu_kandung" placeholder="Nama lengkap ibu kandung" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-500 transition-all" value="{{ old('nama_ibu_kandung', $pasien->nama_ibu_kandung) }}">
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
                    <input type="text" name="alamat" placeholder="Nama Jalan, Gedung, No. Rumah" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-500 transition-all" value="{{ old('alamat', $pasien->alamat) }}">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">RT</label>
                    <input type="text" name="rt" placeholder="001" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-500 transition-all" value="{{ old('rt', $pasien->rt) }}">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">RW</label>
                    <input type="text" name="rw" placeholder="002" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-500 transition-all" value="{{ old('rw', $pasien->rw) }}">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Kode Pos</label>
                    <input type="text" name="kode_pos" placeholder="12345" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-500 transition-all" value="{{ old('kode_pos', $pasien->kode_pos) }}">
                </div>
                
                <div class="lg:col-span-3">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nomor Telepon/HP</label>
                    <input type="text" name="no_telepon" placeholder="0812..." class="w-full md:w-1/2 lg:w-1/3 px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-500 transition-all" value="{{ old('no_telepon', $pasien->no_telepon) }}">
                </div>
            </div>

            <!-- SECTION 3: Penanggung Jawab (Darurat / Wali) -->
            <h3 class="text-lg font-semibold text-slate-800 mb-4 pb-2 border-b border-slate-100 flex items-center gap-2 mt-8">
                <i class="fa-solid fa-user-shield text-brand-500"></i> Kontak Darurat / Penanggung Jawab
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-8">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nama Penanggung Jawab</label>
                    <input type="text" name="nama_penanggung_jawab" placeholder="Nama lengkap wali/penanggung jawab" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-500 transition-all" value="{{ old('nama_penanggung_jawab', $pasien->nama_penanggung_jawab) }}">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Hubungan dengan Pasien</label>
                    <select name="hubungan_penanggung_jawab" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-500 transition-all bg-white">
                        <option value="">Pilih Hubungan</option>
                        <option value="Suami" {{ old('hubungan_penanggung_jawab', $pasien->hubungan_penanggung_jawab) == 'Suami' ? 'selected' : '' }}>Suami</option>
                        <option value="Istri" {{ old('hubungan_penanggung_jawab', $pasien->hubungan_penanggung_jawab) == 'Istri' ? 'selected' : '' }}>Istri</option>
                        <option value="Ayah" {{ old('hubungan_penanggung_jawab', $pasien->hubungan_penanggung_jawab) == 'Ayah' ? 'selected' : '' }}>Ayah</option>
                        <option value="Ibu" {{ old('hubungan_penanggung_jawab', $pasien->hubungan_penanggung_jawab) == 'Ibu' ? 'selected' : '' }}>Ibu</option>
                        <option value="Anak" {{ old('hubungan_penanggung_jawab', $pasien->hubungan_penanggung_jawab) == 'Anak' ? 'selected' : '' }}>Anak</option>
                        <option value="Saudara" {{ old('hubungan_penanggung_jawab', $pasien->hubungan_penanggung_jawab) == 'Saudara' ? 'selected' : '' }}>Saudara</option>
                        <option value="Lainnya" {{ old('hubungan_penanggung_jawab', $pasien->hubungan_penanggung_jawab) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nomor Telepon Penanggung Jawab</label>
                    <input type="text" name="no_telepon_penanggung_jawab" placeholder="08..." class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-500 transition-all" value="{{ old('no_telepon_penanggung_jawab', $pasien->no_telepon_penanggung_jawab) }}">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Alamat Penanggung Jawab</label>
                    <textarea name="alamat_penanggung_jawab" rows="2" placeholder="Alamat lengkap penanggung jawab" class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-500 transition-all">{{ old('alamat_penanggung_jawab', $pasien->alamat_penanggung_jawab) }}</textarea>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('pasien.index') }}" class="px-5 py-2 border border-slate-300 rounded-lg text-slate-700 text-sm font-medium hover:bg-slate-50 transition-colors">Batal</a>
                <button type="submit" class="px-5 py-2 bg-brand-600 text-white rounded-lg text-sm font-medium hover:bg-brand-700 shadow-sm flex items-center transition-colors">
                    <i class="fa-solid fa-save mr-2"></i> Perbarui Data Pasien
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const urlApi = 'https://www.emsifa.com/api-wilayah-indonesia/api';

    const initProv = "{{ old('provinsi', $pasien->provinsi) }}";
    const initKab = "{{ old('kabupaten', $pasien->kabupaten) }}";
    const initKec = "{{ old('kecamatan', $pasien->kecamatan) }}";
    const initDesa = "{{ old('desa', $pasien->desa) }}";

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
            
            if(initProv) {
                Array.from(select.options).forEach(opt => {
                    if (opt.text === initProv) opt.selected = true;
                });
                loadKabupaten(select, initKab);
            }
        });

    function loadKabupaten(el, autoSelectName = null) {
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
                
                if(autoSelectName) {
                    Array.from(selectKab.options).forEach(opt => {
                        if (opt.text === autoSelectName) opt.selected = true;
                    });
                    loadKecamatan(selectKab, initKec);
                }
            });
    }

    function loadKecamatan(el, autoSelectName = null) {
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
                
                if(autoSelectName) {
                    Array.from(selectKec.options).forEach(opt => {
                        if (opt.text === autoSelectName) opt.selected = true;
                    });
                    loadDesa(selectKec, initDesa);
                }
            });
    }

    function loadDesa(el, autoSelectName = null) {
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
                
                if(autoSelectName) {
                    Array.from(selectDesa.options).forEach(opt => {
                        if (opt.text === autoSelectName) opt.selected = true;
                    });
                    setDesa(selectDesa);
                }
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
        }
    }
    
    // Trigger bpjs toggle on load
    document.addEventListener("DOMContentLoaded", function() {
        toggleBpjs();
    });
</script>
@endsection



