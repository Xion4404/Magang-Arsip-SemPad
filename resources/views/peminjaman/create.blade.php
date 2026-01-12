<x-layout>
    <div class="bg-gradient-to-r from-red-900 to-red-700 px-8 py-4 shadow-md rounded-t-lg -mx-4 -mt-4 md:-mx-6 md:-mt-6 mb-6">
        <h1 class="text-xl font-bold text-white">Form Tambahkan Peminjam</h1>
    </div>

    <div class="flex justify-center items-start min-h-[80vh]">
        <div class="bg-white rounded-2xl shadow-xl p-8 w-full max-w-4xl border border-gray-100 relative">
            
            <form action="/peminjaman" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="space-y-6">

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                        <label class="font-medium text-gray-700 text-lg">Tanggal Peminjaman :</label>
                        <div class="md:col-span-2">
                            <input type="date" name="tanggal" required class="w-full border-2 border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none font-semibold text-gray-700">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                        <label class="font-medium text-gray-700 text-lg">Nama Peminjam :</label>
                        <div class="md:col-span-2">
                            <input type="text" name="nama_peminjam" placeholder="Masukkan nama lengkap..." required class="w-full border-2 border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none font-semibold text-gray-700">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
    <label class="font-medium text-gray-700 text-lg">NIP :</label>
    <div class="md:col-span-2">
        <input 
            type="text" 
            name="nip" 
            placeholder="Masukkan Nomor Induk Pegawai..." 
            required 
            inputmode="numeric" 
            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
            class="w-full border-2 border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none font-semibold text-gray-700"
        >
    </div>
</div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                        <label class="font-medium text-gray-700 text-lg">Unit Peminjam :</label>
                        <div class="md:col-span-2">
                            <input type="text" name="unit" placeholder="Contoh: Unit SDM & Umum..." required class="w-full border-2 border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none font-semibold text-gray-700">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                        <label class="font-medium text-gray-700 text-lg">Jenis Dokumen :</label>
                        <div class="md:col-span-2">
                            <select name="jenis_dokumen" required class="w-full border-2 border-gray-300 rounded-lg p-2.5 focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none font-bold text-gray-700 bg-white">
                                <option value="" disabled selected>-- Pilih Jenis Dokumen --</option>
                                <option value="Berkas Digital">Berkas Digital</option>
                                <option value="Berkas Fisik">Berkas Fisik</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-start">
                        <label class="font-medium text-gray-700 text-lg pt-2">Bukti Bon Peminjaman :</label>
                        <div class="md:col-span-2">
                            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 flex flex-col items-center justify-center bg-gray-50 hover:bg-gray-100 transition relative cursor-pointer group">
                                <input type="file" name="bukti_pinjam" accept=".png, .jpg, .jpeg" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" onchange="previewImage(event)">
                                
                                <div id="upload-placeholder" class="text-center">
                                    <svg class="w-10 h-10 text-gray-400 mx-auto mb-2 group-hover:text-red-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <p class="text-sm text-gray-500 font-semibold">Klik untuk upload bukti (PNG/JPG)</p>
                                    <p class="text-xs text-gray-400 mt-1">Maksimal 2MB</p>
                                </div>

                                <img id="image-preview" src="#" alt="Preview" class="hidden max-h-48 rounded-lg shadow-md mt-2 z-20 relative pointer-events-none">
                            </div>
                        </div>
                    </div>

                    <div x-data="{ inputs: [1] }" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-start">
                        <div class="flex justify-between items-center md:block">
                            <label class="font-medium text-gray-700 text-lg">Nama Arsip :</label>
                        </div>
                        
                        <div class="md:col-span-2 space-y-3">
                            <div class="flex justify-end mb-2">
                                <button type="button" @click="inputs.push(inputs.length + 1)" class="bg-red-800 text-white text-xs px-3 py-1.5 rounded-md hover:bg-red-900 flex items-center gap-1 shadow-sm transition">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                    Tambah Arsip
                                </button>
                            </div>

                            <template x-for="(input, index) in inputs" :key="index">
                                <div class="flex gap-2 items-start relative z-10" :style="'z-index: ' + (50 - index)">
                                    
                                    <div x-data="searchableSelect()" class="relative w-full">
                                        <input type="hidden" name="arsip_id[]" :value="selectedId" required>
                                        <div class="relative">
                                            <input type="text" x-model="search" @click="open = true" @click.outside="open = false" placeholder="Ketik untuk mencari arsip..." class="w-full border-2 border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none font-bold text-gray-700 bg-white shadow-sm" autocomplete="off">
                                            <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none"><svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg></div>
                                        </div>
                                        <div x-show="open" class="absolute z-50 w-full bg-white border border-gray-200 mt-1 rounded-lg shadow-xl max-h-60 overflow-y-auto" style="display: none;">
                                            <template x-if="filteredOptions.length > 0">
                                                <ul>
                                                    <template x-for="option in filteredOptions" :key="option.id">
                                                        <li @click="selectOption(option)" class="px-4 py-2 hover:bg-red-50 cursor-pointer text-sm text-gray-700 border-b border-gray-100 last:border-0">
                                                            <span class="font-bold block" x-text="option.nama_berkas"></span>
                                                            <span class="text-xs text-gray-500" x-text="'No: ' + option.no_berkas"></span>
                                                        </li>
                                                    </template>
                                                </ul>
                                            </template>
                                            <div x-show="filteredOptions.length === 0" class="p-3 text-sm text-gray-500 text-center">Tidak ada arsip ditemukan.</div>
                                        </div>
                                    </div>
                                    
                                    <button type="button" x-show="inputs.length > 1" @click="inputs.splice(index, 1)" class="text-red-500 hover:text-red-700 p-3 bg-red-50 rounded-lg hover:bg-red-100 transition">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </template>
                        </div>
                    </div>

                </div>

                <div class="mt-10 flex justify-end">
                    <button type="submit" class="bg-red-900 text-white px-8 py-2.5 rounded-lg font-bold shadow-lg hover:bg-red-800 transition transform hover:scale-105">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Preview Image Script
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

        // Data Arsip dari Backend
        window.arsipOptions = @json($daftarArsip);

        document.addEventListener('alpine:init', () => {
            Alpine.data('searchableSelect', (initialId = null) => ({
                open: false,
                search: '',
                selectedId: initialId || '',
                options: window.arsipOptions,
                
                init() {
                    if (this.selectedId) {
                        const found = this.options.find(o => o.id == this.selectedId);
                        if (found) {
                            this.search = found.nama_berkas;
                        }
                    }
                },

                get filteredOptions() {
                    if (this.search === '') return this.options;
                    return this.options.filter(option => {
                        const nama = option.nama_berkas ? option.nama_berkas.toLowerCase() : '';
                        const no = option.no_berkas ? option.no_berkas.toLowerCase() : '';
                        const keyword = this.search.toLowerCase();
                        return nama.includes(keyword) || no.includes(keyword);
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