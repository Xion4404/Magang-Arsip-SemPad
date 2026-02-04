<x-layout>
    <div x-data="{ showDeleteModal: false, deleteUrl: '' }" class="bg-gray-50 min-h-screen pb-20">
        
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
                     <h2 class="text-4xl font-extrabold tracking-tight mb-2 drop-shadow-md">Manajemen Media</h2>
                     <p class="text-red-50 text-base font-light opacity-95 max-w-lg leading-relaxed drop-shadow-sm">Kelola konten media dan informasi yang tampil di landing page.</p>
                </div>
                <div>
                    <a href="{{ route('manajemen-media.create') }}"
                        class="group bg-white text-[#e92027] hover:bg-gray-50 px-8 py-3 rounded-full font-bold shadow-2xl flex items-center gap-3 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-red-900/40 border border-white/20">
                        <div class="bg-red-50 p-1.5 rounded-full group-hover:bg-red-100 transition-colors">
                             <svg class="w-5 h-5 text-[#e92027]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        </div>
                        <span>TAMBAH BERITA</span>
                    </a>
                </div>
            </div>
        </div>

        {{-- Floating Card Container --}}
        <div class="max-w-7xl mx-auto px-4 -mt-20 relative z-20 mb-12">
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100 min-h-[600px] flex flex-col">
                
                {{-- Toolbar / Alert Area --}}
                <div class="p-6 border-b border-gray-100 bg-white flex flex-col lg:flex-row gap-4 justify-between items-center sticky top-0 z-30">
                    <div class="w-full">
                        @if(session('success'))
                            <div class="flex items-center gap-2 bg-green-50 text-green-700 px-4 py-3 rounded-xl text-sm font-bold border border-green-200 animate-fade-in-down w-full shadow-sm">
                                <i class="fas fa-check-circle text-lg"></i>
                                <span>{{ session('success') }}</span>
                                <button onclick="this.parentElement.remove()" class="ml-auto hover:text-green-900"><i class="fas fa-times"></i></button>
                            </div>
                        @else
                            <div class="text-gray-400 text-sm italic">
                                <i class="fas fa-info-circle mr-1"></i> Daftar berita yang ditampilkan di halaman depan.
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Table Container --}}
                <div class="p-6 flex-grow overflow-x-auto">
                    <div class="overflow-hidden rounded-2xl border border-gray-200 shadow-sm">
                        <table class="w-full text-sm text-center border-collapse">
                            <thead>
                                <tr class="bg-[#e92027] text-white">
                                    <th class="py-5 px-6 font-bold text-xs uppercase tracking-wider first:rounded-tl-xl text-center w-24">Gambar</th>
                                    <th class="py-5 px-6 font-bold text-xs uppercase tracking-wider text-center">Judul</th>
                                    <th class="py-5 px-6 font-bold text-xs uppercase tracking-wider text-center w-40">Tanggal</th>
                                    <th class="py-5 px-6 font-bold text-xs uppercase tracking-wider text-center">Deskripsi</th>
                                    <th class="py-5 px-6 font-bold text-xs uppercase tracking-wider text-center last:rounded-tr-xl w-32">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 bg-white">
                                @forelse($media as $item)
                                    <tr class="hover:bg-red-50/50 transition duration-200 group">
                                        <td class="py-4 px-6 text-center">
                                            <div class="h-16 w-24 rounded-lg overflow-hidden shadow-sm border border-gray-200 mx-auto group-hover:border-red-200 transition-colors">
                                                <img src="{{ asset($item->gambar) }}" alt="{{ $item->judul }}"
                                                    class="h-full w-full object-cover transform group-hover:scale-105 transition duration-500">
                                            </div>
                                        </td>
                                        <td class="py-4 px-6 font-bold text-gray-800 text-left">
                                            {{ $item->judul }}
                                        </td>
                                        <td class="py-4 px-6 text-gray-600 text-center">
                                            <span class="bg-gray-100 text-gray-700 py-1 px-3 rounded-full text-xs font-semibold">
                                                {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-6 text-gray-600 text-left">
                                            <p class="line-clamp-2 max-w-xs">{{ $item->deskripsi }}</p>
                                        </td>
                                        <td class="py-4 px-6 text-center">
                                            <div class="flex items-center justify-center gap-2">
                                                <a href="{{ route('manajemen-media.edit', $item->id) }}"
                                                    class="p-2 text-amber-500 hover:text-amber-700 hover:bg-amber-50 rounded-lg transition-colors border border-transparent hover:border-amber-100"
                                                    title="Edit">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </a>
                                                <button
                                                    @click="showDeleteModal = true; deleteUrl = '{{ route('manajemen-media.destroy', $item->id) }}'"
                                                    class="p-2 text-[#e92027] hover:text-[#a0131a] hover:bg-red-50 rounded-lg transition-colors border border-transparent hover:border-red-100" title="Hapus">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-12 text-center text-gray-400">
                                            <div class="flex flex-col items-center justify-center">
                                                <svg class="w-16 h-16 text-gray-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                                                <p class="text-lg font-medium">Belum ada data berita</p>
                                                <p class="text-sm">Mulai dengan menambahkan berita baru</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="px-6 pb-6">
                    {{ $media->links() }}
                </div>
            </div>
        </div>

        {{-- Delete Modal --}}
        <div x-show="showDeleteModal" style="display: none;"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm p-4"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90"
            x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90">
            <div @click.away="showDeleteModal = false"
                class="bg-white rounded-[2rem] w-full max-w-sm p-8 text-center relative overflow-hidden shadow-2xl">
                <div class="absolute top-0 left-0 w-full h-2 bg-[#e92027]"></div>
                <div
                    class="bg-red-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6 text-[#e92027] shadow-sm animate-bounce">
                    <i class="fas fa-trash-alt text-3xl"></i>
                </div>
                <h3 class="text-xl font-extrabold text-gray-800 mb-2">Hapus Berita?</h3>
                <p class="text-gray-500 mb-8 leading-relaxed">Data berita yang dihapus tidak dapat dikembalikan lagi.
                </p>
                <div class="flex flex-col gap-3">
                    <form :action="deleteUrl" method="POST" class="w-full">
                        @csrf @method('DELETE')
                        <button type="submit"
                            class="w-full py-3.5 bg-[#e92027] text-white rounded-xl text-sm font-bold hover:bg-[#c41820] shadow-lg transform hover:scale-[1.02] transition">Ya,
                            Hapus Sekarang</button>
                    </form>
                    <button @click="showDeleteModal = false"
                        class="w-full py-3.5 bg-white border border-gray-200 rounded-xl text-sm font-bold text-gray-500 hover:bg-gray-50 transition">Batalkan</button>
                </div>
            </div>
        </div>
    </div>
</x-layout>
