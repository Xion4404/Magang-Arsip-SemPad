<x-layout>
    <div class="bg-[#8B1A1A] text-white p-6 rounded-xl shadow-lg mb-8 relative overflow-hidden">
        <div class="absolute top-0 right-0 p-4 opacity-10">
             <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14z"/><path d="M7 12h2v5H7zm4-3h2v8h-2zm4-3h2v11h-2z"/></svg>
        </div>
        <h2 class="text-2xl font-bold relative z-10">Monitoring Kerja Karyawan</h2>
    </div>

    <!-- Stats -->
    <!-- Stats -->
    <!-- Stats -->
    <div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4 mb-8">
        <!-- Card 1: Total -->
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-red-100 flex flex-col items-center justify-center h-32 hover:shadow-md transition">
            <h3 class="text-[#8B1A1A] font-bold text-sm mb-1 uppercase tracking-wider">Total</h3>
            <p class="text-3xl font-extrabold text-gray-800">{{ $total }}</p>
        </div>
        <!-- Card 2: Bulan Ini -->
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-red-100 flex flex-col items-center justify-center h-32 hover:shadow-md transition">
            <h3 class="text-[#8B1A1A] font-bold text-sm mb-1 uppercase tracking-wider">Bulan Ini</h3>
            <p class="text-3xl font-extrabold text-gray-800">{{ $bulanIni }}</p>
        </div>
        <!-- Card 3: Pemilahan -->
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-red-100 flex flex-col items-center justify-center h-32 hover:shadow-md transition">
            <h3 class="text-[#8B1A1A] font-bold text-sm mb-1 uppercase tracking-wider">Pemilahan</h3>
            <p class="text-3xl font-extrabold text-gray-800">{{ $pemilahan }}</p>
        </div>
        <!-- Card 4: Pendataan -->
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-red-100 flex flex-col items-center justify-center h-32 hover:shadow-md transition">
            <h3 class="text-[#8B1A1A] font-bold text-sm mb-1 uppercase tracking-wider">Pendataan</h3>
            <p class="text-3xl font-extrabold text-gray-800">{{ $pendataan }}</p>
        </div>
        <!-- Card 5: Pelabelan -->
        <div class="bg-white p-4 rounded-2xl shadow-sm border border-red-100 flex flex-col items-center justify-center h-32 hover:shadow-md transition">
            <h3 class="text-[#8B1A1A] font-bold text-sm mb-1 uppercase tracking-wider">Pelabelan</h3>
            <p class="text-3xl font-extrabold text-gray-800">{{ $pelabelan }}</p>
        </div>
    </div>

    <!-- Toolbar -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <div class="flex items-center gap-3 w-full md:w-auto flex-wrap">
             <div class="relative w-full md:w-64">
                <form action="{{ route('monitoring.index') }}" method="GET" onsubmit="return false;">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </span>
                    <input type="text" id="searchInput" name="search" value="{{ request('search') }}" placeholder="Cari..." class="w-full py-2.5 pl-10 pr-4 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#8B1A1A] text-sm bg-white" autocomplete="off">
                </form>
             </div>
             
             <!-- Filters -->
             <!-- Filters -->
             <div class="flex items-center gap-2">
                 <select id="picFilter" class="bg-[#5c1313] hover:bg-[#4a0f0f] text-white px-4 py-2.5 rounded-lg text-sm font-medium focus:outline-none cursor-pointer border-none">
                     <option value="" class="bg-white text-gray-800">Semua PIC</option>
                     @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ request('pic') == $user->id ? 'selected' : '' }} class="bg-white text-gray-800">{{ $user->nama }}</option>
                     @endforeach
                 </select>

                 <select id="tahapanFilter" class="bg-[#5c1313] hover:bg-[#4a0f0f] text-white px-4 py-2.5 rounded-lg text-sm font-medium focus:outline-none cursor-pointer border-none">
                     <option value="" class="bg-white text-gray-800">Semua Tahapan</option>
                     <option value="Pemilahan" {{ request('tahapan') == 'Pemilahan' ? 'selected' : '' }} class="bg-white text-gray-800">Pemilahan</option>
                     <option value="Pendataan" {{ request('tahapan') == 'Pendataan' ? 'selected' : '' }} class="bg-white text-gray-800">Pendataan</option>
                     <option value="Pelabelan" {{ request('tahapan') == 'Pelabelan' ? 'selected' : '' }} class="bg-white text-gray-800">Pelabelan</option>
                     <option value="Input E Arsip" {{ request('tahapan') == 'Input E Arsip' ? 'selected' : '' }} class="bg-white text-gray-800">Input E Arsip</option>
                 </select>
             </div>
        </div>

        <a href="{{ route('monitoring.create') }}" class="bg-[#8B1A1A] hover:bg-[#7a1616] text-white px-6 py-2.5 rounded-lg font-bold shadow-md flex items-center gap-2 transition transform hover:scale-105">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Isi Formulir
        </a>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-red-100">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-center">
                <thead class="bg-white border-b border-red-100">
                    <tr>
                        <th class="py-5 px-4 font-bold text-gray-900 tracking-wide">No</th>
                        <th class="py-5 px-4 font-bold text-gray-900 tracking-wide md:border-l border-red-50">PIC</th>
                        <th class="py-5 px-4 font-bold text-gray-900 tracking-wide border-l border-red-50">
                            Tahapan Pengarsipan
                            <span class="block text-xs text-gray-400 font-normal mt-1">(Klik tombol untuk lanjut)</span>
                        </th>
                        <th class="py-5 px-4 font-bold text-gray-900 tracking-wide border-l border-red-50">Tanggal Kerja</th>
                        <th class="py-5 px-4 font-bold text-gray-900 tracking-wide border-l border-red-50">Unit Kerja</th>
                        <th class="py-5 px-4 font-bold text-gray-900 tracking-wide border-l border-red-50">Nomor Box</th>
                        <th class="py-5 px-4 font-bold text-gray-900 tracking-wide border-l border-red-50">Nama Berkas</th>
                        <th class="py-5 px-4 font-bold text-gray-900 tracking-wide border-l border-red-50">Jumlah Box Selesai</th>
                        <th class="py-5 px-4 font-bold text-gray-900 tracking-wide border-l border-red-50">Keterangan</th>
                        <th class="py-5 px-4 font-bold text-gray-900 tracking-wide border-l border-red-50">Aksi</th>
                    </tr>
                </thead>
                <tbody id="monitoringTableBody" class="divide-y divide-red-50 bg-[#FFF5F5]">
                    @forelse($monitoring as $index => $item)
                    @php
                        // Parse "Pengerjaan Box: X" and "Berkas: Y" from keterangan
                        $keterangan = $item->keterangan;
                        $noBox = '-';
                        $namaBerkas = '-';
                        
                        // Parse Box
                        if (preg_match('/Pengerjaan Box:\s*([^\s|]+)/', $keterangan, $matches)) {
                            $noBox = $matches[1];
                            $keterangan = str_replace($matches[0], '', $keterangan);
                        }
                        
                        // Parse Berkas
                        if (preg_match('/Berkas:\s*([^|]+)/', $keterangan, $matches)) {
                            $namaBerkas = trim($matches[1]);
                            $keterangan = str_replace($matches[0], '', $keterangan);
                        }

                        // Clean cleanup
                        $keteranganDisplay = trim($keterangan, " |");
                    @endphp
                    <tr class="hover:bg-red-50 transition duration-150 ease-in-out">
                        <td class="py-4 px-4 text-[#8B1A1A] font-medium">{{ $loop->iteration }}</td>
                        <td class="py-4 px-4 text-[#8B1A1A] font-medium">{{ $item->user->nama ?? '-' }}</td>
                        <td class="py-4 px-4 text-[#8B1A1A]">
                            <form action="{{ route('monitoring.advance-stage', $item->id) }}" method="POST" class="inline-block advance-form">
                                @csrf
                                @method('PATCH')
                                <button type="submit" 
                                    class="px-4 py-1.5 rounded-full text-xs font-semibold shadow-sm transition-all duration-200 border
                                    {{ $item->tahapan == 'Pemilahan' ? 'bg-orange-50 text-orange-700 border-orange-200 hover:bg-orange-100' : '' }}
                                    {{ $item->tahapan == 'Pendataan' ? 'bg-blue-50 text-blue-700 border-blue-200 hover:bg-blue-100' : '' }}
                                    {{ $item->tahapan == 'Pelabelan' ? 'bg-indigo-50 text-indigo-700 border-indigo-200 hover:bg-indigo-100' : '' }}
                                    {{ $item->tahapan == 'Input E Arsip' ? 'bg-emerald-50 text-emerald-700 border-emerald-200 cursor-default' : '' }}"
                                    title="Klik untuk lanjut ke tahapan berikutnya"
                                    data-current="{{ $item->tahapan }}"
                                    {{ $item->tahapan == 'Input E Arsip' ? 'disabled' : '' }}
                                >
                                    {{ $item->tahapan }}
                                </button>
                            </form>
                        </td>
                        <td class="py-4 px-4 text-[#8B1A1A]">{{ \Carbon\Carbon::parse($item->tanggal_kerja)->format('d/m/Y') }}</td>
                        <td class="py-4 px-4 text-[#8B1A1A]">{{ $item->unit_kerja }}</td>
                        <td class="py-4 px-4 text-[#8B1A1A]">{{ $noBox }}</td>
                        <td class="py-4 px-4 text-[#8B1A1A]">{{ $namaBerkas }}</td>
                        <td class="py-4 px-4 text-[#8B1A1A]">{{ $item->jumlah_box_selesai }}</td>
                        <td class="py-4 px-4 text-[#8B1A1A]">{{ $keteranganDisplay ?: '-' }}</td>
                        <td class="py-4 px-4 text-[#8B1A1A]">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('monitoring.edit', $item->id) }}" class="text-blue-600 hover:text-blue-800" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                <form action="{{ route('monitoring.destroy', $item->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="text-red-600 hover:text-red-800 delete-btn" title="Hapus">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="py-10 text-gray-500 italic">Belum ada data monitoring.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-8 flex justify-center items-center gap-2">
        <span class="text-xs text-gray-400 font-medium">Previous</span>
        <button class="w-8 h-8 flex items-center justify-center bg-[#8B1A1A] text-white rounded shadow text-xs font-bold">1</button>
        <button class="w-8 h-8 flex items-center justify-center bg-red-100 text-[#8B1A1A] rounded shadow text-xs font-bold hover:bg-red-200">2</button>
        <button class="w-8 h-8 flex items-center justify-center bg-red-100 text-[#8B1A1A] rounded shadow text-xs font-bold hover:bg-red-200">3</button>
        <span class="text-xs text-gray-400 font-medium">Next</span>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Delete Confirmation
            const deleteButtons = document.querySelectorAll('.delete-btn');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const form = this.closest('form');
                    
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Data yang dihapus tidak dapat dikembalikan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#8B1A1A',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });

            const searchInput = document.getElementById('searchInput');
            const picFilter = document.getElementById('picFilter');
            const tahapanFilter = document.getElementById('tahapanFilter');
            const tableBody = document.getElementById('monitoringTableBody');
            let timeout = null;

            function fetchData() {
                const query = searchInput.value;
                const pic = picFilter.value;
                const tahapan = tahapanFilter.value;

                const params = new URLSearchParams();
                if(query) params.append('search', query);
                if(pic) params.append('pic', pic);
                if(tahapan) params.append('tahapan', tahapan);

                const url = `{{ route('monitoring.index') }}?${params.toString()}`;
                
                window.history.pushState({path: url}, '', url);

                fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newTbody = doc.getElementById('monitoringTableBody');
                    
                    if (newTbody) {
                        tableBody.innerHTML = newTbody.innerHTML;
                        // Re-attach listeners
                        attachDeleteListeners();
                        attachAdvanceListeners();
                    }
                })
                .catch(error => console.error('Error fetching data:', error));
            }
            
            function attachDeleteListeners() {
                const deleteButtons = document.querySelectorAll('.delete-btn');
                deleteButtons.forEach(button => {
                     // Remove old listeners to avoid duplicates if any
                    const newBtn = button.cloneNode(true);
                    button.parentNode.replaceChild(newBtn, button);

                    newBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        const form = this.closest('form');
                        
                        Swal.fire({
                            title: 'Apakah Anda yakin?',
                            text: "Data yang dihapus tidak dapat dikembalikan!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#8B1A1A',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Ya, hapus!',
                            cancelButtonText: 'Batal'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                form.submit();
                            }
                        });
                    });
                });
            }

            // Advance Stage Confirmation
            function attachAdvanceListeners() {
                const advanceForms = document.querySelectorAll('.advance-form');
                advanceForms.forEach(form => {
                    form.addEventListener('submit', function(e) {
                        e.preventDefault();
                        const btn = this.querySelector('button');
                        const currentStage = btn.getAttribute('data-current');
                        
                        let nextStage = '';
                        if(currentStage === 'Pemilahan') nextStage = 'Pendataan';
                        else if(currentStage === 'Pendataan') nextStage = 'Pelabelan';
                        else if(currentStage === 'Pelabelan') nextStage = 'Input E Arsip';
                        
                        if (!nextStage) return; 

                        Swal.fire({
                            title: 'Lanjutkan Tahapan?',
                            text: `Ubah status dari ${currentStage} ke ${nextStage}?`,
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonColor: '#8B1A1A',
                            cancelButtonColor: '#6c757d',
                            confirmButtonText: 'Ya, Lanjutkan',
                            cancelButtonText: 'Batal'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                this.submit();
                            }
                        });
                    });
                });
            }

            // Initial attach
            attachAdvanceListeners();

            searchInput.addEventListener('input', function() {
                clearTimeout(timeout);
                timeout = setTimeout(fetchData, 300);
            });

            picFilter.addEventListener('change', fetchData);
            tahapanFilter.addEventListener('change', fetchData);
        });
    </script>
</x-layout>