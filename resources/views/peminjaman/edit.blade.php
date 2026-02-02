<x-layout>
    {{-- Header Page --}}
    {{-- Header Page --}}
    <div class="bg-[#e92027] px-6 md:px-8 pt-6 pb-20 rounded-b-[2.5rem] shadow-xl mb-8 flex items-center justify-between relative overflow-hidden">
        <div class="relative z-10">
            <h1 class="text-2xl md:text-3xl font-bold text-white tracking-wide">Edit Data Peminjaman</h1>
            <p class="text-red-100 text-sm mt-2 opacity-90 font-light">Perbarui informasi peminjaman arsip.</p>
        </div>
        <div class="hidden md:block absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full blur-3xl -mr-16 -mt-16 pointer-events-none"></div>
    </div>

    {{-- Main Form Container --}}
    <div class="max-w-5xl mx-auto px-6 -mt-20 relative z-20 mb-10" x-data="peminjamanEdit()">
        {{-- Validasi Error dipindah ke Modal --}}
        
        <form action="/peminjaman/{{ $editData->id }}" method="POST" enctype="multipart/form-data" @submit.prevent="submitForm($el)" 
              class="bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden" novalidate>
            @csrf
            @method('PUT')
            
            <input type="hidden" name="delete_existing_bukti" :value="deleteOldFile ? 1 : 0">

            <div class="p-6 md:p-8 space-y-8">
                
                {{-- BAGIAN 1: DATA PEMINJAM --}}
                <div>
                    <h2 class="text-lg font-bold text-[#e92027] border-b border-gray-100 pb-3 mb-6 flex items-center gap-3">
                        <i class="fas fa-user-edit text-[#e92027]"></i> Data Peminjam
                    </h2>

                    <div class="space-y-5">
                        {{-- Tanggal --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-800 mb-2">Tanggal Peminjaman <span class="text-[#e92027]">*</span></label>
                            <input type="date" name="tanggal" value="{{ $editData->tanggal_pinjam }}" required 
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 text-gray-800 outline-none transition bg-gray-50 focus:bg-white focus:border-[#e92027] focus:ring-4 focus:ring-[#9d1b1b]/10 scale-100">
                        </div>

                        {{-- Nama --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-800 mb-2">Nama Peminjam <span class="text-[#e92027]">*</span></label>
                            <input type="text" name="nama_peminjam" value="{{ $editData->nama_peminjam }}" required 
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 text-gray-800 outline-none transition bg-gray-50 focus:bg-white focus:border-[#e92027] focus:ring-4 focus:ring-[#9d1b1b]/10 scale-100">
                        </div>

                        {{-- NIP --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-800 mb-2">NIP <span class="text-[#e92027]">*</span></label>
                            <input type="text" name="nip" value="{{ $editData->nip }}" required 
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 text-gray-800 outline-none transition bg-gray-50 focus:bg-white focus:border-[#e92027] focus:ring-4 focus:ring-[#9d1b1b]/10 scale-100">
                        </div>

                        {{-- Jabatan --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-800 mb-2">Jabatan <span class="text-[#e92027]">*</span></label>
                            <div class="relative">
                                <select name="jabatan_peminjam" x-model="jabatan" required 
                                    class="w-full border border-gray-200 rounded-xl px-4 py-3 text-gray-800 outline-none transition bg-gray-50 focus:bg-white focus:border-[#e92027] focus:ring-4 focus:ring-[#9d1b1b]/10 cursor-pointer appearance-none"
                                    style="-webkit-appearance: none; -moz-appearance: none; appearance: none;">
                                    <option value="" disabled>-- Pilih Jabatan --</option>
                                    <option value="Direksi">Direksi</option>
                                    <option value="Band I">Band I</option>
                                    <option value="Band II">Band II</option>
                                    <option value="Band III">Band III</option>
                                    <option value="Band IV">Band IV</option>
                                    <option value="Karyawan/Pelaksana">Karyawan/Pelaksana</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-gray-500"><i class="fas fa-chevron-down text-sm"></i></div>
                            </div>
                        </div>

                        {{-- Unit --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-800 mb-2">Unit Kerja <span class="text-[#e92027]">*</span></label>
                            <input type="text" name="unit" value="{{ $editData->unit_peminjam }}" required 
                                class="w-full border border-gray-200 rounded-xl px-4 py-3 text-gray-800 outline-none transition bg-gray-50 focus:bg-white focus:border-[#e92027] focus:ring-4 focus:ring-[#9d1b1b]/10 scale-100">
                        </div>

                        {{-- Keperluan --}}
                        <div>
                            <label class="block text-sm font-bold text-gray-800 mb-2">Keperluan <span class="text-[#e92027]">*</span></label>
                            <textarea name="keperluan" rows="3" required 
                                class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-800 focus:ring-2 focus:ring-red-200 focus:border-red-800 outline-none transition bg-gray-50 focus:bg-white">{{ $editData->keperluan }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- BAGIAN 2: DAFTAR ARSIP --}}
                <div class="bg-red-50/50 p-6 rounded-2xl border border-red-100">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                        <div>
                            <h3 class="text-lg font-bold text-[#e92027] flex items-center gap-3"><i class="fas fa-box-open"></i> Daftar Arsip</h3>
                            <p class="text-xs text-[#a0131a]/70 mt-1">Kelola daftar arsip yang dipinjam.</p>
                        </div>
                        <button type="button" @click="openModal()" 
                            class="w-full md:w-auto px-5 py-2.5 bg-[#e92027] text-white text-sm font-bold rounded-xl hover:bg-[#801010] shadow-md transition flex items-center justify-center gap-2">
                            <i class="fas fa-plus-circle"></i> Tambah Arsip Lain
                        </button>
                    </div>

                    <div class="bg-white border border-gray-100 rounded-xl overflow-x-auto shadow-sm">
                        <table class="w-full text-left border-collapse min-w-[700px]">
                            <thead class="bg-[#e92027] text-white">
                                <tr>
                                    <th class="px-4 py-3 text-xs font-bold uppercase w-12 text-center border-b border-red-200">No</th>
                                    <th class="px-4 py-3 text-xs font-bold uppercase border-b border-red-200">Nama Arsip</th>
                                    <th class="px-4 py-3 text-xs font-bold uppercase w-24 text-center border-b border-red-200">Box</th>
                                    <th class="px-4 py-3 text-xs font-bold uppercase w-48 text-center border-b border-red-200">Media & Fisik</th>
                                    <th class="px-4 py-3 text-xs font-bold uppercase w-20 text-center border-b border-red-200">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-red-100">
                                <template x-for="(item, index) in items" :key="index">
                                    <tr class="hover:bg-red-50 transition">
                                        <td class="px-4 py-3 text-sm text-gray-700 text-center font-bold" x-text="index + 1"></td>
                                        <td class="px-4 py-3">
                                            <div class="font-bold text-gray-800 text-sm" x-text="item.display_name"></div>
                                            <div x-show="item.source === 'manual'" class="inline-block mt-1">
                                                <span class="text-[10px] font-bold text-yellow-800 bg-yellow-100 px-2 py-0.5 rounded border border-yellow-300">Manual Input</span>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3 text-sm text-gray-700 text-center font-mono" x-text="item.no_box || '-'"></td>
                                        
                                        <td class="px-4 py-3 text-center">
                                            <div class="flex items-center justify-center">
                                                <span x-show="item.media === 'Hardfile'" class="text-[11px] font-bold px-3 py-1 rounded-full uppercase tracking-wide bg-gray-100 text-gray-800 border border-gray-300" x-text="'Hardfile (' + item.fisik.replace('Berkas ', '') + ')'"></span>
                                                <span x-show="item.media === 'Softfile'" class="text-[11px] font-bold px-3 py-1 rounded-full uppercase tracking-wide bg-red-50 text-[#a0131a] border border-red-200">Softfile</span>
                                            </div>
                                        </td>
                                        
                                        <td class="px-4 py-3 text-center">
                                            <div class="flex justify-center gap-2">
                                                <button type="button" @click="openModal(index)" class="w-8 h-8 rounded-lg flex items-center justify-center text-yellow-600 bg-white border border-yellow-300 hover:bg-yellow-50 shadow-sm"><i class="fas fa-pen text-xs"></i></button>
<<<<<<< HEAD
                                                <button type="button" @click="removeItem(index)" class="w-8 h-8 rounded-lg flex items-center justify-center text-red-600 bg-white border border-red-200 hover:bg-red-50 shadow-sm"><i class="fas fa-trash-alt text-xs"></i></button>
=======
                                                <button type="button" @click="removeItem(index)" class="w-8 h-8 rounded-lg flex items-center justify-center text-[#e92027] bg-white border border-red-200 hover:bg-red-50 shadow-sm"><i class="fas fa-trash-alt text-xs"></i></button>
>>>>>>> 7d4f385849d706498d1a4faaf8f83b504a2a87f9
                                            </div>
                                            {{-- HIDDEN INPUTS (ARRAY) --}}
                                            <input type="hidden" name="items_source[]" :value="item.source">
                                            <input type="hidden" name="items_arsip_id[]" :value="item.id">
                                            <input type="hidden" name="items_nama_manual[]" :value="item.nama_manual">
                                            {{-- Hapus no_arsip manual --}}
                                            <input type="hidden" name="items_box_manual[]" :value="item.no_box">
                                            <input type="hidden" name="items_akses_manual[]" :value="item.akses">
                                            <input type="hidden" name="items_media[]" :value="item.media">
                                            <input type="hidden" name="items_fisik[]" :value="item.fisik">
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- BAGIAN 3: BUKTI --}}
                <div>
                    <h2 class="text-lg font-bold text-[#e92027] border-b border-gray-100 pb-3 mb-6 flex items-center gap-3"><i class="fas fa-paperclip text-[#e92027]"></i> Bukti Peminjaman <span class="text-[#e92027]">*</span></h2>
                    
                    @if($editData->bukti_peminjaman)
                        @php 
                            $existingFiles = is_array(json_decode($editData->bukti_peminjaman)) ? json_decode($editData->bukti_peminjaman) : ($editData->bukti_peminjaman ? [$editData->bukti_peminjaman] : []);
                        @endphp
                        <div x-show="!deleteOldFile" class="mb-6 bg-red-50 border border-red-100 rounded-xl p-4 transition-all">
                            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-3 gap-2">
                                <div><p class="text-xs font-bold text-[#a0131a] uppercase tracking-wide mb-1">File Tersimpan Saat Ini</p><p class="text-xs text-[#e92027]">File ini akan tetap ada kecuali Anda menghapusnya.</p></div>
                                <button type="button" @click="deleteOldFile = true" class="w-full md:w-auto text-xs font-bold text-[#e92027] hover:text-[#a0131a] flex items-center justify-center gap-1 bg-white px-3 py-1.5 rounded border border-red-200 hover:bg-red-50 transition shadow-sm"><i class="fas fa-trash-alt"></i> Hapus Semua File Lama</button>
                            </div>
                            <div class="flex flex-wrap gap-2">
                                @foreach($existingFiles as $file)
                                    <a href="{{ asset($file) }}" target="_blank" class="flex items-center gap-2 px-3 py-2 bg-white border border-red-200 rounded-lg text-sm font-medium text-gray-700 hover:text-[#c41820] hover:border-[#e92027] transition shadow-sm"><div class="bg-red-50 p-1 rounded text-[#e92027]"><i class="fas fa-file-check"></i></div><span class="truncate max-w-[150px]">{{ basename($file) }}</span></a>
                                @endforeach
                            </div>
                        </div>
                        <div x-show="deleteOldFile" class="mb-6 bg-red-50 border border-red-200 rounded-xl p-4 flex justify-between items-center animate-fade-in-up">
                            <div class="flex items-center gap-3"><div class="bg-red-100 p-2 rounded-full text-[#e92027]"><i class="fas fa-exclamation-triangle"></i></div><div class="text-sm font-bold text-[#a0131a]">File lama akan dihapus.</div></div>
                            <button type="button" @click="deleteOldFile = false" class="text-xs font-bold text-gray-600 bg-white px-3 py-1.5 rounded border border-gray-300 shadow-sm">Batal</button>
                        </div>
                    @endif

                    <div class="space-y-4">
                        <template x-for="(file, index) in files" :key="file.id">
                            <div class="flex items-center gap-3 animate-fade-in-up">
                                <div class="flex-1 relative group">
                                    <label class="flex items-center justify-between w-full px-4 py-3 bg-white border border-gray-300 rounded-lg cursor-pointer hover:border-[#e92027] hover:ring-1 hover:ring-red-200 transition shadow-sm group">
                                        <div class="flex items-center gap-4 overflow-hidden"><div class="bg-red-100 text-[#a0131a] w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0 border border-red-200"><i class="fas fa-file-alt text-lg"></i></div><div class="flex flex-col overflow-hidden"><span class="text-sm font-bold text-gray-800 truncate" x-text="file.name ? file.name : 'Upload File Tambahan'"></span><span class="text-xs text-gray-500" x-text="file.name ? 'Siap diupload' : 'Klik untuk memilih file'"></span></div></div>
                                        <span class="text-xs font-bold text-red-900 bg-red-100 px-3 py-1.5 rounded-md border border-red-300 group-hover:bg-red-200 transition">Browse</span>
                                        <input type="file" name="bukti_pinjam[]" class="hidden" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx" @change="handleFileChange($event, index)">
                                    </label>
                                </div>
                                <button type="button" @click="removeFile(index)" class="w-12 h-12 flex-shrink-0 flex items-center justify-center rounded-lg border border-red-200 text-[#e92027] bg-white hover:bg-red-100 hover:text-red-900 hover:border-[#e92027] transition shadow-sm" x-show="files.length > 1 || file.name"><i class="fas fa-trash-alt text-lg"></i></button>
                            </div>
                        </template>
                    </div>
                    <button type="button" @click="addFile()" class="mt-5 w-full py-3 border-2 border-dashed border-red-300 rounded-xl text-[#c41820] font-bold hover:bg-red-50 hover:border-[#e92027] transition flex items-center justify-center gap-2 group"><i class="fas fa-plus-circle group-hover:scale-110 transition"></i><span>Tambah File Lain</span></button>
                </div>
            </div>

            {{-- Footer --}}
            <div class="bg-gray-50 px-8 py-6 border-t border-gray-100 flex justify-end gap-4">
                <a href="/peminjaman" class="px-6 py-3 bg-white border border-gray-200 text-gray-700 rounded-xl font-bold hover:bg-gray-50 transition">Batal</a>
                <button type="submit" class="px-8 py-3 bg-[#e92027] text-white rounded-xl font-bold shadow-lg hover:bg-[#7a1515] hover:shadow-xl transition transform hover:-translate-y-0.5 flex items-center gap-2"><i class="fas fa-save"></i> Simpan Perubahan</button>
            </div>
        </form>

        {{-- MODAL EDIT/ADD ARSIP --}}
        <div x-show="showModal" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-lg overflow-hidden border border-red-200 relative" @click.away="closeModal()">
                <div class="bg-[#e92027] px-6 py-4 flex justify-between items-center border-b border-red-800">
                    <div class="flex items-center gap-3"><h3 class="text-white font-bold text-lg" x-text="editingIndex !== null ? 'Edit Item Arsip' : 'Tambah Item Arsip'"></h3></div>
                    <button @click="closeModal()" class="text-white/80 hover:text-white transition p-1 hover:bg-white/10 rounded-full"><i class="fas fa-times text-xl"></i></button>
                </div>
                <div class="p-6 space-y-6">
                    <div>
                        <div class="flex bg-red-50 p-1 rounded-xl border border-red-200">
                            <button type="button" @click="tempItem.source = 'db'" class="flex-1 py-2.5 text-sm font-bold rounded-lg transition-all duration-200 flex items-center justify-center gap-2" :class="tempItem.source === 'db' ? 'bg-white text-red-900 shadow ring-1 ring-red-200' : 'text-[#e92027] hover:text-[#a0131a] hover:bg-red-100'"><i class="fas fa-search"></i> Cari Database</button>
                            <button type="button" @click="tempItem.source = 'manual'" class="flex-1 py-2.5 text-sm font-bold rounded-lg transition-all duration-200 flex items-center justify-center gap-2" :class="tempItem.source === 'manual' ? 'bg-white text-red-900 shadow ring-1 ring-red-200' : 'text-[#e92027] hover:text-[#a0131a] hover:bg-red-100'"><i class="fas fa-pen"></i> Input Manual</button>
                        </div>
                    </div>
                    <div x-show="tempItem.source === 'db'" class="space-y-4">
                        <div class="relative" x-data="{ openDropdown: false }">
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Cari Arsip</label>
                            <div class="relative group"><span class="absolute inset-y-0 left-0 pl-3 flex items-center text-[#e92027] group-focus-within:text-[#c41820] transition"><i class="fas fa-search"></i></span><input type="text" x-model="searchQuery" @focus="openDropdown = true" @click="openDropdown = true" @click.away="openDropdown = false" placeholder="Klik untuk memilih atau ketik..." class="w-full border border-red-200 rounded-lg pl-10 pr-4 py-3 text-sm focus:ring-2 focus:ring-red-100 focus:border-[#e92027] transition outline-none bg-white" autocomplete="off"></div>
                            <div x-show="openDropdown" class="absolute z-20 w-full bg-white border border-red-200 mt-2 rounded-lg shadow-xl max-h-60 overflow-y-auto" style="display: none;">
                                <ul x-show="filteredArsip.length > 0" class="divide-y divide-red-100">
                                    <template x-for="opt in filteredArsip" :key="opt.id">
                                        <li @click="selectArsip(opt); openDropdown = false" class="px-4 py-3 hover:bg-red-50 cursor-pointer flex justify-between items-center group transition">
                                            <div>
                                                <div class="font-bold text-sm text-gray-800 group-hover:text-red-900" x-text="opt.nama_berkas"></div>
                                                <div class="text-[11px] text-gray-600 mt-1 flex gap-2">
                                                    <span class="bg-red-50 px-1.5 py-0.5 rounded border border-red-100">Box: <span x-text="opt.no_box || '-'"></span></span>
                                                </div>
                                            </div>
                                            <div class="text-[10px] font-bold px-2 py-1 rounded bg-white text-[#a0131a] border border-red-200 shadow-sm whitespace-nowrap" x-text="opt.klasifikasi_keamanan"></div>
                                        </li>
                                    </template>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div x-show="tempItem.source === 'manual'" class="space-y-4">
                        <div><label class="block text-xs font-bold text-gray-700 uppercase mb-2">Nama Arsip</label><input type="text" x-model="tempItem.nama_manual" class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:ring-2 focus:ring-red-200 focus:border-red-800 outline-none"></div>
                        <div><label class="block text-xs font-bold text-gray-700 uppercase mb-2">No. Box</label><input type="text" x-model="tempItem.no_box" class="w-full border border-gray-300 rounded-lg p-3 text-sm focus:ring-2 focus:ring-red-200 focus:border-red-800 outline-none"></div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Hak Akses</label>
                            <div class="relative">
                                <select x-model="tempItem.akses" class="w-full border border-gray-300 rounded-lg p-3 text-sm bg-white focus:ring-2 focus:ring-red-200 focus:border-red-800 outline-none appearance-none cursor-pointer" style="-webkit-appearance: none; -moz-appearance: none; appearance: none;"><option value="Biasa">Biasa / Terbuka</option><option value="Terbatas">Terbatas</option><option value="Rahasia">Rahasia</option></select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 pointer-events-none"><i class="fas fa-chevron-down text-xs"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4 pt-4 border-t border-red-200">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Media</label>
                            <div class="relative">
                                <select x-model="tempItem.media" class="w-full border border-gray-300 rounded-lg p-3 text-sm bg-white focus:ring-2 focus:ring-red-200 focus:border-red-800 outline-none appearance-none cursor-pointer" style="-webkit-appearance: none; -moz-appearance: none; appearance: none;"><option value="Softfile">Softfile</option><option value="Hardfile">Hardfile</option></select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 pointer-events-none"><i class="fas fa-chevron-down text-xs"></i></div>
                            </div>
                        </div>
                        <div x-show="tempItem.media === 'Hardfile'">
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Detail Fisik</label>
                            <div class="relative">
                                <select x-model="tempItem.fisik" class="w-full border border-gray-300 rounded-lg p-3 text-sm bg-white focus:ring-2 focus:ring-red-200 focus:border-red-800 outline-none appearance-none cursor-pointer" style="-webkit-appearance: none; -moz-appearance: none; appearance: none;"><option value="Berkas Asli">Berkas Asli</option><option value="Berkas Copy">Berkas Copy</option></select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 pointer-events-none"><i class="fas fa-chevron-down text-xs"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-6 py-4 flex justify-end gap-3 border-t border-gray-200">
                    <button type="button" @click="closeModal()" class="px-5 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-xl text-sm font-bold hover:bg-gray-50 transition">Batal</button>
<<<<<<< HEAD
                    <button type="button" @click="addItem()" class="px-6 py-2.5 bg-[#9d1b1b] text-white rounded-xl text-sm font-bold hover:bg-[#801010] shadow-md transition flex items-center gap-2" x-text="editingIndex !== null ? 'Ubah Item' : 'Simpan Item'"></button>
=======
                    <button type="button" @click="addItem()" class="px-6 py-2.5 bg-[#e92027] text-white rounded-xl text-sm font-bold hover:bg-[#801010] shadow-md transition flex items-center gap-2" x-text="editingIndex !== null ? 'Ubah Item' : 'Simpan Item'"></button>
>>>>>>> 7d4f385849d706498d1a4faaf8f83b504a2a87f9
                </div>
            </div>
        </div>
    <!-- Validation Modal -->
    <div x-show="showValidationModal" style="display: none;"
        class="fixed inset-0 z-[60] flex items-center justify-center bg-black/60 backdrop-blur-sm p-4"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-90"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-90">
        <div @click.away="showValidationModal = false"
<<<<<<< HEAD
            class="bg-white rounded-[2rem] w-full max-w-sm p-8 text-center relative overflow-hidden shadow-2xl border-t-8 border-[#9d1b1b]">
            
            <div class="bg-red-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6 text-[#9d1b1b] shadow-sm animate-bounce">
=======
            class="bg-white rounded-[2rem] w-full max-w-sm p-8 text-center relative overflow-hidden shadow-2xl border-t-8 border-[#e92027]">
            
            <div class="bg-red-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6 text-[#e92027] shadow-sm animate-bounce">
>>>>>>> 7d4f385849d706498d1a4faaf8f83b504a2a87f9
                <i class="fas fa-exclamation-triangle text-3xl"></i>
            </div>
            
            <h3 class="text-xl font-extrabold text-gray-800 mb-2">Perhatian!</h3>
            
            <!-- Dynamic Error Message -->
            <template x-if="serverErrors.length > 0">
                <div class="text-gray-500 mb-8 text-sm text-left bg-red-50 p-4 rounded-xl border border-red-100">
                    <ul class="list-disc list-inside space-y-1">
                        <template x-for="error in serverErrors">
<<<<<<< HEAD
                            <li x-text="error" class="text-red-700 font-medium"></li>
=======
                            <li x-text="error" class="text-[#c41820] font-medium"></li>
>>>>>>> 7d4f385849d706498d1a4faaf8f83b504a2a87f9
                        </template>
                    </ul>
                </div>
            </template>
            
            <template x-if="serverErrors.length === 0">
<<<<<<< HEAD
                <p class="text-gray-500 mb-8 leading-relaxed">Mohon lengkapi semua field yang bertanda bintang (<span class="text-red-600">*</span>) sebelum menyimpan.</p>
            </template>
            
            <button @click="showValidationModal = false" class="w-full py-3.5 bg-[#9d1b1b] text-white rounded-xl text-sm font-bold hover:bg-[#801010] shadow-lg transform hover:scale-[1.02] transition">
=======
                <p class="text-gray-500 mb-8 leading-relaxed">Mohon lengkapi semua field yang bertanda bintang (<span class="text-[#e92027]">*</span>) sebelum menyimpan.</p>
            </template>
            
            <button @click="showValidationModal = false" class="w-full py-3.5 bg-[#e92027] text-white rounded-xl text-sm font-bold hover:bg-[#801010] shadow-lg transform hover:scale-[1.02] transition">
>>>>>>> 7d4f385849d706498d1a4faaf8f83b504a2a87f9
                OK, Saya Mengerti
            </button>
        </div>
    </div>

    </div>

    <script>
        const daftarArsip = @json($daftarArsip ?? []);
        const currentItems = @json($currentItems ?? []);
        
        document.addEventListener('alpine:init', () => {
            Alpine.data('peminjamanEdit', () => ({
                jabatan: '{{ $editData->jabatan_peminjam }}',
                items: currentItems.map(item => ({
                    source: item.source, 
                    id: item.id || null, 
                    display_name: item.display_name,
                    nama_manual: item.nama_manual,
                    no_box: item.no_box,
                    akses: item.akses,
                    media: item.media,
                    fisik: item.fisik
                })),
                files: [{ id: Date.now(), name: null }], 
                deleteOldFile: false,
                
                showModal: false,
                showValidationModal: false, 
                serverErrors: @json($errors->all()),
                searchQuery: '',
                openDropdown: false,
                editingIndex: null, 

                tempItem: { source: 'db', id: null, display_name: '', nama_manual: '', no_box: '', akses: 'Biasa', media: 'Softfile', fisik: 'Berkas Asli' },

                init() {
                    if (this.serverErrors.length > 0) {
                        this.showValidationModal = true;
                    }
                },

                openModal(index = null) {
                    this.editingIndex = index;
                    if (index !== null) {
                        this.tempItem = {...this.items[index]};
                        if (this.tempItem.source === 'db') {
                            this.searchQuery = this.tempItem.display_name;
                        } else {
                            this.searchQuery = '';
                        }
                    } else {
                        this.tempItem = { source: 'db', id: null, display_name: '', nama_manual: '', no_box: '', akses: 'Biasa', media: 'Softfile', fisik: 'Berkas Asli' };
                        this.searchQuery = '';
                    }
                    this.showModal = true;
                },

                closeModal() { this.showModal = false; },
                
                get filteredArsip() {
                    const query = this.searchQuery.toLowerCase();
                    return daftarArsip.filter(item => {
                        return (item.nama_berkas && item.nama_berkas.toLowerCase().includes(query)) ||
                               (item.no_box && item.no_box.toLowerCase().includes(query));
                    }).slice(0, 10);
                },

                selectArsip(arsip) {
                    this.tempItem.id = arsip.id;
                    this.tempItem.display_name = arsip.nama_berkas;
                    this.tempItem.no_box = arsip.no_box;
                    this.tempItem.akses = arsip.klasifikasi_keamanan;
                    this.searchQuery = arsip.nama_berkas; 
                },

                addItem() {
                    if (this.tempItem.source === 'db' && !this.tempItem.id) { this.serverErrors = ['Pilih arsip!']; this.showValidationModal = true; return; }
                    if (this.tempItem.source === 'manual' && !this.tempItem.nama_manual) { this.serverErrors = ['Nama arsip wajib diisi!']; this.showValidationModal = true; return; }
                    if (this.tempItem.source === 'manual') this.tempItem.display_name = this.tempItem.nama_manual;
                    
                    if (this.editingIndex !== null) {
                        this.items[this.editingIndex] = {...this.tempItem};
                    } else {
                        this.items.push({...this.tempItem});
                    }
                    this.closeModal();
                },

                removeItem(index) {
                    if(this.items.length > 1) {
                        this.items.splice(index, 1);
                    } else {
                        this.serverErrors = ['Minimal harus ada 1 arsip!'];
                        this.showValidationModal = true;
                    }
                },

                addFile() { this.files.push({ id: Date.now(), name: null }); },
                removeFile(index) {
                    if (this.files.length === 1 && !this.files[0].name) return;
                    this.files.splice(index, 1);
                    if (this.files.length === 0) this.addFile();
                },
                handleFileChange(event, index) {
                    this.files[index].name = event.target.files[0] ? event.target.files[0].name : null;
                },
                
                submitForm(form) {
                    this.serverErrors = [];
                    let formValid = true;

                    // Mapping properties to friendly names
                    const fieldLabels = {
                        'tanggal': 'Tanggal Peminjaman',
                        'nama_peminjam': 'Nama Peminjam',
                        'nip': 'NIP',
                        'unit': 'Unit Kerja',
                        'keperluan': 'Keperluan'
                    };
                    
                    const requiredInputs = ['tanggal', 'nama_peminjam', 'nip', 'unit', 'keperluan'];
                    
                    requiredInputs.forEach(fieldName => {
                        const input = form.querySelector(`[name="${fieldName}"]`);
                        if (!input || !input.value.trim()) {
                            this.serverErrors.push(`Kotak ${fieldLabels[fieldName]} harus diisi`);
                            formValid = false;
                        }
                    });

                    if (!this.jabatan) {
                        this.serverErrors.push('Kotak Jabatan harus dipilih');
                        formValid = false;
                    }
                    
                    if (this.items.length === 0) {
                        this.serverErrors.push('Minimal harus ada 1 arsip yang dipinjam');
                        formValid = false;
                    }

                    // FILE VALIDATION
                    const hasNewFile = this.files.some(f => f.name !== null);
                    const hasExistingFile = {{ $editData->bukti_peminjaman ? 'true' : 'false' }};
                    
                    let validFile = false;
                    
                    if (this.deleteOldFile) {
                        if (hasNewFile) validFile = true;
                    } else {
                        if (hasExistingFile || hasNewFile) validFile = true;
                    }
                    
                    if (!validFile) {
                        this.serverErrors.push('Bukti Peminjaman (File) harus tersedia (File Lama atau Upload Baru)');
                        formValid = false; 
                    }

                    if (!formValid) {
                        this.showValidationModal = true;
                        return;
                    }

                    form.submit();
                }
            }));
        });
    </script>
</x-layout>
