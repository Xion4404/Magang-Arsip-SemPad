<x-layout>
    <div x-data="{ showDeleteModal: false, deleteUrl: '', showSortModal: false, showImageModal: false, imageUrl: '' }">

        @if(session('success'))
        <div class="mb-6 bg-white border-l-4 border-gray-600 p-4 rounded-r shadow-sm flex items-start justify-between animate-fade-in-down">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-gray-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="text-sm font-medium text-gray-700">{{ session('success') }}</p>
            </div>
            <button onclick="this.parentElement.remove()" class="text-gray-400 hover:text-gray-600"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
        </div>
        @endif

        @if($errors->any())
        <div class="mb-6 bg-white border-l-4 border-red-600 p-4 rounded-r shadow-sm">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="text-sm font-medium text-red-600">{{ $errors->first() }}</p>
            </div>
        </div>
        @endif

        <div class="bg-gradient-to-r from-red-900 to-red-800 px-6 py-5 rounded-lg shadow-lg mb-6 flex flex-col sm:flex-row items-center justify-between relative overflow-hidden gap-4">
            <div class="relative z-10 text-center sm:text-left">
                <h1 class="text-2xl font-bold text-white tracking-wide">Daftar Peminjaman</h1>
                <p class="text-red-100 text-sm mt-1 opacity-90">Kelola data peminjaman arsip perusahaan.</p>
            </div>
            <div class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 rounded-full bg-white opacity-5 blur-2xl"></div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-6">
            <div class="bg-white rounded-lg p-5 border border-gray-200 shadow-sm flex items-center justify-between hover:shadow-md transition">
                <div>
                    <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider">Total Data</p>
                    <p class="text-2xl font-bold text-gray-700 mt-1">{{ $totalPeminjaman }}</p>
                </div>
                <div class="p-3 bg-gray-100 rounded-full text-gray-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
            </div>
            <div class="bg-white rounded-lg p-5 border border-red-100 shadow-sm flex items-center justify-between hover:shadow-md transition">
                <div>
                    <p class="text-xs text-red-600 font-semibold uppercase tracking-wider">Sedang Dipinjam</p>
                    <p class="text-2xl font-bold text-red-600 mt-1">{{ $masihDipinjam }}</p>
                </div>
                <div class="p-3 bg-red-50 rounded-full text-red-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <div class="bg-white rounded-lg p-5 border border-gray-200 shadow-sm flex items-center justify-between hover:shadow-md transition">
                <div>
                    <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider">Sudah Kembali</p>
                    <p class="text-2xl font-bold text-gray-700 mt-1">{{ $sudahDikembalikan }}</p>
                </div>
                <div class="p-3 bg-gray-700 text-white rounded-full">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </div>
            </div>
        </div>

        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200 mb-5 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
            
            <form action="/peminjaman" method="GET" class="w-full lg:w-96 relative">
                @if(request('status')) <input type="hidden" name="status" value="{{ request('status') }}"> @endif
                @if(request('media')) <input type="hidden" name="media" value="{{ request('media') }}"> @endif
                @if(request('keamanan')) <input type="hidden" name="keamanan" value="{{ request('keamanan') }}"> @endif
                @if(request('start_date')) <input type="hidden" name="start_date" value="{{ request('start_date') }}"> @endif
                @if(request('end_date')) <input type="hidden" name="end_date" value="{{ request('end_date') }}"> @endif
                
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari data... (Tekan Enter)" 
                    class="w-full pl-10 pr-4 py-2 bg-gray-50 border border-gray-300 rounded-lg text-sm text-gray-700 focus:ring-2 focus:ring-red-700 focus:border-red-700 focus:bg-white transition outline-none">
            </form>

            <div class="flex flex-wrap gap-2 w-full lg:w-auto">
                <a href="/peminjaman/export?{{ http_build_query(request()->all()) }}" target="_blank" class="flex-1 lg:flex-none justify-center flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-red-700 transition shadow-sm">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Export
                </a>
                
                <button @click="showSortModal = true" class="flex-1 lg:flex-none justify-center flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-red-700 transition shadow-sm">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"/></svg>
                    Filter
                </button>

                <a href="/peminjaman/create" class="flex-1 lg:flex-none justify-center flex items-center gap-2 px-5 py-2 bg-red-800 text-white rounded-lg text-sm font-semibold hover:bg-red-900 transition shadow-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah
                </a>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden w-full">
            <div class="overflow-x-auto">
                <table class="min-w-[1800px] w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider w-16 sticky left-0 bg-gray-50 z-10 border-r border-gray-200">No</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider w-32 border-r border-gray-100">Tanggal</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider w-56 border-r border-gray-100">Peminjam</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider w-40 border-r border-gray-100">NIP</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider w-48 border-r border-gray-100">Jabatan</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider w-48 border-r border-gray-100">Unit</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider min-w-[400px] border-r border-gray-100">Nama Arsip</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider w-32 border-r border-gray-100">Keamanan</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider w-32 border-r border-gray-100">Media</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider w-32 border-r border-gray-100">Ket. Fisik</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider w-24 border-r border-gray-100">Bukti</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider w-32 border-r border-gray-100">Status</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider w-44 sticky right-0 bg-gray-50 z-10 shadow-sm">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100 text-sm">
                        @forelse($peminjaman as $item)
                        <tr class="hover:bg-red-50/20 transition duration-150 group">
                            
                            <td class="px-6 py-4 text-gray-500 text-center sticky left-0 bg-white group-hover:bg-red-50/20 border-r border-gray-200">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 text-gray-600 whitespace-nowrap border-r border-gray-100">{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y') }}</td>
                            <td class="px-6 py-4 border-r border-gray-100"><span class="font-bold text-gray-700 block">{{ $item->nama_peminjam }}</span></td>
                            <td class="px-6 py-4 text-gray-500 font-mono border-r border-gray-100">{{ $item->nip }}</td>
                            <td class="px-6 py-4 text-gray-600 border-r border-gray-100">{{ $item->jabatan_peminjam }}</td>
                            <td class="px-6 py-4 text-gray-600 border-r border-gray-100">{{ $item->unit_peminjam }}</td>
                            <td class="px-6 py-4 border-r border-gray-100"><span class="text-gray-700 font-medium leading-relaxed block">{{ $item->arsip->nama_berkas ?? 'Data Terhapus' }}</span></td>
                            
                            <td class="px-6 py-4 text-center border-r border-gray-100">
                                @php
                                    $klasifikasi = $item->arsip->klasifikasi_keamanan ?? 'Biasa';
                                    $badgeClass = match($klasifikasi) {
                                        'Rahasia' => 'bg-red-700 text-white border-red-700',
                                        'Terbatas' => 'bg-red-50 text-red-700 border-red-200',
                                        default => 'bg-gray-100 text-gray-600 border-gray-200'
                                    };
                                @endphp
                                <span class="px-3 py-1 rounded-full text-xs font-bold border {{ $badgeClass }}">{{ $klasifikasi }}</span>
                            </td>

                            @php
                                $fullString = $item->jenis_dokumen;
                                $media = Str::before($fullString, ' - ');
                                $keterangan = Str::contains($fullString, ' - ') ? Str::after($fullString, ' - ') : '-';
                            @endphp

                            <td class="px-6 py-4 text-center border-r border-gray-100">
                                @if(Str::contains($media, 'Hardfile'))
                                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-gray-700 text-white border border-gray-700">Hardfile</span>
                                @else
                                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-white text-gray-600 border border-gray-300">Softfile</span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-center text-gray-500 border-r border-gray-100">{{ $keterangan }}</td>

                            <td class="px-6 py-4 text-center border-r border-gray-100">
                                @if($item->bukti_peminjaman)
                                    <button @click="showImageModal = true; imageUrl = '{{ asset($item->bukti_peminjaman) }}'" class="text-gray-400 hover:text-red-700 transition">
                                        <svg class="w-5 h-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </button>
                                @else
                                    <span class="text-gray-300 text-xs italic">N/A</span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-center border-r border-gray-100">
                                @if($item->status == 'Sedang Dipinjam')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-bold text-red-700 bg-red-50 border border-red-200">
                                        <span class="w-1.5 h-1.5 bg-red-600 rounded-full mr-1.5"></span> Dipinjam
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-bold text-gray-600 bg-gray-100 border border-gray-300">
                                        Kembali
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-center whitespace-nowrap sticky right-0 bg-white group-hover:bg-red-50/20 shadow-sm border-l border-gray-200">
                                <div class="flex justify-center items-center gap-2">
                                    
                                    @if($item->status == 'Sedang Dipinjam')
                                        <form action="/peminjaman/{{ $item->id }}/complete" method="POST">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="p-2 bg-gray-700 text-white rounded hover:bg-gray-800 transition shadow-sm border border-gray-700" title="Tandai Selesai">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                            </button>
                                        </form>
                                    @else
                                        <span class="p-2 bg-gray-100 text-gray-400 rounded border border-gray-200 cursor-default">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        </span>
                                    @endif

                                    <a href="/peminjaman/{{ $item->id }}/edit" class="p-2 bg-white text-gray-700 rounded border border-gray-400 hover:border-gray-700 hover:text-gray-900 transition shadow-sm" title="Edit Data">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                    </a>

                                    <button @click="showDeleteModal = true; deleteUrl = '/peminjaman/{{ $item->id }}'" class="p-2 bg-red-700 text-white rounded hover:bg-red-800 transition shadow-sm border border-red-700" title="Hapus Data">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="13" class="px-6 py-12 text-center text-gray-400 italic bg-gray-50 border border-dashed border-gray-200 m-4 rounded-lg">Tidak ada data peminjaman ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="mt-6 text-center text-xs text-gray-400 font-medium">&copy; 2026 PT Semen Padang. All rights reserved.</div>

        <div x-show="showSortModal" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
            <div @click.away="showSortModal = false" class="bg-white rounded-xl shadow-2xl w-full max-w-lg p-6">
                <div class="flex justify-between items-center mb-5">
                    <h3 class="text-lg font-bold text-gray-800">Filter Data</h3>
                    <a href="/peminjaman" class="text-xs font-bold text-red-700 hover:underline">Reset Filter</a>
                </div>
                <form action="/peminjaman" method="GET">
                    @if(request('search')) <input type="hidden" name="search" value="{{ request('search') }}"> @endif
                    
                    <div class="space-y-6">
                        
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Status</label>
                            <div class="grid grid-cols-3 gap-2">
                                <label class="cursor-pointer border border-gray-200 rounded-lg p-2 text-center hover:bg-gray-50 transition relative">
                                    <input type="radio" name="status" value="All" {{ request('status') == 'All' || !request('status') ? 'checked' : '' }} class="hidden peer">
                                    <span class="text-xs text-gray-600 peer-checked:text-gray-800 peer-checked:font-bold">Semua</span>
                                    <div class="absolute inset-0 border-2 border-gray-600 rounded-lg opacity-0 peer-checked:opacity-100 transition"></div>
                                </label>
                                <label class="cursor-pointer border border-gray-200 rounded-lg p-2 text-center hover:bg-gray-50 transition relative">
                                    <input type="radio" name="status" value="Sedang Dipinjam" {{ request('status') == 'Sedang Dipinjam' ? 'checked' : '' }} class="hidden peer">
                                    <span class="text-xs text-gray-600 peer-checked:text-red-700 peer-checked:font-bold">Dipinjam</span>
                                    <div class="absolute inset-0 border-2 border-red-700 rounded-lg opacity-0 peer-checked:opacity-100 transition"></div>
                                </label>
                                <label class="cursor-pointer border border-gray-200 rounded-lg p-2 text-center hover:bg-gray-50 transition relative">
                                    <input type="radio" name="status" value="Sudah Dikembalikan" {{ request('status') == 'Sudah Dikembalikan' ? 'checked' : '' }} class="hidden peer">
                                    <span class="text-xs text-gray-600 peer-checked:text-gray-800 peer-checked:font-bold">Kembali</span>
                                    <div class="absolute inset-0 border-2 border-gray-600 rounded-lg opacity-0 peer-checked:opacity-100 transition"></div>
                                </label>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Keamanan</label>
                            <div class="grid grid-cols-4 gap-2">
                                <label class="cursor-pointer border border-gray-200 rounded-lg p-2 text-center hover:bg-gray-50 transition relative">
                                    <input type="radio" name="keamanan" value="All" {{ request('keamanan') == 'All' || !request('keamanan') ? 'checked' : '' }} class="hidden peer">
                                    <span class="text-xs text-gray-600 peer-checked:text-gray-800 peer-checked:font-bold">Semua</span>
                                    <div class="absolute inset-0 border-2 border-gray-600 rounded-lg opacity-0 peer-checked:opacity-100 transition"></div>
                                </label>
                                <label class="cursor-pointer border border-gray-200 rounded-lg p-2 text-center hover:bg-gray-50 transition relative">
                                    <input type="radio" name="keamanan" value="Rahasia" {{ request('keamanan') == 'Rahasia' ? 'checked' : '' }} class="hidden peer">
                                    <span class="text-xs text-gray-600 peer-checked:text-red-700 peer-checked:font-bold">Rahasia</span>
                                    <div class="absolute inset-0 border-2 border-red-700 rounded-lg opacity-0 peer-checked:opacity-100 transition"></div>
                                </label>
                                <label class="cursor-pointer border border-gray-200 rounded-lg p-2 text-center hover:bg-gray-50 transition relative">
                                    <input type="radio" name="keamanan" value="Terbatas" {{ request('keamanan') == 'Terbatas' ? 'checked' : '' }} class="hidden peer">
                                    <span class="text-xs text-gray-600 peer-checked:text-red-700 peer-checked:font-bold">Terbatas</span>
                                    <div class="absolute inset-0 border-2 border-red-700 rounded-lg opacity-0 peer-checked:opacity-100 transition"></div>
                                </label>
                                <label class="cursor-pointer border border-gray-200 rounded-lg p-2 text-center hover:bg-gray-50 transition relative">
                                    <input type="radio" name="keamanan" value="Biasa/Terbuka" {{ request('keamanan') == 'Biasa/Terbuka' ? 'checked' : '' }} class="hidden peer">
                                    <span class="text-xs text-gray-600 peer-checked:text-gray-800 peer-checked:font-bold">Biasa</span>
                                    <div class="absolute inset-0 border-2 border-gray-600 rounded-lg opacity-0 peer-checked:opacity-100 transition"></div>
                                </label>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Media</label>
                            <div class="grid grid-cols-3 gap-2">
                                <label class="cursor-pointer border border-gray-200 rounded-lg p-2 text-center hover:bg-gray-50 transition relative">
                                    <input type="radio" name="media" value="All" {{ request('media') == 'All' || !request('media') ? 'checked' : '' }} class="hidden peer">
                                    <span class="text-xs text-gray-600 peer-checked:text-gray-800 peer-checked:font-bold">Semua</span>
                                    <div class="absolute inset-0 border-2 border-gray-600 rounded-lg opacity-0 peer-checked:opacity-100 transition"></div>
                                </label>
                                <label class="cursor-pointer border border-gray-200 rounded-lg p-2 text-center hover:bg-gray-50 transition relative">
                                    <input type="radio" name="media" value="Softfile" {{ request('media') == 'Softfile' ? 'checked' : '' }} class="hidden peer">
                                    <span class="text-xs text-gray-600 peer-checked:text-gray-800 peer-checked:font-bold">Softfile</span>
                                    <div class="absolute inset-0 border-2 border-gray-600 rounded-lg opacity-0 peer-checked:opacity-100 transition"></div>
                                </label>
                                <label class="cursor-pointer border border-gray-200 rounded-lg p-2 text-center hover:bg-gray-50 transition relative">
                                    <input type="radio" name="media" value="Hardfile" {{ request('media') == 'Hardfile' ? 'checked' : '' }} class="hidden peer">
                                    <span class="text-xs text-gray-600 peer-checked:text-gray-800 peer-checked:font-bold">Hardfile</span>
                                    <div class="absolute inset-0 border-2 border-gray-600 rounded-lg opacity-0 peer-checked:opacity-100 transition"></div>
                                </label>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Rentang Tanggal</label>
                            <div class="flex items-center gap-2">
                                <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full border border-gray-300 rounded-lg p-2 text-sm text-gray-600 focus:ring-2 focus:ring-red-700 outline-none">
                                <span class="text-gray-400 font-bold">-</span>
                                <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full border border-gray-300 rounded-lg p-2 text-sm text-gray-600 focus:ring-2 focus:ring-red-700 outline-none">
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end gap-3 pt-4 border-t border-gray-100">
                        <button type="button" @click="showSortModal = false" class="px-5 py-2 text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm font-bold transition">Batal</button>
                        <button type="submit" class="px-6 py-2 bg-red-800 text-white rounded-lg text-sm font-bold hover:bg-red-900 shadow-md transition">Terapkan Filter</button>
                    </div>
                </form>
            </div>
        </div>

        <div x-show="showDeleteModal" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
            <div @click.away="showDeleteModal = false" class="bg-white rounded-xl shadow-2xl w-full max-w-sm p-6 text-center">
                <h3 class="text-lg font-bold text-gray-800 mb-2">Hapus Data?</h3>
                <div class="flex justify-center gap-3 mt-4">
                    <button @click="showDeleteModal = false" class="px-5 py-2 bg-white border border-gray-300 text-gray-600 rounded-lg">Batal</button>
                    <form :action="deleteUrl" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" class="px-5 py-2 bg-red-700 text-white rounded-lg font-bold shadow-md hover:bg-red-800">Ya, Hapus</button>
                    </form>
                </div>
            </div>
        </div>

        <div x-show="showImageModal" style="display: none;" class="fixed inset-0 z-50 flex items-center justify-center bg-black/90 backdrop-blur-md p-4">
            <div @click.away="showImageModal = false" class="bg-white rounded-xl shadow-2xl overflow-hidden max-w-3xl w-full relative flex flex-col max-h-[90vh]">
                <div class="p-1 flex-1 flex justify-center items-center bg-gray-100 overflow-auto">
                    <img :src="imageUrl" class="max-w-full max-h-[80vh] object-contain shadow-lg rounded">
                </div>
                <div class="px-4 py-3 bg-white border-t border-gray-200 flex justify-end">
                    <button @click="showImageModal = false" class="px-4 py-2 bg-gray-100 hover:bg-red-50 text-gray-600 hover:text-red-700 rounded-lg text-sm font-bold">Tutup</button>
                </div>
            </div>
        </div>

    </div>
</x-layout>