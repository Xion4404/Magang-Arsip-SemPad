<x-layout>
    <div class="bg-red-800 text-white p-6 rounded-t-2xl shadow-lg border-b-2 border-red-900">
        <h2 class="text-2xl font-bold italic tracking-wide">Input daftar arsip</h2>
    </div>

    <div class="bg-red-50 p-10 rounded-b-2xl shadow-inner border border-gray-100">
        <div class="bg-white p-12 rounded-[3.5rem] shadow-xl max-w-6xl mx-auto">
            <form action="/input-arsip" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-x-16 gap-y-8">
                @csrf
                
                <div class="space-y-8">
                    {{-- No Berkas --}}
                    <div class="group">
                        <label class="block font-bold text-gray-700 mb-2 transition group-focus-within:text-red-700">No Berkas</label>
                        <input type="text" name="no_berkas" placeholder="Contoh : ARS-2025-001" 
                            class="w-full p-4 border border-red-100 rounded-2xl bg-red-50/10 focus:ring-1 focus:ring-red-500 outline-none transition shadow-sm">
                    </div>

                    {{-- Kode Klasifikasi (Hierarchical Single UI) --}}
                <div x-data="{
                    open: false,
                    step: 0, // 0: JRA Type, 1: Pokok Masalah, 2: Sub Masalah, 3: Jenis Arsip
                    breadcrumbs: [],
                    options: [],
                    loading: false,
                    selectedItem: null,
                    displayText: 'Pilih Kode Klasifikasi',
                    selectedJraType: null,

                    init() {
                        this.fetchOptions(0);
                    },
                    
                    toggle() {
                        this.open = !this.open;
                        if(this.open && this.step === 0 && this.options.length === 0) {
                            this.fetchOptions(0);
                        }
                    },

                    fetchOptions(level, parent = null) {
                        this.loading = true;
                        let url = `/api/klasifikasi-options?level=${level}&parent=${parent}`;
                        if (level === 1 && this.selectedJraType) {
                            url += `&jra_type=${this.selectedJraType}`;
                        }
                        
                        fetch(url)
                            .then(res => res.json())
                            .then(data => {
                                this.options = data;
                                this.loading = false;
                            });
                    },

                    selectOption(opt) {
                        if (this.step === 0) {
                            // Selected JRA Type
                            this.selectedJraType = opt.code;
                            this.breadcrumbs.push({ level: 0, label: opt.label, value: opt.code });
                            this.step = 1;
                            this.fetchOptions(1);
                        } else if (this.step === 1) {
                            // Selected Pokok Masalah (e.g., HK)
                            this.breadcrumbs.push({ level: 1, label: opt.label, value: opt.code });
                            this.step = 2;
                            this.fetchOptions(2, opt.code);
                        } else if (this.step === 2) {
                            // Selected Sub Masalah (e.g., HK.01)
                            this.breadcrumbs.push({ level: 2, label: opt.label, value: opt.code });
                            this.step = 3;
                            this.fetchOptions(3, opt.code);
                        } else if (this.step === 3) {
                            // Selected Final Item
                            this.selectedItem = opt;
                            this.displayText = opt.label;
                            
                            // Fill hidden input and other fields
                            document.querySelector('[name=klasifikasi_id]').value = opt.id;
                            document.querySelector('[name=masa_simpan_display]').value = opt.masa_simpan;
                            document.querySelector('[name=permanen_musnah_display]').value = opt.tindakan_akhir;

                            this.open = false;
                        }
                    },

                    reset() {
                        this.step = 0;
                        this.breadcrumbs = [];
                        this.selectedItem = null;
                        this.selectedJraType = null;
                        this.displayText = 'Pilih Kode Klasifikasi';
                        document.querySelector('[name=klasifikasi_id]').value = '';
                        document.querySelector('[name=masa_simpan_display]').value = '';
                        document.querySelector('[name=permanen_musnah_display]').value = '';
                        this.fetchOptions(0);
                        this.open = false; 
                    },
                    
                    goBack() {
                        if (this.step > 0) {
                            this.step--;
                            this.breadcrumbs.pop();
                            
                            if (this.step === 0) {
                                this.selectedJraType = null;
                                this.fetchOptions(0);
                            } else {
                                const parent = this.breadcrumbs.length > 0 ? this.breadcrumbs[this.breadcrumbs.length - 1].value : null;
                                this.fetchOptions(this.step, parent);
                            }
                        }
                    }
                }" class="mb-4 relative group">
                    <label class="block font-bold text-gray-700 mb-2 transition group-focus-within:text-red-700">Kode Klasifikasi</label>
                    <input type="hidden" name="klasifikasi_id" required>

                    {{-- Trigger Button --}}
                    <div @click="toggle()" class="w-full p-4 border border-red-100 rounded-2xl bg-red-50/10 focus:ring-1 focus:ring-red-500 cursor-pointer flex justify-between items-center shadow-sm transition outline-none">
                        <span x-text="displayText" :class="{'text-gray-500': !selectedItem, 'text-gray-900 font-medium': selectedItem}"></span>
                        <svg class="w-5 h-5 text-red-300 transition-transform duration-300" :class="{'rotate-180': open, 'text-red-500': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>

                    {{-- Dropdown Body --}}
                    <div x-show="open" @click.away="open = false" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 translate-y-2"
                         class="absolute z-50 w-full mt-2 bg-white border border-red-100 rounded-2xl shadow-xl max-h-80 overflow-y-auto"
                         style="display: none;">
                        
                        {{-- Header / Breadcrumbs --}}
                        <div class="px-5 py-3 bg-red-50/50 border-b border-red-100 flex items-center gap-3 sticky top-0 backdrop-blur-sm">
                            <template x-if="step > 0">
                                <button type="button" @click.stop="goBack()" class="p-1 hover:bg-red-100 rounded-full text-red-600 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                                </button>
                            </template>
                            <span class="text-xs font-bold text-red-800 tracking-wider uppercase" 
                                  x-text="step === 0 ? 'Pilih Jenis JRA' : (step === 1 ? 'Pilih Pokok Masalah' : (step === 2 ? 'Pilih Sub Masalah' : 'Pilih Jenis Arsip'))">
                            </span>
                        </div>

                        {{-- Loading State --}}
                        <div x-show="loading" class="p-6 text-center text-sm text-gray-400 flex flex-col items-center gap-2">
                             <svg class="animate-spin h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                             <span>Memuat data...</span>
                        </div>

                        {{-- List Options --}}
                        <ul x-show="!loading" class="py-2">
                            <template x-for="opt in options" :key="step === 3 ? opt.id : opt.code">
                                <li @click="selectOption(opt)" 
                                    class="px-5 py-3 hover:bg-red-50 cursor-pointer text-sm text-gray-700 hover:text-red-700 transition-all border-b border-gray-50 last:border-0 flex items-center justify-between group-hover:pl-6">
                                    <span x-text="opt.label" class="font-medium"></span>
                                    <svg class="w-4 h-4 text-gray-300 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </li>
                            </template>
                            
                            <template x-if="options.length === 0 && !loading">
                                <li class="px-5 py-4 text-sm text-gray-400 italic text-center">Data tidak ditemukan</li>
                            </template>
                        </ul>
                    </div>
                </div>

                    {{-- Nama Berkas --}}
                    <div class="group">
                        <label class="block font-bold text-gray-700 mb-2 transition group-focus-within:text-red-700">Nama Berkas</label>
                        <input type="text" name="nama_berkas" placeholder="Nama dokumen atau berkas" 
                            class="w-full p-4 border border-red-100 rounded-2xl bg-red-50/10 focus:ring-1 focus:ring-red-500 outline-none transition shadow-sm">
                    </div>

                    {{-- Isi Berkas --}}
                    <div class="group">
                        <label class="block font-bold text-gray-700 mb-2 transition group-focus-within:text-red-700">Isi Berkas</label>
                        <textarea name="isi_berkas" placeholder="Deskripsi atau ringkasan isi berkas" rows="4" 
                            class="w-full p-4 border border-red-100 rounded-2xl bg-red-50/10 focus:ring-1 focus:ring-red-500 outline-none transition shadow-sm"></textarea>
                    </div>

                    {{-- Tahun Berkas--}}
                    <div class="group">
                        <label class="block font-bold text-gray-700 mb-2 transition group-focus-within:text-red-700">Tahun Berkas</label>
                        <input type="text" name="tahun" placeholder="2026" 
                            class="w-full p-4 border border-red-100 rounded-2xl bg-red-50/10 focus:ring-1 focus:ring-red-500 outline-none transition shadow-sm">
                    </div>
                </div>

                <div class="space-y-8 text-right md:text-left">
                    {{-- Tanggal Masuk Berkas--}}
                    <div class="group">
                        <label class="block font-bold text-gray-700 mb-2 transition group-focus-within:text-red-700">Tanggal Isi Berkas</label>
                        <input type="date" name="tanggal" 
                            class="w-full p-4 border border-red-100 rounded-2xl bg-red-50/10 focus:ring-1 focus:ring-red-500 outline-none transition shadow-sm text-center md:text-left">
                    </div>

                    {{-- Jumlah --}}
                    <div class="group">
                        <label class="block font-bold text-gray-700 mb-2 transition group-focus-within:text-red-700">Jumlah</label>
                        <input type="number" name="jumlah" placeholder="0" min="0" 
                            oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null"
                            onkeydown="return event.keyCode !== 69 && event.keyCode !== 189 && event.keyCode !== 109"
                            class="w-full p-4 border border-red-100 rounded-2xl bg-red-50/10 focus:ring-1 focus:ring-red-500 outline-none transition shadow-sm text-center md:text-left">
                    </div>

                    {{-- Masa Simpan --}}
                    <div class="group">
                        <label class="block font-bold text-gray-700 mb-2 transition group-focus-within:text-red-700">Masa Simpan</label>
                        <input type="text" name="masa_simpan_display" placeholder="Otomatis dari Klasifikasi" disabled 
                            class="w-full p-4 border border-gray-100 rounded-2xl bg-gray-100 text-gray-500 outline-none transition shadow-sm cursor-not-allowed">
                    </div>

                    {{-- Permanen/Musnah --}}
                    <div class="group">
                        <label class="block font-bold text-gray-700 mb-2 transition group-focus-within:text-red-700">Permanen/Musnah</label>
                        <input type="text" name="permanen_musnah_display" placeholder="Otomatis dari Klasifikasi" disabled 
                            class="w-full p-4 border border-gray-100 rounded-2xl bg-gray-100 text-gray-500 outline-none transition shadow-sm cursor-not-allowed">
                    </div>

                    {{-- No. Box/Lokasi --}}
                    <div class="group">
                        <label class="block font-bold text-gray-700 mb-2 transition group-focus-within:text-red-700">No. Box/Lokasi</label>
                        <input type="text" name="no_box" placeholder="Contoh : RAK A-01" 
                            class="w-full p-4 border border-red-100 rounded-2xl bg-red-50/10 focus:ring-1 focus:ring-red-500 outline-none transition shadow-sm text-center md:text-left">
                    </div>

                    {{-- Jenis Arsip (Radio Buttons) --}}
                    <div class="group">
                        <label class="block font-bold text-gray-700 mb-4 transition">Jenis Arsip</label>
                        <div class="flex flex-wrap gap-4 justify-end md:justify-start">
                            <label class="cursor-pointer flex items-center gap-3 p-4 border border-red-100 rounded-xl bg-red-50/10 hover:bg-red-50 transition w-full md:w-auto">
                                <input type="radio" name="jenis_media" value="Kertas" class="w-5 h-5 text-red-800 focus:ring-red-800 !accent-red-800 border-gray-300" checked>
                                <span class="font-medium text-gray-700">Kertas</span>
                            </label>
                            <label class="cursor-pointer flex items-center gap-3 p-4 border border-red-100 rounded-xl bg-red-50/10 hover:bg-red-50 transition w-full md:w-auto">
                                <input type="radio" name="jenis_media" value="Foto" class="w-5 h-5 text-red-800 focus:ring-red-800 !accent-red-800 border-gray-300">
                                <span class="font-medium text-gray-700">Foto</span>
                            </label>
                            <label class="cursor-pointer flex items-center gap-3 p-4 border border-red-100 rounded-xl bg-red-50/10 hover:bg-red-50 transition w-full md:w-auto">
                                <input type="radio" name="jenis_media" value="Kartografi" class="w-5 h-5 text-red-800 focus:ring-red-800 !accent-red-800 border-gray-300">
                                <span class="font-medium text-gray-700">Kartografi</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="md:col-span-2 flex justify-end pt-4">
                    <button type="submit" class="bg-red-800 text-white px-14 py-4 rounded-xl font-bold text-lg shadow-lg hover:bg-red-900 hover:scale-105 active:scale-95 transition duration-300">
                        SUBMIT
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layout>