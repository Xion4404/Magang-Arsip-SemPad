<x-layout>
    <!-- Background Header -->
    <div class="bg-gradient-to-r from-red-900 to-red-800 text-white pb-32 pt-10 px-6 rounded-b-[3rem] shadow-2xl relative overflow-hidden">
         <!-- Ornamental Background Pattern -->
         <div class="absolute top-0 right-0 opacity-10 transform translate-x-1/4 -translate-y-1/4">
             <svg width="400" height="400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0L24 12L12 24L0 12L12 0Z" /></svg>
         </div>
         
         <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center relative z-10 gap-6">
            <div class="text-center md:text-left">
                 <h2 class="text-4xl font-extrabold tracking-tight mb-2">Monitoring Kinerja</h2>
                 <p class="text-red-100 text-base font-light opacity-90 max-w-lg">Pantau progres dan aktivitas pengarsipan karyawan secara real-time.</p>
            </div>
            <a href="{{ route('monitoring.create') }}" class="group bg-white text-red-800 hover:bg-gray-50 px-8 py-3 rounded-full font-bold shadow-xl flex items-center gap-3 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-2xl">
                <div class="bg-red-100 p-1.5 rounded-full group-hover:bg-red-200 transition-colors">
                    <svg class="w-5 h-5 text-red-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                </div>
                <span>ISI FORMULIR</span>
            </a>
        </div>
    </div>

    <!-- Floating Card Container -->
    <div class="max-w-7xl mx-auto px-4 -mt-20 relative z-20 mb-12">
        
        <!-- Stats Row -->
        <div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4 mb-6">
            <!-- Card 1: Total -->
            <div class="bg-white p-4 rounded-2xl shadow-lg border border-red-50 flex flex-col items-center justify-center h-32 hover:-translate-y-1 transition-transform duration-300 group">
                <h2 class="text-red-800 font-bold text-xs mb-1 uppercase tracking-wider group-hover:text-red-600">Total Arsip</h2>
                <p class="text-3xl font-black text-gray-800">{{ $total }}</p>
            </div>
            <!-- Card 2: Bulan Ini -->
            <div class="bg-white p-4 rounded-2xl shadow-lg border border-red-50 flex flex-col items-center justify-center h-32 hover:-translate-y-1 transition-transform duration-300 group">
                <h2 class="text-red-800 font-bold text-xs mb-1 uppercase tracking-wider group-hover:text-red-600">Bulan Ini</h2>
                <p class="text-3xl font-black text-gray-800">{{ $bulanIni }}</p>
            </div>
            <!-- Card 3: Pemilahan -->
            <div class="bg-white p-4 rounded-2xl shadow-lg border border-red-50 flex flex-col items-center justify-center h-32 hover:-translate-y-1 transition-transform duration-300 group">
                <h3 class="text-orange-700 font-bold text-xs mb-1 uppercase tracking-wider group-hover:text-orange-600">Pemilahan</h3>
                <p class="text-3xl font-black text-gray-800">{{ $pemilahan }}</p>
            </div>
            <!-- Card 4: Pendataan -->
            <div class="bg-white p-4 rounded-2xl shadow-lg border border-red-50 flex flex-col items-center justify-center h-32 hover:-translate-y-1 transition-transform duration-300 group">
                <h3 class="text-orange-700 font-bold text-xs mb-1 uppercase tracking-wider group-hover:text-blue-600">Pendataan</h3>
                <p class="text-3xl font-black text-gray-800">{{ $pendataan }}</p>
            </div>
            <!-- Card 5: Pelabelan -->
            <div class="bg-white p-4 rounded-2xl shadow-lg border border-red-50 flex flex-col items-center justify-center h-32 hover:-translate-y-1 transition-transform duration-300 group">
                <h3 class="text-orange-700 font-bold text-xs mb-1 uppercase tracking-wider group-hover:text-indigo-600">Pelabelan</h3>
                <p class="text-3xl font-black text-gray-800">{{ $pelabelan }}</p>
            </div>
            <!-- Card 6: Input E-Arsip -->
            <div class="bg-white p-4 rounded-2xl shadow-lg border border-red-50 flex flex-col items-center justify-center h-32 hover:-translate-y-1 transition-transform duration-300 group">
                <h3 class="text-orange-700 font-bold text-xs mb-1 uppercase tracking-wider group-hover:text-emerald-600">E-Arsip</h3>
                <p class="text-3xl font-black text-gray-800">{{ $inputEArsip }}</p>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100 min-h-[600px] flex flex-col">
            
            <!-- Filters & Toolbar -->
            <div class="p-6 border-b border-gray-100 bg-white flex flex-col lg:flex-row gap-4 justify-between items-center sticky top-0 z-30">
                <!-- Search & Filters -->
                <div class="flex flex-col md:flex-row gap-4 w-full justify-between items-center">
                    <!-- Search -->
                    <div class="relative w-full md:w-96 group">
                         <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400 group-focus-within:text-red-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                         </span>
                         <input type="text" id="searchInput" value="{{ request('search') }}" placeholder="Cari aktivitas..." class="w-full py-3 pl-12 pr-4 bg-gray-50 border border-gray-200 rounded-full focus:outline-none focus:ring-2 focus:ring-red-500 focus:bg-white focus:border-transparent text-sm font-medium transition-all shadow-sm hover:shadow-md hover:border-red-300 filter-input">
                    </div>

                    <!-- Dropdowns -->
                    <div class="flex gap-3 w-full md:w-auto overflow-x-auto pb-2 md:pb-0 hide-scrollbar scroll-smooth">
                        <select id="picFilter" class="bg-white border border-gray-200 text-gray-700 text-sm rounded-full focus:ring-2 focus:ring-red-500 focus:border-transparent block px-5 py-3 filter-input cursor-pointer hover:bg-gray-50 hover:border-red-300 hover:shadow-md transition-all shadow-sm min-w-[150px] appearance-none">
                             <option value="">Semua PIC</option>
                             @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ request('pic') == $user->id ? 'selected' : '' }}>{{ $user->nama }}</option>
                             @endforeach
                        </select>
                        
                        <select id="tahapanFilter" class="bg-white border border-gray-200 text-gray-700 text-sm rounded-full focus:ring-2 focus:ring-red-500 focus:border-transparent block px-5 py-3 filter-input cursor-pointer hover:bg-gray-50 hover:border-red-300 hover:shadow-md transition-all shadow-sm min-w-[170px] appearance-none">
                             <option value="">Semua Tahapan</option>
                             <option value="Pemilahan" {{ request('tahapan') == 'Pemilahan' ? 'selected' : '' }}>Pemilahan</option>
                             <option value="Pendataan" {{ request('tahapan') == 'Pendataan' ? 'selected' : '' }}>Pendataan</option>
                             <option value="Pelabelan" {{ request('tahapan') == 'Pelabelan' ? 'selected' : '' }}>Pelabelan</option>
                             <option value="Input E-Arsip" {{ request('tahapan') == 'Input E-Arsip' ? 'selected' : '' }}>Input E-Arsip</option>
                        </select>
                         
                         <!-- Reset -->
                         @if(request('search') || request('pic') || request('tahapan'))
                            <a href="{{ route('monitoring.index') }}" class="flex items-center px-5 py-3 bg-red-50 text-red-600 rounded-full text-sm font-bold hover:bg-red-100 transition shadow-sm whitespace-nowrap hover:shadow-md">
                                Reset
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Table Container -->
            <div class="p-6 flex-grow overflow-x-auto">
                <div class="overflow-hidden rounded-2xl border border-gray-200 shadow-sm">
                    <table class="w-full text-sm text-center border-collapse">
                        <thead>
                            <tr class="bg-[#8B1A1A] text-white">
                                <th class="py-5 px-6 font-bold text-xs uppercase tracking-wider first:rounded-tl-xl text-center">PIC</th>
                                <th class="py-5 px-6 font-bold text-xs uppercase tracking-wider text-center">Tahapan</th>
                                <th class="py-5 px-6 font-bold text-xs uppercase tracking-wider text-center">Tanggal</th>
                                <th class="py-5 px-6 font-bold text-xs uppercase tracking-wider text-center">No. Berita Acara</th>
                                <th class="py-5 px-6 font-bold text-xs uppercase tracking-wider text-center">Unit Kerja</th>
                                <th class="py-5 px-6 font-bold text-xs uppercase tracking-wider text-center">Box Selesai</th>
                                <th class="py-5 px-6 font-bold text-xs uppercase tracking-wider text-center">Keterangan</th>
                                <th class="py-5 px-6 font-bold text-xs uppercase tracking-wider text-center last:rounded-tr-xl">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="monitoringTableBody" class="divide-y divide-gray-100 bg-white">
                            @forelse($monitoring as $index => $item)
                            <tr class="hover:bg-red-50/50 transition duration-200 group">
                                <td class="py-4 px-6 font-semibold text-gray-800 border-l-4 border-transparent group-hover:border-red-500 transition-all text-center">
                                    {{ $item->user->nama ?? '-' }}
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <form action="{{ route('monitoring.advance-stage', $item->id) }}" method="POST" class="inline-block advance-form">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" 
                                            class="px-4 py-1.5 rounded-full text-xs font-extra bold shadow-sm transition-all duration-200 border transform hover:scale-105
                                            {{ $item->tahapan == 'Pemilahan' ? 'bg-orange-50 text-orange-700 border-orange-200 hover:bg-orange-100' : '' }}
                                            {{ $item->tahapan == 'Pendataan' ? 'bg-blue-50 text-blue-700 border-blue-200 hover:bg-blue-100' : '' }}
                                            {{ $item->tahapan == 'Pelabelan' ? 'bg-indigo-50 text-indigo-700 border-indigo-200 hover:bg-indigo-100' : '' }}
                                            {{ $item->tahapan == 'Input E-Arsip' ? 'bg-emerald-50 text-emerald-700 border-emerald-200 cursor-default hover:scale-100' : '' }}"
                                            title="Klik untuk lanjut ke tahapan berikutnya"
                                            data-current="{{ $item->tahapan }}"
                                            {{ $item->tahapan == 'Input E-Arsip' ? 'disabled' : '' }}
                                        >
                                            {{ $item->tahapan }}
                                        </button>
                                    </form>
                                </td>
                                <td class="py-4 px-6 text-gray-600 text-center">
                                    {{ \Carbon\Carbon::parse($item->tanggal_kerja)->format('d/m/Y') }}
                                </td>
                                <td class="py-4 px-6 text-gray-800 font-medium text-center">
                                    {{ $item->nba }}
                                </td>
                                <td class="py-4 px-6 text-gray-600 text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        {{ $item->unit_kerja }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <span class="bg-red-50 text-red-700 py-1 px-2.5 rounded-md text-xs font-bold shadow-sm border border-red-100">
                                        {{ $item->jumlah_box_selesai }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-gray-500 text-xs italic text-center max-w-[200px] truncate">
                                    {{ $item->keterangan ?: '-' }}
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <div class="flex items-center justify-center gap-3">
                                        <a href="{{ route('monitoring.edit', $item->id) }}" class="p-2 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-colors" title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                        </a>
                                        <form action="{{ route('monitoring.destroy', $item->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="delete-btn p-2 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="py-12 text-center">
                                    <div class="flex flex-col items-center justify-center text-gray-500">
                                        <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                                        <p class="text-lg font-medium">Belum ada data monitoring</p>
                                        <p class="text-sm">Silakan isi formulir baru</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            
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
                            title: 'Hapus Data?',
                            text: "Data yang dihapus tidak dapat dikembalikan!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#8B1A1A',
                            cancelButtonColor: '#E5E7EB',
                            confirmButtonText: 'Ya, Hapus',
                            cancelButtonText: 'Batal',
                            customClass: {
                                cancelButton: 'text-gray-700 font-bold'
                            }
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
                     // Clone to clear listeners
                    const newForm = form.cloneNode(true);
                    form.parentNode.replaceChild(newForm, form);

                    newForm.addEventListener('submit', function(e) {
                        e.preventDefault();
                        const btn = this.querySelector('button');
                        const currentStage = btn.getAttribute('data-current');
                        
                        let nextStage = '';
                        if(currentStage === 'Pemilahan') nextStage = 'Pendataan';
                        else if(currentStage === 'Pendataan') nextStage = 'Pelabelan';
                        else if(currentStage === 'Pelabelan') nextStage = 'Input E-Arsip';
                        
                        if (!nextStage) return; 
 
                        Swal.fire({
                            title: 'Lanjutkan Tahapan?',
                            text: `Ubah status dari ${currentStage} ke ${nextStage}?`,
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonColor: '#8B1A1A',
                            cancelButtonColor: '#E5E7EB',
                            confirmButtonText: 'Ya, Lanjutkan',
                            cancelButtonText: 'Batal',
                            customClass: {
                                cancelButton: 'text-gray-700 font-bold'
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                this.submit();
                            }
                        });
                    });
                });
            }
 
            // Initial attach
            attachDeleteListeners();
            attachAdvanceListeners();
 
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
                
                tableBody.classList.add('opacity-50');

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
                    tableBody.classList.remove('opacity-50');
                })
                .catch(error => {
                    console.error('Error:', error);
                    tableBody.classList.remove('opacity-50');
                });
            }

            searchInput.addEventListener('input', function() {
                clearTimeout(timeout);
                timeout = setTimeout(fetchData, 400);
            });
 
            picFilter.addEventListener('change', fetchData);
            tahapanFilter.addEventListener('change', fetchData);
        });
    </script>
</x-layout>