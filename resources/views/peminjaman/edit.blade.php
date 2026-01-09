<x-layout>
    <div class="bg-gradient-to-r from-red-900 to-red-700 px-8 py-4 shadow-md rounded-t-lg -mx-4 -mt-4 md:-mx-6 md:-mt-6 mb-6">
        <h1 class="text-xl font-bold text-white">Form Edit Peminjaman</h1>
    </div>

    <div class="flex justify-center items-start min-h-[80vh]">
        <div class="bg-white rounded-2xl shadow-xl p-8 w-full max-w-4xl border border-gray-100 relative">
            
            <form action="/peminjaman/{{ $id }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                        <label class="font-medium text-gray-700 text-lg">Tanggal Peminjaman :</label>
                        <div class="md:col-span-2">
                            <input type="date" name="tanggal" value="{{ $editData->tanggal_pinjam }}" required class="w-full border-2 border-gray-300 rounded-lg p-2.5 outline-none font-semibold text-gray-700">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                        <label class="font-medium text-gray-700 text-lg">Nama Peminjam :</label>
                        <div class="md:col-span-2">
                            <input type="text" name="nama_peminjam" value="{{ $editData->nama_peminjam }}" required class="w-full border-2 border-gray-300 rounded-lg p-2.5 outline-none font-semibold text-gray-700">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                        <label class="font-medium text-gray-700 text-lg">Unit Peminjam :</label>
                        <div class="md:col-span-2">
                            <select name="unit" required class="w-full border-2 border-gray-300 rounded-lg p-2.5 outline-none font-bold text-gray-700 bg-white">
                                @foreach($units as $unit)
                                    <option value="{{ $unit }}" {{ $unit == $editData->unit_peminjam ? 'selected' : '' }}>{{ $unit }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-start">
                        <label class="font-medium text-gray-700 text-lg">Arsip :</label>
                        <div class="md:col-span-2">
                             
                            <div class="bg-gray-100 p-3 rounded mb-2 text-gray-600 font-mono text-sm border border-gray-200">
                                <span class="block text-xs text-gray-400">Arsip Saat Ini:</span>
                                {{ $editData->arsip->nama_berkas ?? 'Data Arsip Hilang' }}
                            </div>

                            <div 
                                x-data="searchableSelect('{{ $editData->arsip_id }}')" 
                                class="relative w-full"
                            >
                                <input type="hidden" name="arsip_id[]" :value="selectedId">

                                <div class="relative">
                                    <input 
                                        type="text" 
                                        x-model="search"
                                        @click="open = true"
                                        @click.outside="open = false"
                                        placeholder="Cari untuk mengganti arsip..."
                                        class="w-full border-2 border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none font-bold text-gray-700 bg-white shadow-sm"
                                        autocomplete="off"
                                    >
                                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                    </div>
                                </div>

                                <div 
                                    x-show="open" 
                                    class="absolute z-50 w-full bg-white border border-gray-200 mt-1 rounded-lg shadow-xl max-h-60 overflow-y-auto"
                                    style="display: none;"
                                >
                                    <template x-if="filteredOptions.length > 0">
                                        <ul>
                                            <template x-for="option in filteredOptions" :key="option.id">
                                                <li 
                                                    @click="selectOption(option)"
                                                    class="px-4 py-2 hover:bg-red-50 cursor-pointer text-sm text-gray-700 border-b border-gray-100 last:border-0"
                                                >
                                                    <span class="font-bold block" x-text="option.nama_berkas"></span>
                                                    <span class="text-xs text-gray-500" x-text="'No: ' + option.no_berkas"></span>
                                                </li>
                                            </template>
                                        </ul>
                                    </template>
                                    <div x-show="filteredOptions.length === 0" class="p-3 text-sm text-gray-500 text-center">
                                        Tidak ada arsip ditemukan.
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="mt-10 flex justify-end">
                    <button type="submit" class="bg-red-900 text-white px-8 py-2.5 rounded-lg font-bold shadow-lg hover:bg-red-800 transition transform hover:scale-105">
                        Update Data
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
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
                    // Kalau search kosong, tampilkan semua
                    if (this.search === '') return this.options;

                    // Filter aman (Cek dulu apakah properti ada isinya sebelum di-lowercase)
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