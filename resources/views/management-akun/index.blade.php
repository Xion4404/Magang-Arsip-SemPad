<x-layout>
    <div x-data="{ showDeleteModal: false, deleteUrl: '' }" class="bg-gray-50 min-h-screen pb-20">

        {{-- Header Section --}}
<<<<<<< HEAD
        <div class="bg-[#9d1b1b] px-8 pt-6 pb-8 rounded-b-[2.5rem] shadow-lg relative">
            <div class="flex justify-between items-center mb-2">
                <div>
                    <h1 class="text-2xl font-bold text-white tracking-wide">Management Akun Pengguna</h1>
                    <p class="text-red-100 text-sm mt-0.5 opacity-90">Kelola daftar pengguna sistem.</p>
                </div>
                <div>
                    <a href="{{ route('management-akun.create') }}"
                        class="bg-white text-[#9d1b1b] px-5 py-2.5 rounded-xl font-bold text-sm shadow-lg hover:bg-gray-50 transition flex items-center gap-2 transform hover:scale-105 active:scale-95">
                        <i class="fas fa-plus-circle text-lg"></i>
                        <span>Tambah Pengguna</span>
                    </a>
                </div>
            </div>

            {{-- Search Bar --}}
            <div class="mt-8 relative w-full">
                <form action="{{ route('management-akun.index') }}" method="GET" class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400"><i
                            class="fas fa-search"></i></span>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari nama, email, atau role..."
                        class="w-full pl-11 pr-4 py-3 bg-white border-none rounded-xl text-sm font-medium text-gray-700 placeholder-gray-400 focus:ring-4 focus:ring-white/30 outline-none transition duration-200 shadow-md">
                </form>
            </div>
        </div>

        {{-- Stats Cards (Simplified) --}}
        {{-- Removed as requested --}}


        {{-- Main Content --}}
        <div class="px-8">
            {{-- Toolbar --}}
            {{-- Toolbar Moved to Header --}}

            {{-- Alert Success --}}
            @if(session('success'))
                <div
                    class="mb-6 bg-green-50 border border-green-200 p-3 rounded-xl flex items-start justify-between animate-fade-in-down shadow-sm">
                    <div class="flex items-center gap-3">
                        <div class="bg-green-100 p-1.5 rounded-full text-green-600"><i class="fas fa-check text-xs"></i>
                        </div>
                        <p class="text-xs font-bold text-green-800">{{ session('success') }}</p>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-green-400 hover:text-green-600 text-xs"><i
                            class="fas fa-times"></i></button>
                </div>
            @endif

            {{-- Table --}}
            <div
                class="bg-white rounded-2xl shadow-[0_2px_15px_rgb(0,0,0,0.03)] overflow-hidden border border-gray-100">
                <div class="overflow-x-auto">
                    <table class="min-w-full w-full">
                        <thead>
                            <tr class="bg-[#9d1b1b] text-white">
