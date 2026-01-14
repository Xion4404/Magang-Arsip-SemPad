<x-layout>
    <div x-data="{ showDeleteModal: false, deleteUrl: '', showSortModal: false, showImageModal: false, imageUrl: '' }">

        <div class="bg-gradient-to-r from-red-900 to-red-800 px-6 py-5 rounded-lg shadow-md mb-6 relative overflow-hidden flex items-center justify-between">
            <div class="relative z-10">
                <h1 class="text-2xl font-bold text-white tracking-wide">
                    Halaman Daftar Peminjaman
                </h1>
                <p class="text-red-100 text-xs mt-1">
                    Pantau dan kelola arsip perusahaan dengan mudah.
                </p>
            </div>
            <div class="absolute top-0 right-0 -mt-2 -mr-2 w-24 h-24 rounded-full bg-white opacity-10 blur-xl"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-white rounded-lg p-4 border border-red-200 shadow-sm hover:shadow-md transition flex flex-col justify-center items-center group">
                <h3 class="text-gray-500 font-bold text-xs uppercase tracking-widest mb-1">Total Peminjaman</h3>
                <p class="text-3xl font-bold text-red-900 group-hover:scale-110 transition-transform">{{ $totalPeminjaman }}</p>
            </div>
            <div class="bg-white rounded-lg p-4 border border-red-200 shadow-sm hover:shadow-md transition flex flex-col justify-center items-center group">
                <h3 class="text-gray-500 font-bold text-xs uppercase tracking-widest mb-1">Sedang Dipinjam</h3>
                <p class="text-3xl font-bold text-red-900 group-hover:scale-110 transition-transform">{{ $masihDipinjam }}</p>
            </div>
            <div class="bg-white rounded-lg p-4 border border-red-200 shadow-sm hover:shadow-md transition flex flex-col justify-center items-center group">
                <h3 class="text-gray-500 font-bold text-xs uppercase tracking-widest mb-1">Telah Dikembalikan</h3>
                <p class="text-3xl font-bold text-red-900 group-hover:scale-110 transition-transform">{{ $sudahDikembalikan }}</p>
            </div>
        </div>

        <div class="flex flex-col md:flex-row justify-between items-center mb-5 gap-3">
            <form action="/peminjaman" method="GET" class="flex gap-2 w-full md:w-auto">
                @if(request('status')) <input type="hidden" name="status" value="{{ request('status') }}"> @endif
                @if(request('jenis_dokumen')) <input type="hidden" name="jenis_dokumen" value="{{ request('jenis_dokumen') }}"> @endif
                @if(request('start_date')) <input type="hidden" name="start_date" value="{{ request('start_date') }}"> @endif
                @if(request('end_date')) <input type="hidden" name="end_date" value="{{ request('end_date') }}"> @endif

                <div class="relative w-full md:w-72">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Nama / NIP / Arsip..." class="w-full pl-9 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-1 focus:ring-red-500 focus:outline-none text-sm">
                </div>
            </form>

            <div class="flex flex-wrap gap-2 w-full md:w-auto">
                <a href="/peminjaman/export?{{ http_build_query(request()->all()) }}" target="_blank" class="bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded-lg text-sm font-medium shadow-sm transition flex items-center gap-1 w-full md:w-auto justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Download
                </a>

                <button @click="showSortModal = true" class="bg-white border border-gray-300 text-gray-700 px-3 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 flex items-center gap-1 shadow-sm transition w-full md:w-auto justify-center">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"/></svg>
                    Filter
                </button>

                <a href="/peminjaman/create" class="bg-red-900 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow hover:bg-red-800 transition flex items-center gap-2 w-full md:w-auto justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah
                </a>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-4 py-3 font-bold whitespace-nowrap">Tanggal</th>
                        <th class="px-4 py-3 font-bold whitespace-nowrap">Nama Peminjam</th>
                        <th class="px-4 py-3 font-bold whitespace-nowrap">NIP</th>
                        <th class="px-4 py-3 font-bold whitespace-nowrap">Unit</th>
                        <th class="px-4 py-3 font-bold whitespace-nowrap">Nama Arsip</th>
                        <th class="px-4 py-3 font-bold whitespace-nowrap">Jenis Dokumen</th>
                        <th class="px-4 py-3 font-bold text-center whitespace-nowrap">Bukti</th>
                        <th class="px-4 py-3 font-bold text-center whitespace-nowrap">Status</th>
                        <th class="px-4 py-3 font-bold text-center whitespace-nowrap">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($peminjaman as $item)
                    <tr class="hover:bg-red-50/30 transition duration-150">
                        
                        <td class="px-4 py-3 text-red-600 font-medium whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d/m/Y') }}
                        </td>
                        
                        <td class="px-4 py-3 font-bold text-gray-800 whitespace-nowrap">{{ $item->nama_peminjam }}</td>
                        
                        <td class="px-4 py-3 text-gray-600 font-mono whitespace-nowrap">{{ $item->nip ?? '-' }}</td>

                        <td class="px-4 py-3 whitespace-nowrap">{{ $item->unit_peminjam }}</td>
                        
                        <td class="px-4 py-3 text-gray-700 whitespace-nowrap">
                            {{ $item->arsip->nama_berkas ?? 'Arsip Tidak Ditemukan' }}
                        </td>

                        <td class="px-4 py-3 whitespace-nowrap">
                            @if($item->jenis_dokumen == 'Berkas Digital')
                                <span class="px-2 py-1 rounded text-xs font-bold bg-blue-100 text-blue-700 border border-blue-200">
                                    Digital
                                </span>
                            @elseif($item->jenis_dokumen == 'Berkas Fisik')
                                <span class="px-2 py-1 rounded text-xs font-bold bg-amber-100 text-amber-700 border border-amber-200">
                                    Fisik
                                </span>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>

                        <td class="px-4 py-3 text-center whitespace-nowrap">
                            @if($item->bukti_peminjaman)
                                <button @click="showImageModal = true; imageUrl = '{{ asset($item->bukti_peminjaman) }}'" 
                                    class="bg-gray-100 hover:bg-red-100 text-gray-600 hover:text-red-600 border border-gray-200 px-3 py-1 rounded-md text-xs font-medium transition flex items-center gap-1 mx-auto">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    Lihat
                                </button>
                            @else
                                <span class="text-xs text-gray-400 italic">Tidak Ada</span>
                            @endif
                        </td>

                        <td class="px-4 py-3 text-center whitespace-nowrap">
                            @if($item->status == 'Sedang Dipinjam')
                                <span class="inline-flex items-center gap-1 bg-red-50 text-red-700 px-2.5 py-0.5 rounded-full text-xs font-bold border border-red-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span>
                                    Sedang Dipinjam
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 bg-green-50 text-green-700 px-2.5 py-0.5 rounded-full text-xs font-bold border border-green-100">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                    Telah Dikembalikan
                                </span>
                            @endif
                        </td>

                        <td class="px-4 py-3 text-center whitespace-nowrap">
                            <div class="flex justify-center gap-2 items-center">
                                @if($item->status == 'Sedang Dipinjam')
                                    <form action="/peminjaman/{{ $item->id }}/complete" method="POST">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="text-gray-400 hover:text-green-600 transition p-1" title="Tandai Sudah Kembali">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        </button>
                                    </form>
                                @else
                                    <button disabled class="text-green-500 cursor-default p-1"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg></button>
                                @endif
                                
                                <a href="/peminjaman/{{ $item->id }}/edit" class="text-gray-400 hover:text-blue-600 transition p-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></a>
                                
                                <button @click="showDeleteModal = true; deleteUrl = '/peminjaman/{{ $item->id }}'" class="text-gray-400 hover:text-red-600 transition p-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-6 py-12 text-center text-gray-500 italic">
                            Belum ada data peminjaman.
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
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0">
            <div @click.away="showSortModal = false" class="bg-white rounded-xl shadow-2xl w-full max-w-lg p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Filter & Sorting</h3>
                <form action="/peminjaman" method="GET">
                    @if(request('search')) <input type="hidden" name="search" value="{{ request('search') }}"> @endif
                    
                    <div class="mb-5">
                        <label class="block font-semibold text-sm text-gray-700 mb-2">Status Peminjaman</label>
                        <div class="flex flex-wrap gap-3">
                            <label class="flex items-center gap-2 cursor-pointer bg-gray-50 px-3 py-2 rounded-lg border border-gray-200 hover:bg-gray-100 transition">
                                <input type="radio" name="status" value="All" {{ request('status') == 'All' || !request('status') ? 'checked' : '' }} class="w-4 h-4 text-red-600 focus:ring-red-500">
                                <span class="text-sm text-gray-700">All</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer bg-gray-50 px-3 py-2 rounded-lg border border-gray-200 hover:bg-gray-100 transition">
                                <input type="radio" name="status" value="Sedang Dipinjam" {{ request('status') == 'Sedang Dipinjam' ? 'checked' : '' }} class="w-4 h-4 text-red-600 focus:ring-red-500">
                                <span class="text-sm text-gray-700">Sedang Dipinjam</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer bg-gray-50 px-3 py-2 rounded-lg border border-gray-200 hover:bg-gray-100 transition">
                                <input type="radio" name="status" value="Sudah Dikembalikan" {{ request('status') == 'Sudah Dikembalikan' ? 'checked' : '' }} class="w-4 h-4 text-red-600 focus:ring-red-500">
                                <span class="text-sm text-gray-700">Telah Dikembalikan</span>
                            </label>
                        </div>
                    </div>

                    <div class="mb-5">
                        <label class="block font-semibold text-sm text-gray-700 mb-2">Jenis Berkas</label>
                        <div class="flex flex-wrap gap-3">
                            <label class="flex items-center gap-2 cursor-pointer bg-gray-50 px-3 py-2 rounded-lg border border-gray-200 hover:bg-gray-100 transition">
                                <input type="radio" name="jenis_dokumen" value="All" {{ request('jenis_dokumen') == 'All' || !request('jenis_dokumen') ? 'checked' : '' }} class="w-4 h-4 text-red-600 focus:ring-red-500">
                                <span class="text-sm text-gray-700">All</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer bg-gray-50 px-3 py-2 rounded-lg border border-gray-200 hover:bg-gray-100 transition">
                                <input type="radio" name="jenis_dokumen" value="Berkas Fisik" {{ request('jenis_dokumen') == 'Berkas Fisik' ? 'checked' : '' }} class="w-4 h-4 text-red-600 focus:ring-red-500">
                                <span class="text-sm text-gray-700">Berkas Fisik</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer bg-gray-50 px-3 py-2 rounded-lg border border-gray-200 hover:bg-gray-100 transition">
                                <input type="radio" name="jenis_dokumen" value="Berkas Digital" {{ request('jenis_dokumen') == 'Berkas Digital' ? 'checked' : '' }} class="w-4 h-4 text-red-600 focus:ring-red-500">
                                <span class="text-sm text-gray-700">Berkas Digital</span>
                            </label>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block font-semibold text-sm text-gray-700 mb-2">Tanggal Peminjaman</label>
                        <div class="flex items-center gap-2">
                            <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full border border-gray-300 rounded-lg p-2 text-sm text-gray-700 focus:ring-1 focus:ring-red-500 outline-none">
                            <span class="text-gray-400">-</span>
                            <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full border border-gray-300 rounded-lg p-2 text-sm text-gray-700 focus:ring-1 focus:ring-red-500 outline-none">
                        </div>
                    </div>

                    <div class="flex justify-end gap-2">
                        <button type="button" @click="showSortModal = false" class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg text-sm font-medium transition">Batal</button>
                        <button type="submit" class="px-5 py-2 bg-red-900 text-white rounded-lg text-sm font-bold shadow hover:bg-red-800 transition">Terapkan</button>
                    </div>
                </form>
            </div>
        </div>

        <div x-show="showDeleteModal" style="display: none;" 
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0">
            <div @click.away="showDeleteModal = false" class="bg-white rounded-xl shadow-2xl w-full max-w-sm p-6 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                    <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Hapus Data?</h3>
                <p class="text-gray-500 text-xs mb-6">Yakin ingin menghapus data ini permanen?</p>
                <div class="flex justify-center gap-3">
                    <button @click="showDeleteModal = false" class="px-4 py-2 bg-white text-gray-700 font-medium text-sm rounded-lg border border-gray-300 hover:bg-gray-50">Batal</button>
                    <form :action="deleteUrl" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-700 text-white font-bold text-sm rounded-lg hover:bg-red-800 shadow">Ya, Hapus</button>
                    </form>
                </div>
            </div>
        </div>

        <div x-show="showImageModal" style="display: none;" 
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 backdrop-blur-sm p-4"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0">
            <div @click.away="showImageModal = false" class="bg-white rounded-xl shadow-2xl overflow-hidden max-w-2xl w-full relative">
                <div class="bg-gray-100 px-4 py-3 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="font-bold text-gray-700">Bukti Bon Peminjaman</h3>
                    <button @click="showImageModal = false" class="text-gray-400 hover:text-red-500 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div class="p-2 flex justify-center bg-gray-50">
                    <img :src="imageUrl" alt="Bukti Peminjaman" class="max-h-[70vh] w-auto object-contain rounded-md shadow-sm">
                </div>
                <div class="px-4 py-3 border-t border-gray-200 bg-white flex justify-end">
                    <a :href="imageUrl" download target="_blank" class="text-sm font-semibold text-blue-600 hover:underline flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        Download Gambar
                    </a>
                </div>
            </div>
        </div>

    </div>
</x-layout>
