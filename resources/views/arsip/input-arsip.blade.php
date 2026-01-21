<x-layout>
    <div x-data="{
        formStep: 1,
        isiBerkas: [],
        newIsi: '',
        newTahun: '',
        newTanggal: '',
        newJumlah: 1,
        newNoBox: '',
        newHakAkses: '', 
        newMedia: 'Kertas',
        newMasaSimpan: '',
        newTindakan: 'Musnah',
        addIsi() {
            if (this.newIsi.trim() !== '') {
                this.isiBerkas.push({
                    isi: this.newIsi.trim(),
                    tahun: this.newTahun,
                    tanggal: this.newTanggal,
                    jumlah: this.newJumlah,
                    no_box: this.newNoBox,
                    hak_akses: this.newHakAkses,
                    jenis_media: this.newMedia,
                    masa_simpan: this.newMasaSimpan,
                    tindakan_akhir: this.newTindakan
                });
                this.newIsi = '';
                // Optional resets
                // this.newTahun = ''; 
                // this.newTanggal = '';
                this.newJumlah = 1;
                // this.newNoBox = '';
                // this.newHakAkses = '';
                // this.newMasaSimpan = '';
            }
        },
        removeIsi(index) {
            this.isiBerkas.splice(index, 1);
        },
        validateStep1() {
            // Simple validation check before next
            const unit = document.querySelector('[name=unit_pengolah]').value;
            const klasifikasi = document.querySelector('[name=klasifikasi_id]').value;
            const nama = document.querySelector('[name=nama_berkas]').value;
            
            if (!unit || !klasifikasi || !nama) {
                alert('Mohon lengkapi Unit, Klasifikasi, dan Nama Berkas terlebih dahulu.');
                return;
            }
            this.formStep = 2;
        },
        updateDefaults(data) {
            this.newHakAkses = data.hak_akses || '';
            this.newMasaSimpan = data.masa_simpan || '';
            this.newTindakan = data.tindakan || 'Musnah';
        }
    }" @classification-selected="updateDefaults($event.detail)">
        <div class="bg-red-800 text-white p-6 rounded-t-2xl shadow-lg border-b-2 border-red-900 flex justify-between items-center">
            <h2 class="text-2xl font-bold italic tracking-wide">Input Daftar Arsip</h2>
            <div class="text-sm font-medium bg-red-900/50 px-4 py-2 rounded-lg">
                Langkah <span x-text="formStep"></span> dari 2
            </div>
        </div>

        <div class="bg-red-50 p-6 md:p-10 rounded-b-2xl shadow-inner border border-gray-100">
            <div class="bg-white p-6 md:p-12 rounded-[3.5rem] shadow-xl max-w-6xl mx-auto min-h-[500px]">
                <form action="/input-arsip" method="POST" class="space-y-8">
                    @csrf
                    
                    {{-- STEP 1 --}}
                    <div x-show="formStep === 1" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-[-20px]" x-transition:enter-end="opacity-100 translate-x-0">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-16 gap-y-8">
                            
                            {{-- Unit Pengolah --}}
                            <div class="group">
                                <label class="block font-bold text-gray-700 mb-2 transition group-focus-within:text-red-700">Unit Pengolah</label>
                                <select name="unit_pengolah" class="w-full p-4 border border-red-100 rounded-2xl bg-red-50/10 focus:ring-1 focus:ring-red-500 outline-none transition shadow-sm appearance-none cursor-pointer">
                                    <option value="" disabled selected>Pilih Unit Asal</option>
                                    <option value="Sistem Manajemen">Sistem Manajemen</option>
                                    <option value="Internal Audit">Internal Audit</option>
                                    <option value="Komunikasi & Kesekretariatan">Komunikasi & Kesekretariatan</option>
                                    <option value="CSR">CSR</option>
                                    <option value="Hukum">Hukum</option>
                                    <option value="Keamanan">Keamanan</option>
                                    <option value="Staf Dept. Komunikasi & Hukum Perusahaan">Staf Dept. Komunikasi & Hukum Perusahaan</option>
                                    <option value="Bisnis Inkubasi Non Semen">Bisnis Inkubasi Non Semen</option>
                                    <option value="Quality Assurance">Quality Assurance</option>
                                    <option value="SHE">SHE</option>
                                    <option value="Perencanaan & Evaluasi Produksi">Perencanaan & Evaluasi Produksi</option>
                                    <option value="Penunjang Produksi">Penunjang Produksi</option>
                                    <option value="Quality Control">Quality Control</option>
                                    <option value="Staf AFR">Staf AFR</option>
                                    <option value="Operasi Tambang">Operasi Tambang</option>
                                    <option value="Produksi Bahan Baku">Produksi Bahan Baku</option>
                                    <option value="Perencanaan & Pengawasan Tambang">Perencanaan & Pengawasan Tambang</option>
                                    <option value="WHRPG & Utilitas">WHRPG & Utilitas</option>
                                    <option value="Produksi Terak">Produksi Terak</option>
                                    <option value="Produksi Semen">Produksi Semen</option>
                                    <option value="Pabrik Kantong">Pabrik Kantong</option>
                                    <option value="Pabrik Dumai">Pabrik Dumai</option>
                                    <option value="Pemeliharaan Mesin">Pemeliharaan Mesin</option>
                                    <option value="Pemeliharaan Listrik & Instrumen">Pemeliharaan Listrik & Instrumen</option>
                                    <option value="Maintenance Reliability">Maintenance Reliability</option>
                                    <option value="Capex">Capex</option>
                                    <option value="Site Engineering">Site Engineering</option>
                                    <option value="Project Management">Project Management</option>
                                    <option value="Perencanaan Suku Cadang">Perencanaan Suku Cadang</option>
                                    <option value="TPM Officer">TPM Officer</option>
                                    <option value="Produksi Mesin & Teknikal Support">Produksi Mesin & Teknikal Support</option>
                                    <option value="Produksi BIP & Aplikasi">Produksi BIP & Aplikasi</option>
                                    <option value="Operasional SDM">Operasional SDM</option>
                                    <option value="Sarana Umum">Sarana Umum</option>
                                    <option value="GRC & Internal Control">GRC & Internal Control</option>
                                    <option value="Kinerja & Anggaran">Kinerja & Anggaran</option>
                                    <option value="Keuangan">Keuangan</option>
                                    <option value="Akuntansi">Akuntansi</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>

                            {{-- Kode Klasifikasi --}}
                             <div x-data="{
                                open: false,
                                step: 1, // Start directly at step 1 since types are merged
                                breadcrumbs: [],
                                options: [],
                                loading: false,
                                selectedItem: null,
                                displayText: 'Pilih Kode Klasifikasi',
                                selectedJraType: null,

                                init() {
                                    this.fetchOptions(1);
                                },
                                
                                toggle() {
                                    this.open = !this.open;
                                    if(this.open && this.options.length === 0) {
                                        this.fetchOptions(1);
                                    }
                                },

                                fetchOptions(level, parent = null) {
                                    this.loading = true;
                                    let url = `/api/klasifikasi-options?level=${level}&parent=${parent}`;
                                    
                                    fetch(url)
                                        .then(res => res.json())
                                        .then(data => {
                                            this.options = data;
                                            this.loading = false;
                                        });
                                },

                                selectOption(opt) {
                                    if (this.step === 1) {
                                        // Selected Pokok Masalah
                                        this.breadcrumbs.push({ level: 1, label: opt.label, value: opt.code });
                                        this.step = 2;
                                        this.fetchOptions(2, opt.code);
                                    } else if (this.step === 2) {
                                        // Selected Sub Masalah
                                        this.breadcrumbs.push({ level: 2, label: opt.label, value: opt.code });
                                        this.step = 3;
                                        this.fetchOptions(3, opt.code);
                                    } else if (this.step === 3) {
                                        // Selected Final Item
                                        this.selectedItem = opt;
                                        this.displayText = opt.label;
                                        
                                        // Fill hidden inputs
                                        document.querySelector('[name=klasifikasi_id]').value = opt.id;
                                        
                                        // Update Step 2 Autos (Display)
                                        document.querySelector('#display_masa_simpan').innerText = opt.masa_simpan;
                                        document.querySelector('#display_tindakan').innerText = opt.tindakan_akhir;
                                        document.querySelector('#display_hak_akses').innerText = opt.hak_akses || '-';
                                        
                                        // Set hidden value for Hak Akses to be submitted
                                        document.querySelector('[name=hak_akses]').value = opt.hak_akses || '-';

                                        // Dispatch event to update parent state
                                        this.$dispatch('classification-selected', { 
                                            hak_akses: opt.hak_akses, 
                                            masa_simpan: opt.masa_simpan, 
                                            tindakan: opt.tindakan_akhir 
                                        });

                                        this.open = false;
                                    }
                                },

                                reset() {
                                    this.step = 1;
                                    this.breadcrumbs = [];
                                    this.selectedItem = null;
                                    this.displayText = 'Pilih Kode Klasifikasi';
                                    document.querySelector('[name=klasifikasi_id]').value = '';
                                    document.querySelector('[name=hak_akses]').value = '';
                                    this.fetchOptions(1);
                                    this.open = false; 
                                },
                                
                                goBack() {
                                    if (this.step > 1) {
                                        this.step--;
                                        this.breadcrumbs.pop();
                                        const parent = this.breadcrumbs.length > 0 ? this.breadcrumbs[this.breadcrumbs.length - 1].value : null;
                                        this.fetchOptions(this.step, parent);
                                    }
                                }
                            }" class="relative group">
                                <label class="block font-bold text-gray-700 mb-2">Kode Klasifikasi</label>
                                <input type="hidden" name="klasifikasi_id" required>
                                
                                {{-- Trigger --}}
                                <div @click="toggle()" class="w-full p-4 border border-red-100 rounded-2xl bg-red-50/10 focus:ring-1 focus:ring-red-500 cursor-pointer flex justify-between items-center shadow-sm">
                                    <span x-text="displayText" :class="{'text-gray-500': !selectedItem, 'text-gray-900 font-medium': selectedItem}"></span>
                                    <svg class="w-5 h-5 text-red-300 transition" :class="{'rotate-180': open, 'text-red-500': open}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>

                                {{-- Dropdown --}}
                                <div x-show="open" @click.away="open = false" 
                                     class="absolute z-50 w-full mt-2 bg-white border border-red-100 rounded-2xl shadow-xl max-h-80 overflow-y-auto"
                                     style="display: none;">
                                    
                                    {{-- Header --}}
                                    <div class="px-5 py-3 bg-red-50/50 border-b border-red-100 flex items-center gap-3 sticky top-0 backdrop-blur-sm">
                                        <template x-if="step > 1">
                                            <button type="button" @click.stop="goBack()" class="p-1 hover:bg-red-100 rounded-full text-red-600">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                                            </button>
                                        </template>
                                        <span class="text-xs font-bold text-red-800 tracking-wider uppercase" 
                                              x-text="step === 1 ? 'Pilih Pokok Masalah' : (step === 2 ? 'Pilih Sub Masalah' : 'Pilih Jenis Arsip')">
                                        </span>
                                    </div>

                                    <ul x-show="!loading" class="py-2">
                                        <template x-for="opt in options" :key="step === 3 ? opt.id : opt.code">
                                            <li @click="selectOption(opt)" 
                                                class="px-5 py-3 hover:bg-red-50 cursor-pointer text-sm text-gray-700 flex justify-between items-center group">
                                                <span x-text="opt.label"></span>
                                                <svg class="w-4 h-4 text-gray-300 opacity-0 group-hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                            </li>
                                        </template>
                                        <template x-if="options.length === 0 && !loading">
                                            <li class="px-5 py-4 text-gray-400 italic text-center">Data tidak ditemukan</li>
                                        </template>
                                    </ul>
                                </div>
                            </div>

                            {{-- No Berkas (Readonly) --}}
                            <div class="group">
                                <label class="block font-bold text-gray-700 mb-2">No Berkas</label>
                                <input type="text" placeholder="Dibuat Otomatis (Format: 1)" disabled
                                    class="w-full p-4 border border-gray-100 rounded-2xl bg-gray-100 text-gray-500 cursor-not-allowed italic">
                                <p class="text-xs text-gray-400 mt-1">*Penomoran otomatis melanjutkan urutan terakhir</p>
                            </div>

                            {{-- Nama Berkas --}}
                            <div class="group">
                                <label class="block font-bold text-gray-700 mb-2 transition group-focus-within:text-red-700">Nama Berkas</label>
                                <input type="text" name="nama_berkas" placeholder="Nama dokumen atau berkas" 
                                    class="w-full p-4 border border-red-100 rounded-2xl bg-red-50/10 focus:ring-1 focus:ring-red-500 outline-none transition shadow-sm">
                            </div>

                        </div>
                        
                        <div class="text-right mt-10">
                            <button type="button" @click="validateStep1()" class="bg-red-800 text-white px-10 py-3 rounded-xl font-bold hover:bg-red-900 transition shadow-lg flex items-center gap-2 ml-auto">
                                Selanjutnya
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </button>
                        </div>
                    </div>

                    {{-- STEP 2 --}}
                    <div x-show="formStep === 2" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-[20px]" x-transition:enter-end="opacity-100 translate-x-0">
                        
                        {{-- Info Panel (Auto Fields) --}}
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 p-6 bg-red-50/50 rounded-2xl border border-red-100">
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase tracking-widest">Hak Akses</label>
                                <p id="display_hak_akses" class="text-lg font-bold text-red-800 mt-1">-</p>
                                <input type="hidden" name="hak_akses" required>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase tracking-widest">Masa Simpan</label>
                                <p id="display_masa_simpan" class="text-lg font-bold text-gray-800 mt-1">-</p>
                            </div>
                            <div>
                                <label class="text-xs font-bold text-gray-400 uppercase tracking-widest">Tindakan Akhir</label>
                                <p id="display_tindakan" class="text-lg font-bold text-gray-800 mt-1">-</p>
                            </div>
                        </div>

                        {{-- Inputs removed: No Box & Media moved to Isi Berkas --}}

                        {{-- Isi Berkas Section --}}
                        <div class="mb-10 border-t border-gray-100 pt-8">
                            <h3 class="text-xl font-bold text-gray-800 mb-4">Daftar Isi Berkas</h3>
                            
                            <div class="bg-red-50/50 p-6 rounded-2xl border border-red-100 mb-6">
                                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                                    <div class="md:col-span-12 space-y-2">
                                        <label class="text-xs font-bold text-gray-500 uppercase">Isi Berkas</label>
                                        <input type="text" x-model="newIsi" placeholder="Deskripsi dokumen..." 
                                            class="w-full p-3 border border-red-100 rounded-xl bg-white focus:ring-1 focus:ring-red-500 outline-none">
                                    </div>
                                    
                                    {{-- Row 2 --}}
                                    <div class="md:col-span-3 space-y-2">
                                        <label class="text-xs font-bold text-gray-500 uppercase">Jenis Arsip</label>
                                        <select x-model="newMedia" class="w-full p-3 border border-red-100 rounded-xl bg-white focus:ring-1 focus:ring-red-500 outline-none">
                                            <option value="Kertas">Kertas</option>
                                            <option value="Foto">Foto</option>
                                            <option value="Kartografi">Kartografi</option>
                                        </select>
                                    </div>
                                    <div class="md:col-span-2 space-y-2">
                                        <label class="text-xs font-bold text-gray-500 uppercase">No. Box</label>
                                        <input type="text" x-model="newNoBox" placeholder="Box 1" 
                                            class="w-full p-3 border border-red-100 rounded-xl bg-white focus:ring-1 focus:ring-red-500 outline-none">
                                    </div>
                                    <div class="md:col-span-2 space-y-2">
                                        <label class="text-xs font-bold text-gray-500 uppercase">Tahun</label>
                                        <input type="number" x-model="newTahun" placeholder="YYYY" 
                                            class="w-full p-3 border border-red-100 rounded-xl bg-white focus:ring-1 focus:ring-red-500 outline-none">
                                    </div>
                                    <div class="md:col-span-3 space-y-2">
                                        <label class="text-xs font-bold text-gray-500 uppercase">Tanggal</label>
                                        <input type="date" x-model="newTanggal" 
                                            class="w-full p-3 border border-red-100 rounded-xl bg-white focus:ring-1 focus:ring-red-500 outline-none">
                                    </div>
                                    <div class="md:col-span-1 space-y-2">
                                        <label class="text-xs font-bold text-gray-500 uppercase">Jumlah</label>
                                        <input type="number" x-model="newJumlah" placeholder="1" min="1"
                                            class="w-full p-3 border border-red-100 rounded-xl bg-white focus:ring-1 focus:ring-red-500 outline-none text-center">
                                    </div>

                                    <div class="md:col-span-1">
                                        <button type="button" @click="addIsi()" 
                                            class="w-full bg-red-800 text-white p-3 rounded-xl font-bold hover:bg-red-900 transition flex justify-center items-center">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            {{-- List Preview (Table) --}}
                            <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-sm">
                                <table class="w-full text-sm text-center">
                                    <thead class="bg-gray-100 text-gray-600 font-bold uppercase text-xs">
                                        <tr>
                                            <th class="px-4 py-3 w-10">No</th>
                                            <th class="px-4 py-3 text-left">Isi Berkas</th>
                                            <th class="px-4 py-3">Jenis Arsip</th>
                                            <th class="px-4 py-3">No. Box</th>
                                            <th class="px-4 py-3">Tahun</th>
                                            <th class="px-4 py-3">Tanggal</th>
                                            <th class="px-4 py-3">Jumlah</th>
                                            <th class="px-4 py-3">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100 bg-white">
                                        <template x-for="(item, index) in isiBerkas" :key="index">
                                                <tr class="hover:bg-gray-50">
                                                <td class="px-4 py-3 font-medium text-gray-900" x-text="index + 1"></td>
                                                <td class="px-4 py-3 text-gray-700 text-left" x-text="item.isi"></td>
                                                <td class="px-4 py-3 text-gray-600" x-text="item.jenis_media"></td>
                                                <td class="px-4 py-3 text-gray-600" x-text="item.no_box"></td>
                                                <td class="px-4 py-3 text-gray-600" x-text="item.tahun"></td>
                                                <td class="px-4 py-3 text-gray-600" x-text="item.tanggal"></td>
                                                <td class="px-4 py-3 text-gray-600" x-text="item.jumlah"></td>
                                                <td class="px-4 py-3">
                                                    <button type="button" @click="removeIsi(index)" class="text-red-400 hover:text-red-600 transition">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </button>
                                                    {{-- Hidden Inputs --}}
                                                    <input type="hidden" :name="`isi_berkas[${index}][isi]`" :value="item.isi">
                                                    <input type="hidden" :name="`isi_berkas[${index}][tahun]`" :value="item.tahun">
                                                    <input type="hidden" :name="`isi_berkas[${index}][tanggal]`" :value="item.tanggal">
                                                    <input type="hidden" :name="`isi_berkas[${index}][jumlah]`" :value="item.jumlah">
                                                    <input type="hidden" :name="`isi_berkas[${index}][no_box]`" :value="item.no_box">
                                                    <input type="hidden" :name="`isi_berkas[${index}][hak_akses]`" :value="item.hak_akses">
                                                    <input type="hidden" :name="`isi_berkas[${index}][jenis_media]`" :value="item.jenis_media">
                                                    <input type="hidden" :name="`isi_berkas[${index}][masa_simpan]`" :value="item.masa_simpan">
                                                    <input type="hidden" :name="`isi_berkas[${index}][tindakan_akhir]`" :value="item.tindakan_akhir">
                                                </td>
                                            </tr>
                                        </template>
                                        <tr x-show="isiBerkas.length === 0">
                                            <td colspan="8" class="px-4 py-8 text-center text-gray-400 italic">
                                                Belum ada rincian berkas yang ditambahkan
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="flex justify-between md:justify-end gap-4 pt-4 border-t border-gray-100">
                             <button type="button" @click="formStep = 1" class="text-gray-500 font-bold px-8 py-3 hover:text-red-800 transition">
                                Kembali
                            </button>
                            <button type="submit" 
                                :disabled="isiBerkas.length === 0"
                                :class="{'opacity-50 cursor-not-allowed': isiBerkas.length === 0}"
                                class="bg-red-800 text-white px-14 py-4 rounded-xl font-bold text-lg shadow-lg hover:bg-red-900 transition flex items-center gap-3">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                SUBMIT
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</x-layout>