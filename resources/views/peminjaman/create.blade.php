<x-layout>
    <div class="bg-gradient-to-r from-red-900 to-red-800 px-6 py-5 rounded-lg shadow-lg mb-6 flex items-center justify-between relative overflow-hidden">
        <div class="relative z-10">
            <h1 class="text-2xl font-bold text-white tracking-wide">Form Peminjaman Baru</h1>
            <p class="text-red-100 text-sm mt-1 opacity-90">Isi data peminjaman arsip dengan lengkap.</p>
        </div>
        <div class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 rounded-full bg-white opacity-5 blur-2xl"></div>
    </div>

    <div class="flex justify-center items-start min-h-[80vh]">
        <div class="bg-white rounded-xl shadow-md border border-gray-200 p-8 w-full max-w-4xl relative">
            
            <form action="/peminjaman" method="POST" enctype="multipart/form-data" x-data="{ selectedJabatan: '' }">
                @csrf
                <div class="space-y-6">

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 items-center">
                        <label class="text-sm font-semibold text-gray-700">Tanggal Peminjaman <span class="text-red-600">*</span></label>
                        <div class="lg:col-span-2">
                            <input type="date" name="tanggal" required class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-800 focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 items-center">
                        <label class="text-sm font-semibold text-gray-700">Nama Peminjam <span class="text-red-600">*</span></label>
                        <div class="lg:col-span-2">
                            <input type="text" name="nama_peminjam" placeholder="Masukkan nama lengkap..." required class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-800 focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 items-center">
                        <label class="text-sm font-semibold text-gray-700">NIP <span class="text-red-600">*</span></label>
                        <div class="lg:col-span-2">
                            <input type="text" name="nip" placeholder="Nomor Induk Pegawai..." required inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-800 focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 items-start">
                        <label class="text-sm font-semibold text-gray-700 pt-2">Jabatan <span class="text-red-600">*</span></label>
                        <div class="lg:col-span-2">
                            <select name="jabatan_peminjam" x-model="selectedJabatan" required class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-800 bg-white focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition">
                                <option value="" disabled selected>-- Pilih Jabatan / Role --</option>
                                <option value="Direksi">Direksi (BOD)</option>
                                <option value="Band I">Band I (Kepala Departemen)</option>
                                <option value="Band II">Band II (Kepala Unit)</option>
                                <option value="Band III">Band III (Kepala Seksi)</option>
                                <option value="Band IV">Band IV (Supervisor/Officer)</option>
                                <option value="Pelaksana">Staf / Karyawan / Arsiparis</option>
                                <option value="Auditor">Internal Audit</option>
                                <option value="Legal">Unit Hukum</option>
                            </select>
                            <p class="text-xs text-gray-500 mt-1">Pilih jabatan untuk melihat arsip yang sesuai hak akses.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 items-center">
                        <label class="text-sm font-semibold text-gray-700">Unit Peminjam <span class="text-red-600">*</span></label>
                        <div class="lg:col-span-2">
                            <input type="text" name="unit" placeholder="Contoh: Unit SDM & Umum..." required class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-800 focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 items-start" x-data="{ jenis: '' }">
                        <label class="text-sm font-semibold text-gray-700 pt-2">Jenis Dokumen <span class="text-red-600">*</span></label>
                        <div class="lg:col-span-2 space-y-3">
                            <select name="jenis_dokumen_utama" x-model="jenis" required class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-800 bg-white focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition">
                                <option value="" disabled selected>-- Pilih Media --</option>
                                <option value="Softfile">Softfile</option>
                                <option value="Hardfile">Hardfile</option>
                            </select>

                            <div x-show="jenis == 'Hardfile'" x-transition class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                <label class="block text-xs font-bold text-gray-600 mb-2 uppercase tracking-wide">Detail Fisik Arsip:</label>
                                <select name="detail_fisik" class="w-full border border-gray-300 rounded-lg p-2 text-sm text-gray-700 focus:ring-2 focus:ring-red-500 outline-none">
                                    <option value="Berkas Asli">Berkas Asli</option>
                                    <option value="Berkas Copy">Berkas Copy</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div x-data="{ inputs: [1] }" class="grid grid-cols-1 lg:grid-cols-3 gap-4 items-start border-t border-gray-100 pt-6">
                        <div class="flex justify-between items-center lg:block">
                            <label class="text-sm font-semibold text-gray-700">Cari Arsip <span class="text-red-600">*</span></label>
                        </div>
                        <div class="lg:col-span-2 space-y-3">
                            <div class="flex justify-end mb-2">
                                <button type="button" @click="inputs.push(inputs.length + 1)" class="bg-red-50 text-red-700 text-xs font-bold px-3 py-1.5 rounded-md hover:bg-red-100 border border-red-100 flex items-center gap-1 transition">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                    Tambah Arsip Lain
                                </button>
                            </div>
                            <template x-for="(input, index) in inputs" :key="index">
                                <div class="flex gap-2 items-start relative z-10" :style="'z-index: ' + (50 - index)">
                                    <div x-data="searchableSelect()" class="relative w-full">
                                        <input type="hidden" name="arsip_id[]" :value="selectedId" required>
                                        <div class="relative">
                                            <input type="text" x-model="search" @click="open = true" @click.outside="open = false" 
                                                placeholder="Ketik nama / nomor arsip..." 
                                                class="w-full border border-gray-300 rounded-lg p-2.5 text-sm text-gray-800 focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition bg-white shadow-sm" 
                                                autocomplete="off">
                                            <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-gray-400">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                            </div>
                                        </div>
                                        <div x-show="open" class="absolute z-50 w-full bg-white border border-gray-200 mt-1 rounded-lg shadow-xl max-h-60 overflow-y-auto">
                                            <template x-if="filteredOptions.length > 0">
                                                <ul>
                                                    <template x-for="option in filteredOptions" :key="option.id">
                                                        <li @click="selectOption(option)" class="px-4 py-3 hover:bg-red-50 cursor-pointer text-sm text-gray-700 border-b border-gray-100 last:border-0 transition">
                                                            <div class="flex justify-between items-center mb-1">
                                                                <span class="font-bold text-gray-800" x-text="option.nama_berkas"></span>
                                                                <span class="text-[10px] px-2 py-0.5 rounded font-bold border" 
                                                                    :class="{
                                                                        'bg-red-50 text-red-700 border-red-100': option.klasifikasi_keamanan == 'Rahasia',
                                                                        'bg-orange-50 text-orange-700 border-orange-100': option.klasifikasi_keamanan == 'Terbatas',
                                                                        'bg-green-50 text-green-700 border-green-100': option.klasifikasi_keamanan == 'Biasa' || !option.klasifikasi_keamanan
                                                                    }"
                                                                    x-text="option.klasifikasi_keamanan || 'Biasa'"></span>
                                                            </div>
                                                            <span class="text-xs text-gray-500 font-mono" x-text="'No: ' + option.no_berkas"></span>
                                                        </li>
                                                    </template>
                                                </ul>
                                            </template>
                                            <div x-show="filteredOptions.length === 0" class="p-4 text-sm text-gray-500 text-center italic">
                                                <span x-show="!selectedJabatan">Pilih Jabatan terlebih dahulu.</span>
                                                <span x-show="selectedJabatan">Tidak ada arsip yang sesuai akses.</span>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" x-show="inputs.length > 1" @click="inputs.splice(index, 1)" class="text-red-500 hover:text-red-700 p-2.5 bg-red-50 rounded-lg hover:bg-red-100 transition border border-red-100">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </template>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 items-start border-t border-gray-100 pt-6">
                        <label class="text-sm font-semibold text-gray-700 pt-2">Bukti Peminjaman <span class="text-red-600">*</span></label>
                        <div class="lg:col-span-2">
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 flex flex-col items-center justify-center bg-gray-50 hover:bg-gray-100 transition relative cursor-pointer group">
                                <input type="file" name="bukti_pinjam" accept=".png, .jpg, .jpeg" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" onchange="previewImage(event)">
                                <div id="upload-placeholder" class="text-center">
                                    <svg class="w-10 h-10 text-gray-400 mx-auto mb-2 group-hover:text-red-600 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <p class="text-sm text-gray-600 font-medium group-hover:text-red-700">Klik untuk upload bukti</p>
                                    <p class="text-xs text-gray-400 mt-1">Format: JPG/PNG, Max: 2MB</p>
                                </div>
                                <img id="image-preview" src="#" alt="Preview" class="hidden max-h-48 rounded-lg shadow-sm mt-2 z-20 relative pointer-events-none">
                            </div>
                        </div>
                    </div>

                </div>

                <div class="mt-10 flex justify-end gap-3 pt-6 border-t border-gray-100">
                    <a href="/peminjaman" class="px-6 py-2.5 bg-white text-gray-700 border border-gray-300 rounded-lg text-sm font-bold hover:bg-gray-50 transition">Batal</a>
                    <button type="submit" class="px-8 py-2.5 bg-red-900 text-white rounded-lg text-sm font-bold shadow-md hover:bg-red-800 transition transform hover:scale-105">
                        Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function previewImage(event) {
            const input = event.target;
            const placeholder = document.getElementById('upload-placeholder');
            const preview = document.getElementById('image-preview');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        window.arsipOptions = @json($daftarArsip ?? []);

        document.addEventListener('alpine:init', () => {
            Alpine.data('searchableSelect', (initialId = null) => ({
                open: false, 
                search: '', 
                selectedId: initialId || '', 
                options: window.arsipOptions,
                
                init() {
                    if (this.selectedId) {
                        const found = this.options.find(o => o.id == this.selectedId);
                        if (found) this.search = found.nama_berkas;
                    }
                },

                get filteredOptions() {
                    const currentJabatan = this.selectedJabatan; 

                    return this.options.filter(option => {
                        const nama = option.nama_berkas ? option.nama_berkas.toLowerCase() : '';
                        const no = option.no_berkas ? option.no_berkas.toLowerCase() : '';
                        const keyword = this.search.toLowerCase();
                        const matchesKeyword = nama.includes(keyword) || no.includes(keyword);

                        let isAllowed = false;
                        const level = option.klasifikasi_keamanan || 'Biasa/Terbuka';

                        if (!currentJabatan) return false;

                        if (['Direksi', 'Auditor', 'Legal'].includes(currentJabatan)) {
                            isAllowed = true;
                        } 
                        else if (['Band I', 'Band II', 'Band III', 'Band IV'].includes(currentJabatan)) {
                            if (level !== 'Rahasia') isAllowed = true;
                        } 
                        else {
                            if (level === 'Biasa/Terbuka') isAllowed = true;
                        }

                        return matchesKeyword && isAllowed;
                    });
                },

                selectOption(option) {
                    this.selectedId = option.id;
                    this.search = option.nama_berkas;
                    this.open = false;
                }
            }))
        })
    </script>
</x-layout>