=======
        {{-- Header Section --}}
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
                     <h2 class="text-4xl font-extrabold tracking-tight mb-2 drop-shadow-md">Management Akun</h2>
                     <p class="text-red-50 text-base font-light opacity-95 max-w-lg leading-relaxed drop-shadow-sm">Kelola daftar pengguna sistem dan hak akses.</p>
                </div>
                <div>
                    <a href="{{ route('management-akun.create') }}"
                        class="group bg-white text-[#e92027] hover:bg-gray-50 px-8 py-3 rounded-full font-bold shadow-2xl flex items-center gap-3 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-red-900/40 border border-white/20">
                        <div class="bg-red-50 p-1.5 rounded-full group-hover:bg-red-100 transition-colors">
                             <svg class="w-5 h-5 text-[#e92027]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        </div>
                        <span>TAMBAH PENGGUNA</span>
                    </a>
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
                          <form action="{{ route('management-akun.index') }}" method="GET">
                             <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, atau role..." class="w-full py-3 pl-12 pr-4 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-[#e92027] focus:bg-white focus:border-transparent text-sm font-medium transition-all shadow-sm">
                          </form>
                     </div>

                     @if(session('success'))
                        <div class="flex items-center gap-2 bg-green-50 text-green-700 px-4 py-2 rounded-xl text-sm font-bold border border-green-200 animate-fade-in-down">
                            <i class="fas fa-check-circle"></i>
                            <span>{{ session('success') }}</span>
                            <button onclick="this.parentElement.remove()" class="ml-2 hover:text-green-900"><i class="fas fa-times"></i></button>
                        </div>
                     @endif
                </div>

                {{-- Table Container --}}
                <div class="p-6 flex-grow overflow-x-auto">
                    <div class="overflow-hidden rounded-2xl border border-gray-200 shadow-sm">
                        <table class="min-w-full w-full bg-white">
                        <thead>
                            <tr class="bg-[#e92027] text-white">
>>>>>>> 7d4f385849d706498d1a4faaf8f83b504a2a87f9
                                <th class="px-6 py-4 text-left text-[11px] font-bold uppercase tracking-wider w-14">No
                                </th>
                                <th class="px-6 py-4 text-left text-[11px] font-bold uppercase tracking-wider">Nama</th>
                                <th class="px-6 py-4 text-left text-[11px] font-bold uppercase tracking-wider">Email
                                </th>
                                <th class="px-6 py-4 text-center text-[11px] font-bold uppercase tracking-wider">Role
                                </th>

                                <th class="px-6 py-4 text-center text-[11px] font-bold uppercase tracking-wider w-40">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($users as $user)
                                <tr class="hover:bg-red-50/20 transition duration-150 group">
                                    <td class="px-6 py-4 text-gray-500 text-center text-xs font-bold">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-800 font-bold text-xs">{{ $user->nama }}</td>
                                    <td class="px-6 py-4 text-gray-600 text-xs">{{ $user->email }}</td>
                                    <td class="px-6 py-4 text-center">
                                        @if($user->role == 'admin')
                                            <span
<<<<<<< HEAD
                                                class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-[#9d1b1b] text-white border border-[#9d1b1b]">Admin</span>
=======
                                                class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-[#e92027] text-white border border-[#e92027]">Admin</span>
>>>>>>> 7d4f385849d706498d1a4faaf8f83b504a2a87f9
                                        @else
                                            <span
                                                class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-gray-100 text-gray-600 border border-gray-200">Karyawan</span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 text-center whitespace-nowrap">
                                        <div class="flex justify-center items-center gap-1.5">
                                            <a href="{{ route('management-akun.edit', $user->id) }}"
                                                class="w-7 h-7 flex items-center justify-center bg-white text-amber-500 rounded-lg hover:bg-amber-50 transition shadow-sm border border-gray-200 hover:border-amber-200"
                                                title="Edit">
                                                <i class="fas fa-pen text-[10px]"></i>
                                            </a>
                                            <button
                                                @click="showDeleteModal = true; deleteUrl = '{{ route('management-akun.destroy', $user->id) }}'"
<<<<<<< HEAD
                                                class="w-7 h-7 flex items-center justify-center bg-white text-red-500 rounded-lg hover:bg-red-50 transition shadow-sm border border-gray-200 hover:border-red-200"
=======
                                                class="w-7 h-7 flex items-center justify-center bg-white text-[#e92027] rounded-lg hover:bg-red-50 transition shadow-sm border border-gray-200 hover:border-red-200"
>>>>>>> 7d4f385849d706498d1a4faaf8f83b504a2a87f9
                                                title="Hapus">
                                                <i class="fas fa-trash-alt text-[10px]"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6"
                                        class="px-6 py-12 text-center text-gray-400 italic bg-gray-50/50 text-xs">Tidak ada
                                        data pengguna ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Pagination Removed --}}
        </div>

        {{-- Delete Modal --}}
        <div x-show="showDeleteModal" style="display: none;"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
            <div @click.away="showDeleteModal = false"
                class="bg-white rounded-[2rem] w-full max-w-sm p-8 text-center relative overflow-hidden shadow-2xl">
<<<<<<< HEAD
                <div class="absolute top-0 left-0 w-full h-2 bg-red-500"></div>
                <div
                    class="bg-red-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6 text-red-500 shadow-sm animate-bounce">
=======
                <div class="absolute top-0 left-0 w-full h-2 bg-[#e92027]"></div>
                <div
                    class="bg-red-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6 text-[#e92027] shadow-sm animate-bounce">
>>>>>>> 7d4f385849d706498d1a4faaf8f83b504a2a87f9
                    <i class="fas fa-trash-alt text-3xl"></i>
                </div>
                <h3 class="text-xl font-extrabold text-gray-800 mb-2">Hapus Pengguna?</h3>
                <p class="text-gray-500 mb-8 leading-relaxed">Akun pengguna ini akan dihapus permanen.</p>
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
    </div>
<<<<<<< HEAD
</x-layout>
=======
                    </table>
                </div>
            </div>
            
        </div>
    </div>
</div>
</x-layout>
>>>>>>> 7d4f385849d706498d1a4faaf8f83b504a2a87f9
