<x-layout>
    <div x-data="{ showDeleteModal: false, deleteUrl: '', showSortModal: false }">

        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Daftar Peminjaman Arsip</h2>
            <p class="text-gray-500 text-sm">Kelola data peminjaman arsip perusahaan di sini.</p>
        </div>

        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            
            <form action="/peminjaman" method="GET" class="flex gap-2 w-full md:w-auto">
                @if(request('status')) <input type="hidden" name="status" value="{{ request('status') }}"> @endif
                @if(request('start_date')) <input type="hidden" name="start_date" value="{{ request('start_date') }}"> @endif
                @if(request('end_date')) <input type="hidden" name="end_date" value="{{ request('end_date') }}"> @endif

                <div class="relative w-full md:w-64">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </span>
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}"
                        placeholder="Search..." 
                        class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:outline-none text-sm"
                    >
                </div>
                </form>

            <button 
                @click="showSortModal = true"
                class="bg-red-900 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-800 flex items-center gap-1 shadow-sm transition"
            >
                Sorting
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
            </button>

            <div class="ml-auto">
                <a href="/peminjaman/create" class="bg-red-900 text-white px-6 py-2 rounded-lg text-sm font-semibold shadow-lg hover:bg-red-800 transition flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah Peminjaman
                </a>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 font-bold">Tanggal</th>
                        <th class="px-6 py-4 font-bold">Nama Peminjam</th>
                        <th class="px-6 py-4 font-bold">Unit Peminjam</th>
                        <th class="px-6 py-4 font-bold">Nama Arsip</th>
                        <th class="px-6 py-4 font-bold text-center">Status</th>
                        <th class="px-6 py-4 font-bold text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($peminjaman as $item)
                    <tr class="hover:bg-red-50/30 transition duration-150">
                        <td class="px-6 py-4 text-red-600 font-medium whitespace-nowrap">{{ $item['tanggal'] }}</td>
                        <td class="px-6 py-4 text-gray-900 font-semibold">{{ $item['nama_peminjam'] }}</td>
                        <td class="px-6 py-4">{{ $item['unit'] }}</td>
                        <td class="px-6 py-4 text-gray-700">{{ $item['arsip'] }}</td>
                        <td class="px-6 py-4 text-center">
                            @if($item['status'] == 'Sedang Dipinjam')
                                <span class="inline-flex items-center gap-1 bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-bold border border-red-200">
                                    <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
                                    Sedang Dipinjam
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold border border-green-200">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                    Sudah Dikembalikan
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex justify-center gap-2 items-center">
                                @if($item['status'] == 'Sedang Dipinjam')
                                    <form action="/peminjaman/{{ $loop->index }}/complete" method="POST">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="text-gray-400 hover:text-green-600 transition p-1" title="Tandai Sudah Kembali">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                        </button>
                                    </form>
                                @else
                                    <button disabled class="text-green-500 cursor-default p-1"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg></button>
                                @endif
                                <a href="/peminjaman/{{ $loop->index }}/edit" class="text-gray-400 hover:text-blue-600 transition p-1"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></a>
                                <button @click="showDeleteModal = true; deleteUrl = '/peminjaman/{{ $loop->index }}'" class="text-gray-400 hover:text-red-600 transition p-1"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500 italic">
                            Tidak ada data yang ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-4 text-center text-xs text-gray-400">
            &copy; 2026 PT Semen Padang. All rights reserved.
        </div>

        <div x-show="showSortModal" style="display: none;" 
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4"
        >
            <div @click.away="showSortModal = false" class="bg-white rounded-2xl shadow-2xl w-full max-w-lg p-6">
                
                <h3 class="text-xl font-bold text-gray-800 mb-6">Filter & Sorting</h3>
                
                <form action="/peminjaman" method="GET">
                    @if(request('search')) <input type="hidden" name="search" value="{{ request('search') }}"> @endif

                    <div class="mb-6">
                        <label class="block font-bold text-gray-700 mb-2">Status</label>
                        <div class="flex flex-wrap gap-4">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="status" value="All" {{ request('status') == 'All' || !request('status') ? 'checked' : '' }} class="w-4 h-4 text-red-600 focus:ring-red-500">
                                <span class="text-gray-700">All</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="status" value="Sedang Dipinjam" {{ request('status') == 'Sedang Dipinjam' ? 'checked' : '' }} class="w-4 h-4 text-red-600 focus:ring-red-500">
                                <span class="text-gray-700">Sedang Dipinjam</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="status" value="Sudah Dikembalikan" {{ request('status') == 'Sudah Dikembalikan' ? 'checked' : '' }} class="w-4 h-4 text-red-600 focus:ring-red-500">
                                <span class="text-gray-700">Sudah Dikembalikan</span>
                            </label>
                        </div>
                    </div>

                    <div class="mb-8">
                        <label class="block font-bold text-gray-700 mb-2">Tanggal Peminjaman</label>
                        <div class="flex items-center gap-2">
                            <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full border border-gray-300 rounded-lg p-2 text-gray-700 focus:ring-red-500 outline-none">
                            <span class="text-gray-500">-</span>
                            <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full border border-gray-300 rounded-lg p-2 text-gray-700 focus:ring-red-500 outline-none">
                        </div>
                    </div>

                    <div class="flex justify-end gap-3">
                        <button type="button" @click="showSortModal = false" class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg font-medium transition">
                            Batal
                        </button>
                        <button type="submit" class="px-6 py-2 bg-red-900 text-white rounded-lg font-bold shadow hover:bg-red-800 transition">
                            Terapkan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div x-show="showDeleteModal" style="display: none;" 
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4"
        >
            <div @click.away="showDeleteModal = false" class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6 text-center">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-6">
                    <svg class="h-8 w-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Hapus Data Peminjaman?</h3>
                <p class="text-gray-500 text-sm mb-8">Apakah Anda yakin ingin menghapus data ini secara permanen?</p>
                <div class="flex justify-center gap-3">
                    <button @click="showDeleteModal = false" class="px-5 py-2.5 bg-white text-gray-700 font-medium text-sm rounded-lg border border-gray-300 hover:bg-gray-50">Batal</button>
                    <form :action="deleteUrl" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" class="px-5 py-2.5 bg-red-700 text-white font-bold text-sm rounded-lg hover:bg-red-800 shadow-lg">Ya, Hapus</button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</x-layout>