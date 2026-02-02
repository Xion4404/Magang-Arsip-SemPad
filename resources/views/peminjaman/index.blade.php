<x-layout>
    <div x-data="{ 
        showDeleteModal: false, 
        deleteUrl: '', 
        showSortModal: false, 
        showSortDropdown: false,
        showFilesModal: false, 
        selectedFiles: [],
        filterStatus: '{{ request('status') ?? 'All' }}',
        filterKeamanan: '{{ request('keamanan') ?? 'All' }}',
        filterMedia: '{{ request('media') ?? 'All' }}',
        selectedItems: [],
        allSelected: false,
        toggleSelectAll() {
            this.allSelected = !this.allSelected;
            if (this.allSelected) {
                this.selectedItems = {{ json_encode($peminjaman->pluck('id')) }};
            } else {
                this.selectedItems = [];
            }
        }
    }" class="bg-gray-50 min-h-screen pb-20">

        {{-- NEW HEADER SECTION --}}
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
                     <h2 class="text-4xl font-extrabold tracking-tight mb-2 drop-shadow-md">Daftar Peminjaman</h2>
                     <p class="text-red-50 text-base font-light opacity-95 max-w-lg leading-relaxed drop-shadow-sm">Kelola data peminjaman arsip perusahaan.</p>
                </div>
                <div>
                    <a href="/peminjaman/create"
                        class="group bg-white text-[#e92027] hover:bg-gray-50 px-8 py-3 rounded-full font-bold shadow-2xl flex items-center gap-3 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-red-900/40 border border-white/20">
                        <div class="bg-red-50 p-1.5 rounded-full group-hover:bg-red-100 transition-colors">
                             <svg class="w-5 h-5 text-[#e92027]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        </div>
                        <span>TAMBAH PEMINJAMAN</span>
                    </a>
                </div>
            </div>
        </div>
 
        {{-- floating STATS CARDS (Overlap) --}}
        <div class="px-8 -mt-20 relative z-10 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <!-- Card 1 -->
                <div
                    class="bg-white rounded-xl p-5 shadow-[0_4px_20px_rgb(0,0,0,0.03)] flex flex-col items-center justify-center text-center h-28 border-b-4 border-[#e92027] hover:-translate-y-1 transition duration-300">
                    <p class="text-gray-500 font-bold text-[10px] uppercase tracking-widest mb-1">Total Arsip</p>
                    <p class="text-4xl font-extrabold text-[#e92027]">{{ $totalPeminjaman }}</p>
                </div>
                <!-- Card 2 -->
                <div
                    class="bg-white rounded-xl p-5 shadow-[0_4px_20px_rgb(0,0,0,0.03)] flex flex-col items-center justify-center text-center h-28 border-b-4 border-[#e92027] hover:-translate-y-1 transition duration-300">
                    <p class="text-gray-500 font-bold text-[10px] uppercase tracking-widest mb-1">Sedang Dipinjam</p>
                    <p class="text-4xl font-extrabold text-[#e92027]">{{ $masihDipinjam }}</p>
                </div>
                <!-- Card 3 -->
                <div
                    class="bg-white rounded-xl p-5 shadow-[0_4px_20px_rgb(0,0,0,0.03)] flex flex-col items-center justify-center text-center h-28 border-b-4 border-gray-400 hover:-translate-y-1 transition duration-300">
                    <p class="text-gray-500 font-bold text-[10px] uppercase tracking-widest mb-1">Sudah Kembali</p>
                    <p class="text-4xl font-extrabold text-gray-600">{{ $sudahDikembalikan }}</p>
                </div>
            </div>
        </div>

        {{-- MAIN CONTENT --}}
        <div class="px-8">

            {{-- Toolbar --}}
            <div class="bg-white p-3 rounded-xl shadow-sm border border-gray-200 mb-6">
                <div class="flex flex-col md:flex-row justify-between items-center gap-3">
                    <form action="/peminjaman" method="GET" class="w-full md:w-[350px] relative">
                        @foreach(request()->except('search') as $key => $value) <input type="hidden" name="{{ $key }}"
                        value="{{ $value }}"> @endforeach
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400"><i
                                class="fas fa-search text-xs"></i></span>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari aktivitas, nama, atau box..."
                            class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-100 rounded-lg text-sm font-medium text-gray-600 focus:ring-1 focus:ring-[#9d1b1b] focus:bg-white outline-none transition placeholder-gray-400">
                    </form>

                    <div class="flex items-center gap-2">
                        <button x-show="selectedItems.length > 0" x-cloak
                            @click="document.getElementById('bulk-delete-form').submit()"
                            class="px-4 py-2.5 bg-[#e92027] border border-[#e92027] rounded-lg text-xs font-bold text-white hover:bg-[#c41820] transition shadow-sm flex items-center gap-2 animate-fade-in">
                            <i class="fas fa-trash-alt"></i> Hapus (<span x-text="selectedItems.length"></span>)
                        </button>
                        <div class="relative">
                            <button @click="showSortDropdown = !showSortDropdown" @click.away="showSortDropdown = false"
                                class="px-4 py-2.5 bg-white border border-gray-200 rounded-lg text-xs font-bold text-gray-600 hover:bg-gray-50 transition shadow-sm flex items-center gap-2">
                                <i class="fas fa-sort-amount-down text-gray-400"></i> Urutkan
                            </button>
                            <div x-show="showSortDropdown" style="display: none;"
                                class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-gray-100 z-50 overflow-hidden"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100">
                                <ul class="text-xs font-medium text-gray-600">
                                    <li><a href="{{ request()->fullUrlWithQuery(['sort' => 'latest_added']) }}"
<<<<<<< HEAD
                                            class="block px-4 py-2.5 hover:bg-red-50 hover:text-red-700 {{ request('sort', 'latest_added') == 'latest_added' ? 'bg-red-50 text-red-700 font-bold' : '' }}">Terbaru
                                            Ditambahkan</a></li>
                                    <li><a href="{{ request()->fullUrlWithQuery(['sort' => 'oldest_added']) }}"
                                            class="block px-4 py-2.5 hover:bg-red-50 hover:text-red-700 {{ request('sort') == 'oldest_added' ? 'bg-red-50 text-red-700 font-bold' : '' }}">Terlama
                                            Ditambahkan</a></li>
                                    <li><a href="{{ request()->fullUrlWithQuery(['sort' => 'latest_date']) }}"
                                            class="block px-4 py-2.5 hover:bg-red-50 hover:text-red-700 {{ request('sort') == 'latest_date' ? 'bg-red-50 text-red-700 font-bold' : '' }}">Tanggal
                                            Pinjam Terbaru</a></li>
                                    <li><a href="{{ request()->fullUrlWithQuery(['sort' => 'oldest_date']) }}"
                                            class="block px-4 py-2.5 hover:bg-red-50 hover:text-red-700 {{ request('sort') == 'oldest_date' ? 'bg-red-50 text-red-700 font-bold' : '' }}">Tanggal
=======
                                            class="block px-4 py-2.5 hover:bg-red-50 hover:text-[#c41820] {{ request('sort', 'latest_added') == 'latest_added' ? 'bg-red-50 text-[#c41820] font-bold' : '' }}">Terbaru
                                            Ditambahkan</a></li>
                                    <li><a href="{{ request()->fullUrlWithQuery(['sort' => 'oldest_added']) }}"
                                            class="block px-4 py-2.5 hover:bg-red-50 hover:text-[#c41820] {{ request('sort') == 'oldest_added' ? 'bg-red-50 text-[#c41820] font-bold' : '' }}">Terlama
                                            Ditambahkan</a></li>
                                    <li><a href="{{ request()->fullUrlWithQuery(['sort' => 'latest_date']) }}"
                                            class="block px-4 py-2.5 hover:bg-red-50 hover:text-[#c41820] {{ request('sort') == 'latest_date' ? 'bg-red-50 text-[#c41820] font-bold' : '' }}">Tanggal
                                            Pinjam Terbaru</a></li>
                                    <li><a href="{{ request()->fullUrlWithQuery(['sort' => 'oldest_date']) }}"
                                            class="block px-4 py-2.5 hover:bg-red-50 hover:text-[#c41820] {{ request('sort') == 'oldest_date' ? 'bg-red-50 text-[#c41820] font-bold' : '' }}">Tanggal
>>>>>>> 7d4f385849d706498d1a4faaf8f83b504a2a87f9
                                            Pinjam Terlama</a></li>
                                </ul>
                            </div>
                        </div>

                        <button @click="showSortModal = true"
                            class="px-4 py-2.5 bg-white border border-gray-200 rounded-lg text-xs font-bold text-gray-600 hover:bg-gray-50 transition shadow-sm flex items-center gap-2">
                            <i class="fas fa-filter text-gray-400"></i> Filter
                        </button>
                        <a href="/peminjaman/export?{{ http_build_query(request()->all()) }}" target="_blank"
                            class="px-4 py-2.5 bg-white border border-gray-200 rounded-lg text-xs font-bold text-gray-600 hover:bg-green-50 hover:text-green-700 hover:border-green-200 transition shadow-sm flex items-center gap-2">
                            <i class="fas fa-file-excel text-green-600"></i> Export
                        </a>
                    </div>
                </div>
            </div>

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

            {{-- Hidden Form for Bulk Delete --}}
            <form id="bulk-delete-form" action="/peminjaman/bulk-delete" method="POST" class="hidden">
                @csrf
                <template x-for="id in selectedItems">
                    <input type="hidden" name="ids[]" :value="id">
                </template>
            </form>

            {{-- TABLE --}}
            <div
                class="bg-white rounded-2xl shadow-[0_2px_15px_rgb(0,0,0,0.03)] overflow-hidden border border-gray-100">
                <div class="overflow-x-auto">
                    <table class="min-w-[2000px] w-full">
                        <thead>
                            <tr class="bg-[#e92027] text-white">
                                <th
                                    class="px-6 py-4 text-left text-[11px] font-bold uppercase tracking-wider w-14 sticky left-0 bg-[#e92027] z-20 border-r border-red-900/20">
                                    No</th>
                                <th
                                    class="px-6 py-4 text-left text-[11px] font-bold uppercase tracking-wider min-w-[150px] border-r border-red-900/20">
                                    Tanggal</th>
                                <th
                                    class="px-6 py-4 text-left text-[11px] font-bold uppercase tracking-wider min-w-[250px] border-r border-red-900/20">
                                    Peminjam</th>
                                <th
                                    class="px-6 py-4 text-left text-[11px] font-bold uppercase tracking-wider min-w-[200px] border-r border-red-900/20">
                                    NIP</th>
                                <th
                                    class="px-6 py-4 text-left text-[11px] font-bold uppercase tracking-wider w-48 border-r border-red-900/20">
                                    Jabatan</th>
                                <th
                                    class="px-6 py-4 text-left text-[11px] font-bold uppercase tracking-wider min-w-[200px] border-r border-red-900/20">
                                    Unit</th>
                                <th
                                    class="px-6 py-4 text-left text-[11px] font-bold uppercase tracking-wider min-w-[250px] border-r border-red-900/20">
                                    Keperluan</th>
                                <th
                                    class="px-6 py-4 text-left text-[11px] font-bold uppercase tracking-wider min-w-[350px] border-r border-red-900/20">
                                    Nama Arsip</th>
                                <th
                                    class="px-6 py-4 text-center text-[11px] font-bold uppercase tracking-wider w-32 border-r border-red-900/20">
                                    Akses</th>
                                <th
                                    class="px-6 py-4 text-center text-[11px] font-bold uppercase tracking-wider w-32 border-r border-red-900/20">
                                    Jenis</th>
                                <th
                                    class="px-6 py-4 text-center text-[11px] font-bold uppercase tracking-wider w-36 border-r border-red-900/20">
                                    Otentikasi</th>
                                <th
                                    class="px-6 py-4 text-center text-[11px] font-bold uppercase tracking-wider w-28 border-r border-red-900/20">
                                    Box</th>
                                <th
                                    class="px-6 py-4 text-center text-[11px] font-bold uppercase tracking-wider w-28 border-r border-red-900/20">
                                    Bukti</th>
                                <th
                                    class="px-6 py-4 text-center text-[11px] font-bold uppercase tracking-wider w-32 border-r border-red-900/20">
                                    Status</th>
                                <th
                                    class="px-3 py-4 text-center text-[11px] font-bold uppercase tracking-wider sticky right-[159px] bg-[#e92027] z-20">
                                    <input type="checkbox" @click="toggleSelectAll()" x-model="allSelected"
                                        class="rounded border-gray-300 text-[#e92027] focus:ring-[#e92027] cursor-pointer">
                                </th>
                                <th
                                    class="px-6 py-4 text-center text-[11px] font-bold uppercase tracking-wider w-40 min-w-[160px] sticky right-0 bg-[#e92027] z-20 shadow-[-4px_0_10px_rgb(0,0,0,0.1)]">
                                    Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">
                            @forelse($peminjaman as $detail)
                                <tr class="hover:bg-red-50/20 transition duration-150 group">
                                    <td
                                        class="px-6 py-4 text-gray-500 text-center text-xs font-bold sticky left-0 bg-white group-hover:bg-red-50 border-r border-gray-100">
                                        {{ $loop->iteration + ($peminjaman->currentPage() - 1) * $peminjaman->perPage() }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-600 text-xs border-r border-gray-100">
                                        {{ \Carbon\Carbon::parse($detail->peminjaman->tanggal_pinjam)->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-800 font-bold text-xs border-r border-gray-100">
                                        {{ $detail->peminjaman->nama_peminjam }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-500 font-mono text-xs border-r border-gray-100">
                                        {{ $detail->peminjaman->nip }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-600 text-xs border-r border-gray-100">
                                        {{ $detail->peminjaman->jabatan_peminjam }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-600 text-xs border-r border-gray-100">
                                        {{ $detail->peminjaman->unit_peminjam }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-500 text-xs italic border-r border-gray-100 truncate max-w-xs"
                                        title="{{ $detail->peminjaman->keperluan }}">
                                        {{ $detail->peminjaman->keperluan ?? '-' }}
                                    </td>

                                    {{-- ARSIP --}}
                                    <td class="px-6 py-4 text-gray-800 font-bold text-xs border-r border-gray-100">
                                        {{ $detail->arsip ? $detail->arsip->nama_berkas : $detail->nama_arsip }}
                                    </td>

                                    {{-- AKSES (Thematic Colors) --}}
                                    <td class="px-6 py-4 text-center border-r border-gray-100">
                                        @php
                                            $akses = $detail->arsip ? $detail->arsip->klasifikasi_keamanan : $detail->hak_akses;
                                            $aksesClass = 'bg-orange-50 text-orange-700 border-orange-200'; // Default (Cream)
                                            if ($akses === 'Rahasia')
                                                $aksesClass = 'bg-red-50 text-[#c41820] border-red-200';
                                            elseif ($akses === 'Sangat Rahasia')
                                                $aksesClass = 'bg-[#e92027] text-white border-[#e92027]';
                                        @endphp
                                        <span
                                            class="px-2.5 py-0.5 rounded-full text-[10px] font-bold border {{ $aksesClass }}">
                                            {{ $akses }}
                                        </span>
                                    </td>

                                    {{-- JENIS (Thematic Colors) --}}
                                    <td class="px-6 py-4 text-center border-r border-gray-100">
                                        @php
                                            $jenis = $detail->jenis_arsip;
                                            $jenisClass = 'bg-rose-50 text-rose-700 border-rose-200'; // Default (Pinkish)
                                            if ($jenis === 'Asli')
                                                $jenisClass = 'bg-red-50 text-[#c41820] border-red-200';
                                            elseif ($jenis === 'Copy' || $jenis === 'Salinan')
                                                $jenisClass = 'bg-orange-50 text-orange-700 border-orange-200';
                                        @endphp
                                        <span
                                            class="px-2.5 py-0.5 rounded-full text-[10px] font-bold border {{ $jenisClass }}">
                                            {{ $jenis }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 text-center text-xs text-gray-500 border-r border-gray-100">
                                        {{ $detail->detail_fisik ?? '-' }}
                                    </td>
                                    <td
                                        class="px-6 py-4 text-center text-xs font-mono font-bold text-gray-600 border-r border-gray-100">
                                        {{ ($detail->arsip && $detail->arsip->no_box) ? $detail->arsip->no_box : ($detail->no_box ?? '-') }}
                                    </td>

                                    {{-- BUKTI --}}
                                    <td class="px-6 py-4 text-center border-r border-gray-100">
                                        @if($detail->peminjaman->bukti_peminjaman)
                                            @php $files = is_array(json_decode($detail->peminjaman->bukti_peminjaman)) ? json_decode($detail->peminjaman->bukti_peminjaman) : [$detail->peminjaman->bukti_peminjaman]; @endphp
                                            <button @click="showFilesModal = true; selectedFiles = {{ json_encode($files) }}"
                                                class="w-7 h-7 rounded-lg bg-gray-50 flex items-center justify-center text-gray-500 hover:bg-[#e92027] hover:text-white transition mx-auto border border-gray-200">
                                                <i class="fas fa-paperclip text-[10px]"></i>
                                            </button>
                                        @else <span class="text-gray-300 text-[10px]">-</span> @endif
                                    </td>

                                    {{-- STATUS --}}
                                    <td class="px-6 py-4 text-center border-r border-gray-100">
                                        @if($detail->jenis_arsip != 'Softfile' && $detail->peminjaman->status == 'Sedang Dipinjam')
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold text-[#c41820] bg-red-50 border border-red-200">Dipinjam</span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold text-red-300 bg-white border border-red-100">Sudah
                                                Dikembalikan</span>
                                        @endif
                                        {{-- CHECKBOX --}}
                                    <td
                                        class="px-3 py-4 text-center border-gray-100 bg-white group-hover:bg-red-50 sticky right-[159px] shadow-[-4px_0_10px_rgb(0,0,0,0.02)]">
                                        <input type="checkbox" :value="{{ $detail->id }}" x-model="selectedItems"
                                            class="rounded border-gray-300 text-[#e92027] focus:ring-[#e92027] cursor-pointer">
                                    </td>
                                    </td>

                                    {{-- AKSI --}}
                                    <td
                                        class="px-6 py-4 text-center whitespace-nowrap sticky right-0 bg-white group-hover:bg-red-50 border-gray-100 w-40 min-w-[160px]">
                                        <div class="flex justify-center items-center gap-1.5">
                                            @if($detail->jenis_arsip != 'Softfile' && $detail->peminjaman->status == 'Sedang Dipinjam')
                                                <form action="/peminjaman/{{ $detail->peminjaman->id }}/complete" method="POST">
                                                    @csrf @method('PATCH')
                                                    <button type="submit"
                                                        class="w-7 h-7 flex items-center justify-center bg-white text-green-600 rounded-lg hover:bg-green-50 transition shadow-sm border border-gray-200 hover:border-green-200"
                                                        title="Selesai">
                                                        <i class="fas fa-check text-[10px]"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <button disabled
                                                    class="w-7 h-7 flex items-center justify-center bg-gray-50 text-gray-300 rounded-lg border border-gray-100 cursor-not-allowed"
                                                    title="Sudah Selesai">
                                                    <i class="fas fa-check text-[10px]"></i>
                                                </button>
                                            @endif
                                            <a href="/peminjaman/{{ $detail->peminjaman->id }}/edit"
                                                class="w-7 h-7 flex items-center justify-center bg-white text-amber-500 rounded-lg hover:bg-amber-50 transition shadow-sm border border-gray-200 hover:border-amber-200"
                                                title="Edit">
                                                <i class="fas fa-pen text-[10px]"></i>
                                            </a>
                                            <button
                                                @click="showDeleteModal = true; deleteUrl = '/peminjaman/{{ $detail->peminjaman->id }}'"
                                                class="w-7 h-7 flex items-center justify-center bg-white text-[#e92027] rounded-lg hover:bg-red-50 transition shadow-sm border border-gray-200 hover:border-red-200"
                                                title="Hapus">
                                                <i class="fas fa-trash-alt text-[10px]"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="15"
                                        class="px-6 py-12 text-center text-gray-400 italic bg-gray-50/50 text-xs">Tidak ada
                                        data arsip peminjaman ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- PAGINATION --}}
            <div class="mt-6 mb-10">
                {{ $peminjaman->links() }}
            </div>

        </div>

        {{-- MODALS (UNCHANGED LOGIC, JUST STYLING) --}}
        {{-- Filter Modal --}}
        <div x-show="showSortModal" style="display: none;"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
            <div @click.away="showSortModal = false"
                class="bg-white rounded-3xl shadow-2xl w-full max-w-md p-8 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-2 bg-[#e92027]"></div>
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-gray-800">Filter Data</h3>
                    <button @click="showSortModal = false" class="text-gray-400 hover:text-gray-600"><i
                            class="fas fa-times text-lg"></i></button>
                </div>
                <form action="/peminjaman" method="GET" class="space-y-6">
                    @if(request('search')) <input type="hidden" name="search" value="{{ request('search') }}"> @endif

                    {{-- Status --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Status
                            Peminjaman</label>
                        <div class="grid grid-cols-3 gap-3">
                            @foreach(['All' => 'Semua', 'Sedang Dipinjam' => 'Dipinjam', 'Sudah Dikembalikan' => 'Kembali'] as $val => $lbl)
                                <label class="cursor-pointer group">
                                    <input type="radio" name="status" value="{{ $val }}" class="hidden"
                                        x-model="filterStatus">
                                    <div class="text-center py-3 px-2 rounded-xl border text-xs font-bold transition duration-200"
                                        :class="filterStatus == '{{ $val }}' ? 'bg-[#e92027] text-white border-[#e92027] shadow-md' : 'bg-gray-50 text-gray-500 border-gray-100 hover:bg-red-50 hover:border-red-200'">
                                        {{ $lbl }}
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Hak Akses --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Hak
                            Akses</label>
                        <div class="grid grid-cols-4 gap-2">
                            @foreach(['All' => 'Semua', 'Biasa' => 'Biasa', 'Terbatas' => 'Terbatas', 'Rahasia' => 'Rahasia'] as $val => $lbl)
                                <label class="cursor-pointer">
                                    <input type="radio" name="keamanan" value="{{ $val }}" class="hidden"
                                        x-model="filterKeamanan">
                                    <div class="text-center py-2 px-1 rounded-xl border text-[10px] font-bold transition duration-200"
                                        :class="filterKeamanan == '{{ $val }}' ? 'bg-[#e92027] text-white border-[#e92027] shadow-md' : 'bg-gray-50 text-gray-500 border-gray-100 hover:bg-red-50 hover:border-red-200'">
                                        {{ $lbl }}
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Media --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Jenis
                            Arsip</label>
                        <div class="grid grid-cols-3 gap-3">
                            @foreach(['All' => 'Semua', 'Hardfile' => 'Hardfile', 'Softfile' => 'Softfile'] as $val => $lbl)
                                <label class="cursor-pointer">
                                    <input type="radio" name="media" value="{{ $val }}" class="hidden"
                                        x-model="filterMedia">
                                    <div class="text-center py-3 px-2 rounded-xl border text-xs font-bold transition duration-200"
                                        :class="filterMedia == '{{ $val }}' ? 'bg-[#e92027] text-white border-[#e92027] shadow-md' : 'bg-gray-50 text-gray-500 border-gray-100 hover:bg-red-50 hover:border-red-200'">
                                        {{ $lbl }}
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Tanggal --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Rentang
                            Tanggal</label>
                        <div class="flex items-center gap-3">
                            <input type="date" name="start_date" value="{{ request('start_date') }}"
                                class="w-full border border-gray-200 bg-gray-50 rounded-xl p-3 text-xs text-gray-700 focus:border-[#e92027] focus:ring-1 focus:ring-[#9d1b1b] outline-none transition">
                            <span class="text-gray-300 font-bold">-</span>
                            <input type="date" name="end_date" value="{{ request('end_date') }}"
                                class="w-full border border-gray-200 bg-gray-50 rounded-xl p-3 text-xs text-gray-700 focus:border-[#e92027] focus:ring-1 focus:ring-[#9d1b1b] outline-none transition">
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 pt-6 border-t border-gray-100 mt-2">
                        <a href="/peminjaman"
                            class="px-6 py-3 rounded-xl text-xs font-bold text-gray-500 hover:bg-gray-100 transition">Reset</a>
                        <button type="submit"
                            class="px-8 py-3 bg-[#e92027] text-white rounded-xl text-xs font-bold hover:bg-[#a0131a] shadow-lg transform hover:scale-105 transition">Terapkan
                            Filter</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Files Modal --}}
        <div x-show="showFilesModal" style="display: none;"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 backdrop-blur-sm p-4">
            <div @click.away="showFilesModal = false"
                class="bg-white rounded-3xl shadow-2xl overflow-hidden max-w-2xl w-full max-h-[80vh] flex flex-col relative">
                <div class="bg-gray-50 px-6 py-4 flex justify-between items-center border-b border-gray-100">
                    <h3 class="font-bold text-gray-800">Bukti Peminjaman</h3>
                    <button @click="showFilesModal = false"
                        class="w-8 h-8 rounded-full bg-white text-gray-400 hover:text-[#e92027] flex items-center justify-center shadow-sm"><i
                            class="fas fa-times"></i></button>
                </div>
                <div class="p-6 overflow-y-auto flex-1 bg-white grid gap-4">
                    <template x-for="(file, index) in selectedFiles" :key="index">
                        <div
                            class="flex items-center justify-between p-4 bg-gray-50 border border-gray-100 rounded-2xl hover:border-red-100 transition">
                            <div class="flex items-center gap-4 overflow-hidden">
                                <div
                                    class="w-10 h-10 rounded-xl bg-red-100 flex items-center justify-center text-[#e92027]">
                                    <i class="fas fa-file-alt text-lg"></i>
                                </div>
                                <span x-text="file.split('/').pop()"
                                    class="text-sm truncate font-medium text-gray-700"></span>
                            </div>
                            <a :href="`{{ asset('') }}${file}`" target="_blank"
                                class="px-4 py-2 text-xs font-bold text-[#c41820] bg-red-50 rounded-xl hover:bg-[#e92027] hover:text-white transition">Download</a>
                        </div>
                    </template>
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
                    <i class="fas fa-trash-alt text-3xl"></i>
                </div>
                <h3 class="text-xl font-extrabold text-gray-800 mb-2">Hapus Transaksi?</h3>
                <p class="text-gray-500 mb-8 leading-relaxed">Data peminjaman beserta detail arsipnya akan dihapus
                    permanen.</p>
                <div class="flex flex-col gap-3">
                    <form :action="deleteUrl" method="POST" class="w-full">
                        @csrf @method('DELETE')
                        <button
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
