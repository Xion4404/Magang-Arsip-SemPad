<x-layout>
    {{-- Header Page --}}
    {{-- Header Page --}}
    <div
        class="bg-[#9d1b1b] px-8 pt-6 pb-20 rounded-b-[2.5rem] shadow-xl mb-8 flex items-center justify-between relative overflow-hidden">
        <div class="relative z-10">
            <h1 class="text-3xl font-bold text-white tracking-wide">Form Peminjaman Baru</h1>
            <p class="text-red-100 text-sm mt-2 opacity-90 font-light">Isi formulir di bawah ini untuk mengajukan
                peminjaman arsip.</p>
        </div>
        <div
            class="hidden md:block absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full blur-3xl -mr-16 -mt-16 pointer-events-none">
        </div>
    </div>

    {{-- Main Form Container --}}
    <div class="max-w-5xl mx-auto px-6 -mt-20 relative z-20 mb-10" x-data="peminjamanForm()">

        {{-- Alert Error --}}
        @if ($errors->any())
            <div class="mb-6 bg-red-50 border-l-4 border-red-700 p-4 rounded-r shadow-sm">
                <div class="flex items-start">
                    <div class="flex-shrink-0"><svg class="h-5 w-5 text-red-700" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd" />
                        </svg></div>
                    <div class="ml-3">
                        <h3 class="text-sm font-bold text-red-800">Gagal Menyimpan Data!</h3>
                        <ul class="mt-2 list-disc list-inside text-sm text-red-700">@foreach ($errors->all() as $error)<li>
                            {{ $error }}
                        </li>@endforeach</ul>
                    </div>
                </div>
            </div>
        @endif

        <form action="/peminjaman" method="POST" enctype="multipart/form-data" @submit.prevent="submitForm($el)"
            class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
            @csrf

            <div class="p-8 space-y-8">
                {{-- DATA PEMINJAM --}}
                <div>
                    <h2
                        class="text-lg font-bold text-[#9d1b1b] border-b border-gray-100 pb-3 mb-6 flex items-center gap-3">
                        <i class="fas fa-user-circle text-[#9d1b1b]"></i> Data Peminjaman
                    </h2>
                    <div class="space-y-5">
                        <div><label class="block text-sm font-bold text-gray-800 mb-2">Tanggal Peminjaman <span
                                    class="text-red-600">*</span></label><input type="date" name="tanggal"
                                value="{{ old('tanggal') }}" required
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-gray-50 text-gray-800 focus:bg-white outline-none focus:border-[#9d1b1b] focus:ring-4 focus:ring-[#9d1b1b]/10 transition duration-200">
                        </div>
                        <div><label class="block text-sm font-bold text-gray-800 mb-2">Nama Peminjam <span
                                    class="text-red-600">*</span></label><input type="text" name="nama_peminjam"
                                value="{{ old('nama_peminjam') }}" required
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-gray-50 text-gray-800 focus:bg-white outline-none focus:border-[#9d1b1b] focus:ring-4 focus:ring-[#9d1b1b]/10 transition duration-200">
                        </div>
                        <div><label class="block text-sm font-bold text-gray-800 mb-2">NIP <span
                                    class="text-red-600">*</span></label><input type="text" name="nip"
                                value="{{ old('nip') }}" required
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-gray-50 text-gray-800 focus:bg-white outline-none focus:border-[#9d1b1b] focus:ring-4 focus:ring-[#9d1b1b]/10 transition duration-200">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-800 mb-2">Jabatan <span
                                    class="text-red-600">*</span></label>
                            <div class="relative">
                                <select name="jabatan_peminjam" x-model="jabatan" required
                                    class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-gray-50 text-gray-800 outline-none appearance-none cursor-pointer focus:bg-white focus:border-[#9d1b1b] focus:ring-4 focus:ring-[#9d1b1b]/10 transition duration-200">
                                    <option value="" disabled selected>-- Pilih Jabatan --</option>
                                    <option value="Direksi">Direksi</option>
                                    <option value="Band I">Band I</option>
                                    <option value="Band II">Band II</option>
                                    <option value="Band III">Band III</option>
                                    <option value="Band IV">Band IV</option>
                                    <option value="Karyawan/Pelaksana">Karyawan/Pelaksana</option>
                                </select>
                                <div
                                    class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-gray-500">
                                    <i class="fas fa-chevron-down text-sm"></i>
                                </div>
                            </div>
                        </div>
                        <div><label class="block text-sm font-bold text-gray-800 mb-2">Unit Kerja <span
                                    class="text-red-600">*</span></label><input type="text" name="unit"
                                value="{{ old('unit') }}" required
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-gray-50 text-gray-800 focus:bg-white outline-none focus:border-[#9d1b1b] focus:ring-4 focus:ring-[#9d1b1b]/10 transition duration-200">
                        </div>
                        <div><label class="block text-sm font-bold text-gray-800 mb-2">Keperluan <span
                                    class="text-red-600">*</span></label><textarea name="keperluan" rows="3" required
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-gray-50 text-gray-800 focus:bg-white outline-none focus:border-[#9d1b1b] focus:ring-4 focus:ring-[#9d1b1b]/10 transition duration-200">{{ old('keperluan') }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- DAFTAR ARSIP --}}
                <div class="bg-red-50/50 p-6 rounded-2xl border border-red-100">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold text-[#9d1b1b] flex items-center gap-3"><i
                                class="fas fa-box-open"></i> Daftar Arsip</h3>
                        <button type="button" @click="openModal()"
                            class="px-5 py-2.5 bg-[#9d1b1b] text-white text-sm font-bold rounded-xl hover:bg-[#801010] shadow-md transition flex items-center gap-2"><i
                                class="fas fa-plus-circle"></i> Tambah Arsip</button>
                    </div>
                    <div class="bg-white border border-gray-100 rounded-xl overflow-hidden shadow-sm">
                        <table class="w-full text-left">
                            <thead class="bg-[#9d1b1b] text-white">
                                <tr>
                                    <th class="px-4 py-3 text-xs font-bold uppercase w-12 text-center">No</th>
                                    <th class="px-4 py-3 text-xs font-bold uppercase">Nama Arsip</th>
                                    <th class="px-4 py-3 text-xs font-bold uppercase w-24 text-center">Box</th>
                                    <th class="px-4 py-3 text-xs font-bold uppercase w-48 text-center">Media & Fisik
                                    </th>
                                    <th class="px-4 py-3 text-xs font-bold uppercase w-20 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-red-100">
                                <template x-for="(item, index) in items" :key="index">
                                    <tr class="hover:bg-red-50">
                                        <td class="px-4 py-3 text-sm text-center font-bold" x-text="index + 1"></td>
                                        <td class="px-4 py-3">
                                            <div class="font-bold text-sm" x-text="item.display_name"></div>
                                            <div x-show="item.source === 'manual'"><span
                                                    class="text-[10px] font-bold text-yellow-800 bg-yellow-100 px-2 py-0.5 rounded border border-yellow-300">Manual</span>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 text-sm text-center font-mono" x-text="item.no_box || '-'">
                                        </td>
                                        <td class="px-4 py-3 text-center"><span
                                                class="text-[11px] font-bold px-3 py-1 rounded-full bg-red-50 text-red-800 border border-red-200"
                                                x-text="item.media"></span></td>
                                        <td class="px-4 py-3 text-center">
                                            <button type="button" @click="removeItem(index)"
                                                class="text-red-600 hover:text-red-800 bg-white border border-red-200 w-8 h-8 rounded flex items-center justify-center mx-auto shadow-sm"><i
                                                    class="fas fa-trash-alt text-xs"></i></button>
                                            <input type="hidden" name="items_source[]" :value="item.source">
                                            <input type="hidden" name="items_arsip_id[]" :value="item.id">
                                            <input type="hidden" name="items_nama_manual[]" :value="item.nama_manual">
                                            <input type="hidden" name="items_box_manual[]" :value="item.no_box">
                                            <input type="hidden" name="items_akses_manual[]" :value="item.akses">
                                            <input type="hidden" name="items_media[]" :value="item.media">
                                            <input type="hidden" name="items_fisik[]" :value="item.fisik">
                                        </td>
                                    </tr>
                                </template>
                                <tr x-show="items.length === 0">
                                    <td colspan="5" class="px-6 py-10 text-center text-gray-500 italic">Belum ada arsip
                                        yang ditambahkan.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- BUKTI --}}
                <div>
                    <h2
                        class="text-lg font-bold text-[#9d1b1b] border-b border-gray-100 pb-3 mb-6 flex items-center gap-3">
                        <i class="fas fa-paperclip text-[#9d1b1b]"></i> Bukti Peminjaman
                    </h2>
                    <div class="space-y-4">
                        <template x-for="(file, index) in files" :key="file.id">
                            <div class="flex items-center gap-3">
                                <label
                                    class="flex-1 flex items-center justify-between px-4 py-3 bg-white border border-gray-300 rounded-lg cursor-pointer hover:border-red-500 hover:ring-1 hover:ring-red-200 transition">
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="bg-red-100 text-red-800 w-10 h-10 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-file-alt text-lg"></i>
                                        </div>
                                        <div class="flex flex-col"><span class="text-sm font-bold truncate"
                                                x-text="file.name ? file.name : 'Pilih File'"></span><span
                                                class="text-xs text-gray-500"
                                                x-text="file.name ? 'Siap diupload' : 'Klik untuk upload'"></span></div>
                                    </div>
                                    <input type="file" name="bukti_pinjam[]" class="hidden"
                                        accept=".jpg,.jpeg,.png,.pdf,.doc,.docx"
                                        @change="handleFileChange($event, index)">
                                </label>
                                <button type="button" @click="removeFile(index)"
                                    class="w-12 h-12 flex items-center justify-center rounded-lg border border-red-200 text-red-600 bg-white hover:bg-red-100"
                                    x-show="files.length > 1 || file.name"><i
                                        class="fas fa-trash-alt text-lg"></i></button>
                            </div>
                        </template>
                        </template>
                    </div>
                    <button type="button" @click="addFile()"
                        class="mt-5 w-full py-3 border-2 border-dashed border-red-200 rounded-xl text-[#9d1b1b] font-bold hover:bg-red-50 hover:border-[#9d1b1b] transition flex items-center justify-center gap-2"><i
                            class="fas fa-plus-circle"></i> Tambah File Lain</button>
                </div>
            </div>

            <div class="bg-gray-50 px-8 py-6 border-t border-gray-100 flex justify-end gap-4">
                <a href="/peminjaman"
                    class="px-6 py-3 bg-white border border-gray-200 text-gray-700 rounded-xl font-bold hover:bg-gray-50 transition">Batal</a>
                <button type="submit"
                    class="px-8 py-3 bg-[#9d1b1b] text-white rounded-xl font-bold shadow-lg hover:bg-[#7a1515] hover:shadow-xl transition transform hover:-translate-y-0.5">Simpan
                    Data</button>
            </div>
        </form>

        {{-- MODAL (FIXED DROPDOWN) --}}
        <div x-show="showModal" style="display: none;"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg border border-red-200 relative"
                @click.away="closeModal()">
                <div class="bg-[#9d1b1b] px-6 py-4 flex justify-between items-center border-b border-red-800">
                    <h3 class="text-white font-bold text-lg">Tambah Item Arsip</h3>
                    <button @click="closeModal()" class="text-white/80 hover:text-white"><i
                            class="fas fa-times text-xl"></i></button>
                </div>
                <div class="p-6 space-y-6">
                    <div class="flex bg-red-50 p-1 rounded-xl border border-red-200">
                        <button type="button" @click="tempItem.source = 'db'"
                            class="flex-1 py-2.5 text-sm font-bold rounded-lg transition-all"
                            :class="tempItem.source === 'db' ? 'bg-white text-red-900 shadow' : 'text-red-600 hover:bg-red-100'">Cari
                            Database</button>
                        <button type="button" @click="tempItem.source = 'manual'"
                            class="flex-1 py-2.5 text-sm font-bold rounded-lg transition-all"
                            :class="tempItem.source === 'manual' ? 'bg-white text-red-900 shadow' : 'text-red-600 hover:bg-red-100'">Input
                            Manual</button>
                    </div>

                    {{-- SEARCH DB (FIXED DROPDOWN) --}}
                    <div x-show="tempItem.source === 'db'" class="space-y-4">
                        {{-- HAPUS x-data DISINI AGAR TIDAK KONFLIK --}}
                        <div class="relative">
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Cari Arsip</label>
                            <input type="text" x-model="searchQuery" @focus="openDropdown = true"
                                @click="openDropdown = true" @click.away="openDropdown = false"
                                placeholder="Ketik nama arsip..."
                                class="w-full border border-red-200 rounded-lg pl-4 pr-4 py-3 text-sm focus:ring-2 focus:ring-red-100 outline-none bg-white">

                            {{-- DROPDOWN --}}
                            <div x-show="openDropdown"
                                class="absolute z-50 w-full bg-white border border-red-200 mt-2 rounded-lg shadow-xl max-h-60 overflow-y-auto">
                                <ul x-show="filteredArsip.length > 0" class="divide-y divide-red-100">
                                    <template x-for="opt in filteredArsip" :key="opt.id">
                                        <li @click="selectArsip(opt); openDropdown = false"
                                            class="px-4 py-3 hover:bg-red-50 cursor-pointer flex justify-between items-center group transition">
                                            <div>
                                                <div class="font-bold text-sm text-gray-800" x-text="opt.nama_berkas">
                                                </div>
                                                <div class="text-[11px] text-gray-600 mt-1 flex gap-2">
                                                    <span class="bg-red-50 px-1.5 rounded border border-red-100">Box:
                                                        <span x-text="opt.no_box || '-'"></span></span>
                                                </div>
                                            </div>
                                            <div class="text-[10px] font-bold px-2 py-1 rounded bg-white text-red-800 border border-red-200 shadow-sm whitespace-nowrap"
                                                x-text="opt.klasifikasi_keamanan"></div>
                                        </li>
                                    </template>
                                </ul>
                                <div x-show="filteredArsip.length === 0" class="p-4 text-center text-sm text-gray-500">
                                    <span x-show="daftarArsip.length === 0">Semua arsip sedang dipinjam.</span>
                                    <span x-show="daftarArsip.length > 0">Tidak ada arsip ditemukan.</span>
                                </div>
                            </div>
                        </div>
                        <div x-show="tempItem.id && tempItem.display_name"
                            class="mt-3 p-3 bg-green-50 border border-green-200 rounded-lg text-sm text-green-800 font-bold">
                            Arsip Terpilih: <span x-text="tempItem.display_name"></span>
                        </div>
                    </div>

                    {{-- MANUAL INPUT --}}
                    <div x-show="tempItem.source === 'manual'" class="space-y-4">
                        <div><label class="block text-xs font-bold text-gray-700 uppercase mb-2">Nama
                                Arsip</label><input type="text" x-model="tempItem.nama_manual"
                                class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:ring-2 focus:ring-red-200 outline-none">
                        </div>
                        <div><label class="block text-xs font-bold text-gray-700 uppercase mb-2">No. Box</label><input
                                type="text" x-model="tempItem.no_box"
                                class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:ring-2 focus:ring-red-200 outline-none">
                        </div>
                        <div><label class="block text-xs font-bold text-gray-700 uppercase mb-2">Hak
                                Akses</label><select x-model="tempItem.akses"
                                class="w-full border border-gray-300 rounded-lg p-3 text-sm bg-white outline-none">
                                <option value="Biasa">Biasa / Terbuka</option>
                                <option value="Terbatas">Terbatas</option>
                                <option value="Rahasia">Rahasia</option>
                            </select></div>
                    </div>

                    {{-- MEDIA --}}
                    <div class="grid grid-cols-2 gap-4 pt-4 border-t border-red-200">
                        <div><label class="block text-xs font-bold text-gray-700 uppercase mb-2">Media</label><select
                                x-model="tempItem.media"
                                class="w-full border border-gray-300 rounded-lg p-3 text-sm bg-white outline-none">
                                <option value="Softfile">Softfile</option>
                                <option value="Hardfile">Hardfile</option>
                            </select></div>
                        <div x-show="tempItem.media === 'Hardfile'"><label
                                class="block text-xs font-bold text-gray-700 uppercase mb-2">Detail Fisik</label><select
                                x-model="tempItem.fisik"
                                class="w-full border border-gray-300 rounded-lg p-3 text-sm bg-white outline-none">
                                <option value="Berkas Asli">Berkas Asli</option>
                                <option value="Berkas Copy">Berkas Copy</option>
                            </select></div>
                    </div>
                </div>
                <div class="bg-gray-50 px-6 py-4 flex justify-end gap-3 border-t border-gray-200">
                    <button type="button" @click="closeModal()"
                        class="px-5 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-xl font-bold">Batal</button>
                    <button type="button" @click="addItem()"
                        class="px-6 py-2.5 bg-[#9d1b1b] text-white rounded-xl font-bold hover:bg-[#801010] shadow-md transition">Simpan
                        Item</button>
                </div>
            </div>
        </div>
    </div>

    {{-- UPDATED SCRIPT: ADDED openDropdown to main scope --}}
    <script>
        const daftarArsip = @json($daftarArsip ?? []);
        document.addEventListener('alpine:init', () => {
            Alpine.data('peminjamanForm', () => ({
                jabatan: '',
                items: [],
                files: [{ id: Date.now(), name: null }],
                showModal: false,
                searchQuery: '',
                openDropdown: false, // DEFINISI VARIABEL DISINI

                tempItem: { source: 'db', id: null, display_name: '', nama_manual: '', no_box: '', akses: 'Biasa', media: 'Softfile', fisik: 'Berkas Asli' },

                openModal() { this.tempItem = { source: 'db', id: null, display_name: '', nama_manual: '', no_box: '', akses: 'Biasa', media: 'Softfile', fisik: 'Berkas Asli' }; this.searchQuery = ''; this.showModal = true; },
                closeModal() { this.showModal = false; },

                get filteredArsip() {
                    const query = this.searchQuery.toLowerCase();
                    return daftarArsip.filter(item => {
                        return (item.nama_berkas || '').toLowerCase().includes(query) || (item.no_box || '').toLowerCase().includes(query);
                    }).slice(0, 10);
                },
                selectArsip(arsip) { this.tempItem.id = arsip.id; this.tempItem.display_name = arsip.nama_berkas; this.tempItem.no_box = arsip.no_box; this.tempItem.akses = arsip.klasifikasi_keamanan; this.searchQuery = arsip.nama_berkas; },
                addItem() {
                    if (this.tempItem.source === 'db' && !this.tempItem.id) return alert('Pilih arsip!');
                    if (this.tempItem.source === 'manual' && !this.tempItem.nama_manual) return alert('Isi nama arsip!');
                    if (this.tempItem.source === 'manual') this.tempItem.display_name = this.tempItem.nama_manual;
                    this.items.push({ ...this.tempItem }); this.closeModal();
                },
                removeItem(index) { this.items.splice(index, 1); },
                addFile() { this.files.push({ id: Date.now(), name: null }); },
                removeFile(index) { if (this.files.length > 1) this.files.splice(index, 1); else this.files[0].name = null; },
                handleFileChange(e, i) { this.files[i].name = e.target.files[0] ? e.target.files[0].name : null; },
                submitForm(form) { if (!this.jabatan) return alert('Pilih Jabatan!'); if (!this.items.length) return alert('Minimal 1 arsip!'); if (!this.files.some(f => f.name)) return alert('Upload bukti!'); form.submit(); }
            }));
        });
    </script>
</x-layout>