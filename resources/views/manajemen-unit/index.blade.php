<x-layout>
    <div x-data="{ 
        showDeleteModal: false, 
        deleteUrl: '', 
        showEditModal: false,
        isEdit: false,
        modalTitle: '',
        formAction: '',
        formMethod: 'POST',
        formData: {
            nama_unit: '',
            keterangan: ''
        }
    }" class="bg-gray-50 min-h-screen pb-20">

        {{-- Header Section --}}
        <div class="bg-gradient-to-br from-[#e92027] via-[#b91c1c] to-[#7f090b] text-white pb-32 pt-16 px-8 -mt-6 -mx-6 mb-8 rounded-b-[3rem] shadow-2xl relative overflow-hidden">
             <!-- Polygon Pattern Overlay -->
             <div class="absolute inset-0 z-0 opacity-40">
                  <svg class="absolute w-full h-full" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg" width="100%" height="100%">
                     <defs>
                         <linearGradient id="polyGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                             <stop offset="0%" style="stop-color:#580000;stop-opacity:0.3" />
                             <stop offset="100%" style="stop-color:#000000;stop-opacity:0.4" />
                         </linearGradient>
                     </defs>
                     <path fill="url(#polyGrad)" d="M0 0 L1000 0 L1000 500 L0 300 Z" />
                     <path fill="#000000" opacity="0.1" d="M-100 0 L500 0 L200 600 L-100 400 Z" />
                     <path fill="#580000" opacity="0.2" d="M800 0 L1400 0 L1400 400 L600 600 Z" />
                     <path fill="url(#polyGrad)" opacity="0.3" d="M500 600 L1200 600 L800 200 Z" />
                 </svg>
             </div>
 
             <!-- Ornamental Icon -->
             <div class="absolute top-0 right-0 opacity-10 transform translate-x-1/4 -translate-y-1/4 z-0 pointer-events-none mix-blend-overlay">
                 <svg width="400" height="400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0L24 12L12 24L0 12L12 0Z" /></svg>
             </div>
             
             <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center relative z-10 gap-6">
                <div class="text-center md:text-left">
                     <h2 class="text-4xl font-extrabold tracking-tight mb-2 drop-shadow-md">Manajemen Unit</h2>
                     <p class="text-red-50 text-base font-light opacity-95 max-w-lg leading-relaxed drop-shadow-sm">Kelola daftar unit kerja dan departemen.</p>
                </div>
                <div>
                    <button @click="
                        showEditModal = true; 
                        isEdit = false; 
                        modalTitle = 'Tambah Unit Baru'; 
                        formAction = '{{ route('manajemen-unit.store') }}'; 
                        formMethod = 'POST';
                        formData.nama_unit = '';
                        formData.keterangan = '';
                    "
                        class="group bg-white text-[#e92027] hover:bg-gray-50 px-8 py-3 rounded-full font-bold shadow-2xl flex items-center gap-3 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-red-900/40 border border-white/20">
                        <div class="bg-red-50 p-1.5 rounded-full group-hover:bg-red-100 transition-colors">
                             <svg class="w-5 h-5 text-[#e92027]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        </div>
                        <span>TAMBAH UNIT</span>
                    </button>
                </div>
            </div>
        </div>

        {{-- Floating Card Container --}}
        <div class="max-w-7xl mx-auto px-4 -mt-20 relative z-20 mb-12">
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100 min-h-[600px] flex flex-col">
                
                {{-- Toolbar & Filters --}}
                <div class="p-6 border-b border-gray-100 bg-white flex flex-col lg:flex-row gap-4 justify-between items-center sticky top-0 z-30">
                     <!-- Search -->
                     <div class="relative w-full md:w-96 group">
                          <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400 group-focus-within:text-[#e92027] transition-colors">
                             <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                          </span>
                          <form action="{{ route('manajemen-unit.index') }}" method="GET">
                             <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama unit..." class="w-full py-3 pl-12 pr-4 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#e92027] focus:bg-white focus:border-transparent text-sm font-medium transition-all shadow-sm">
                          </form>
                     </div>

                     @if(session('success'))
                        <div class="flex items-center gap-2 bg-green-50 text-green-700 px-4 py-2 rounded-xl text-sm font-bold border border-green-200 animate-fade-in-down">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>{{ session('success') }}</span>
                            <button onclick="this.parentElement.remove()" class="ml-2 hover:text-green-900"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                        </div>
                     @endif
                     
                     @if($errors->any())
                        <div class="flex items-center gap-2 bg-red-50 text-red-700 px-4 py-2 rounded-xl text-sm font-bold border border-red-200 animate-fade-in-down">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>{{ $errors->first() }}</span>
                            <button onclick="this.parentElement.remove()" class="ml-2 hover:text-red-900"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                        </div>
                     @endif
                </div>

                {{-- Table Container --}}
                <div class="p-6 flex-grow overflow-x-auto">
                    <div class="overflow-hidden rounded-2xl border border-gray-200 shadow-sm">
                        <table class="min-w-full w-full bg-white">
                        <thead>
                            <tr class="bg-[#e92027] text-white">
                                <th class="px-6 py-4 text-left text-[11px] font-bold uppercase tracking-wider w-14">No</th>
                                <th class="px-6 py-4 text-left text-[11px] font-bold uppercase tracking-wider">Nama Unit</th>
                                <th class="px-6 py-4 text-left text-[11px] font-bold uppercase tracking-wider">Keterangan</th>
                                <th class="px-6 py-4 text-center text-[11px] font-bold uppercase tracking-wider w-40">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($units as $unit)
                                <tr class="hover:bg-red-50/20 transition duration-150 group">
                                    <td class="px-6 py-4 text-gray-500 text-center text-xs font-bold">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-800 font-bold text-xs">{{ $unit->nama_unit }}</td>
                                    <td class="px-6 py-4 text-gray-600 text-xs">{{ $unit->keterangan ?? '-' }}</td>

                                    <td class="px-6 py-4 text-center whitespace-nowrap">
                                        <div class="flex justify-center items-center gap-1.5">
                                            <button @click="
                                                showEditModal = true; 
                                                isEdit = true; 
                                                modalTitle = 'Edit Unit'; 
                                                formAction = '{{ route('manajemen-unit.update', $unit->id) }}';
                                                formMethod = 'PUT';
                                                formData.nama_unit = '{{ addslashes($unit->nama_unit) }}';
                                                formData.keterangan = '{{ addslashes($unit->keterangan ?? '') }}';
                                            "
                                                class="w-7 h-7 flex items-center justify-center bg-white text-amber-500 rounded-lg hover:bg-amber-50 transition shadow-sm border border-gray-200 hover:border-amber-200"
                                                title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                            </button>
                                            <button
                                                @click="showDeleteModal = true; deleteUrl = '{{ route('manajemen-unit.destroy', $unit->id) }}'"
                                                class="w-7 h-7 flex items-center justify-center bg-white text-[#e92027] rounded-lg hover:bg-red-50 transition shadow-sm border border-gray-200 hover:border-red-200"
                                                title="Hapus">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4"
                                        class="px-6 py-12 text-center text-gray-400 italic bg-gray-50/50 text-xs">Tidak ada data unit ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Delete Modal --}}
        <div x-show="showDeleteModal" style="display: none;"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
            <div @click.away="showDeleteModal = false"
                class="bg-white rounded-[2rem] w-full max-w-sm p-8 text-center relative overflow-hidden shadow-2xl">
                <div class="absolute top-0 left-0 w-full h-2 bg-[#e92027]"></div>
                <div
                    class="bg-red-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6 text-[#e92027] shadow-sm animate-bounce">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                </div>
                <h3 class="text-xl font-extrabold text-gray-800 mb-2">Hapus Unit?</h3>
                <p class="text-gray-500 mb-8 leading-relaxed">Unit ini akan dihapus permanen.</p>
                <div class="flex flex-col gap-3">
                    <form :action="deleteUrl" method="POST" class="w-full">
                        @csrf @method('DELETE')
                        <button
                            class="w-full py-3.5 bg-red-600 text-white rounded-xl text-sm font-bold hover:bg-red-700 shadow-lg transform hover:scale-[1.02] transition">Ya,
                            Hapus Sekarang</button>
                    </form>
                    <button @click="showDeleteModal = false"
                        class="w-full py-3.5 bg-white border border-gray-200 rounded-xl text-sm font-bold text-gray-500 hover:bg-gray-50 transition">Batalkan</button>
                </div>
            </div>
        </div>

        {{-- Edit/Add Modal --}}
        <div x-show="showEditModal" style="display: none;"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
            <div @click.away="showEditModal = false"
                class="bg-white rounded-[2rem] w-full max-w-md p-8 relative overflow-hidden shadow-2xl">
                <div class="absolute top-0 left-0 w-full h-2 bg-[#e92027]"></div>
                
                <h3 class="text-xl font-extrabold text-gray-800 mb-6" x-text="modalTitle"></h3>
                
                <form :action="formAction" method="POST" class="flex flex-col gap-4">
                    @csrf 
                    <input type="hidden" name="_method" :value="isEdit ? 'PUT' : 'POST'">
                    
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Nama Unit</label>
                        <input type="text" name="nama_unit" x-model="formData.nama_unit" required
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#e92027] focus:bg-white transition text-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Keterangan (Opsional)</label>
                        <textarea name="keterangan" x-model="formData.keterangan" rows="3"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#e92027] focus:bg-white transition text-sm"></textarea>
                    </div>

                    <div class="flex gap-3 mt-4">
                        <button type="button" @click="showEditModal = false"
                            class="flex-1 py-3 bg-gray-100 text-gray-600 rounded-xl text-sm font-bold hover:bg-gray-200 transition">Batal</button>
                        <button type="submit"
                            class="flex-1 py-3 bg-[#e92027] text-white rounded-xl text-sm font-bold hover:bg-red-700 shadow-lg transform hover:scale-[1.02] transition">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-layout>
