<x-layout>
    <!-- Background Header -->
    <div class="bg-gradient-to-r from-red-900 to-red-800 text-white pb-32 pt-10 px-6 rounded-b-[3rem] shadow-2xl relative overflow-hidden">
         <!-- Ornamental Background Pattern -->
         <div class="absolute top-0 right-0 opacity-10 transform translate-x-1/4 -translate-y-1/4">
             <svg width="400" height="400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0L24 12L12 24L0 12L12 0Z" /></svg>
         </div>
         
         <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center relative z-10 gap-6">
            <div class="text-center md:text-left">
                 <h2 class="text-4xl font-extrabold tracking-tight mb-2">Daftar Arsip Masuk</h2>
                 <p class="text-red-100 text-base font-light opacity-90 max-w-lg">Kelola dan monitor seluruh dokumen arsip perusahaan dengan mudah dan efisien di satu tempat.</p>
            </div>
            <a href="{{ route('arsip-masuk.create') }}" class="group bg-white text-red-800 hover:bg-gray-50 px-8 py-3 rounded-full font-bold shadow-xl flex items-center gap-3 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-2xl">
                <div class="bg-red-100 p-1.5 rounded-full group-hover:bg-red-200 transition-colors">
                    <svg class="w-5 h-5 text-red-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                </div>
                <span>TAMBAH ARSIP</span>
            </a>
        </div>
    </div>

    <!-- Floating Card Container -->
    <div class="max-w-7xl mx-auto px-4 -mt-20 relative z-20 mb-12">
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100 min-h-[600px] flex flex-col">
            
            <!-- Filters & Toolbar -->
            <div class="p-6 border-b border-gray-100 bg-white flex flex-col lg:flex-row gap-4 justify-between items-center sticky top-0 z-30">
                <!-- Search & Filters -->
                <div class="flex flex-col md:flex-row gap-4 w-full lg:w-auto items-center">
                    <!-- Search -->
                    <div class="relative w-full md:w-80 group">
                         <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400 group-focus-within:text-red-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                         </span>
                         <input type="text" id="searchInput" value="{{ request('search') }}" placeholder="Cari dokumen..." class="w-full py-3 pl-12 pr-4 bg-gray-50 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:bg-white focus:border-transparent text-sm font-medium transition-all shadow-sm filter-input">
                    </div>

                    <!-- Dropdowns -->
                    <div class="flex gap-3 w-full md:w-auto overflow-x-auto pb-2 md:pb-0 hide-scrollbar scroll-smooth">
                        <select id="unitAsalFilter" class="bg-white border border-gray-200 text-gray-700 text-sm rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent block px-4 py-2.5 filter-input cursor-pointer hover:bg-gray-50 transition-all shadow-sm min-w-[140px]">
                            <option value="">Semua Unit</option>
                            @foreach($unitAsalOptions as $unit)
                                <option value="{{ $unit }}" {{ request('unit_asal') == $unit ? 'selected' : '' }}>{{ $unit }}</option>
                            @endforeach
                        </select>
                        
                        <select id="yearFilter" class="bg-white border border-gray-200 text-gray-700 text-sm rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent block px-4 py-2.5 filter-input cursor-pointer hover:bg-gray-50 transition-all shadow-sm min-w-[120px]">
                            <option value="">Semua Tahun</option>
                             @foreach($yearOptions as $year)
                                 <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                             @endforeach
                        </select>
                         
                         <!-- Reset -->
                         @if(request('search') || request('unit_asal') || request('penerima') || request('year'))
                            <a href="{{ route('arsip-masuk.index') }}" class="flex items-center px-4 py-2.5 bg-red-50 text-red-600 rounded-xl text-sm font-bold hover:bg-red-100 transition shadow-sm whitespace-nowrap">
                                Reset Filter
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Action Buttons: Print/Export -->
               <div class="flex gap-3 w-full lg:w-auto justify-end">
                    <button class="flex items-center gap-2 px-4 py-2.5 bg-green-50 text-green-700 border border-green-200 rounded-xl text-sm font-bold hover:bg-green-100 hover:shadow-md transition-all active:scale-95">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <span class="hidden sm:inline">Excel</span>
                    </button>
                    <button class="flex items-center gap-2 px-4 py-2.5 bg-red-50 text-red-700 border border-red-200 rounded-xl text-sm font-bold hover:bg-red-100 hover:shadow-md transition-all active:scale-95">
                         <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                         <span class="hidden sm:inline">PDF</span>
                    </button>
                    <button class="flex items-center gap-2 px-4 py-2.5 bg-gray-50 text-gray-700 border border-gray-200 rounded-xl text-sm font-bold hover:bg-gray-100 hover:shadow-md transition-all active:scale-95">
                         <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                         <span class="hidden sm:inline">Print</span>
                    </button>
               </div>
            </div>

            <!-- Table Container -->
            <div class="p-6 flex-grow overflow-x-auto">
                <div class="overflow-hidden rounded-2xl border border-gray-200 shadow-sm">
                    <table class="w-full text-sm text-center border-collapse">
                        <thead>
                            <tr class="bg-[#8B1A1A] text-white">
                                <th class="py-5 px-6 font-bold text-xs uppercase tracking-wider first:rounded-tl-xl text-center">No Berita Acara</th>
                                <th class="py-5 px-6 font-bold text-xs uppercase tracking-wider text-center">Unit Asal</th>
                                <th class="py-5 px-6 font-bold text-xs uppercase tracking-wider text-center">Tanggal Terima</th>
                                <th class="py-5 px-6 font-bold text-xs uppercase tracking-wider text-center">Jumlah Box</th>
                                <th class="py-5 px-6 font-bold text-xs uppercase tracking-wider text-center">Penerima</th>
                                <th class="py-5 px-6 font-bold text-xs uppercase tracking-wider text-center last:rounded-tr-xl">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="arsipTableBody" class="divide-y divide-gray-100 bg-white">
                            @forelse($arsipMasuk as $item)
                            <tr class="hover:bg-red-50/50 transition duration-200 group">
                                <td class="py-4 px-6 font-semibold text-gray-800 border-l-4 border-transparent group-hover:border-red-500 transition-all">
                                    {{ $item->nomor_berita_acara }}
                                </td>
                                <td class="py-4 px-6 text-gray-600">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        {{ $item->unit_asal }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-gray-600">
                                    {{ \Carbon\Carbon::parse($item->tanggal_terima)->format('d M Y') }}
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <span class="bg-red-100 text-red-800 py-1 px-3 rounded-lg text-xs font-bold shadow-sm">
                                        {{ $item->jumlah_box_masuk }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-gray-600">
                                    <div class="flex items-center justify-center gap-2">
                                        <div class="w-6 h-6 rounded-full bg-gray-200 flex items-center justify-center text-[10px] font-bold text-gray-600">
                                            {{ substr($item->penerima->nama ?? '?', 0, 1) }}
                                        </div>
                                        {{ $item->penerima->nama ?? '-' }}
                                    </div>
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <div class="flex items-center justify-center gap-3">
                                        <a href="{{ route('arsip-masuk.edit', $item->id) }}" class="p-2 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-lg transition-colors" title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                        </a>
                                        <form action="{{ route('arsip-masuk.destroy', $item->id) }}" method="POST" class="inline">
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
                                <td colspan="6" class="py-12 text-center">
                                    <div class="flex flex-col items-center justify-center text-gray-500">
                                        <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        <p class="text-lg font-medium">Belum ada data arsip masuk</p>
                                        <p class="text-sm">Silakan tambahkan data baru</p>
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
            // Delete Confirmation
            function attachDeleteListeners() {
                const deleteButtons = document.querySelectorAll('.delete-btn');
                deleteButtons.forEach(button => {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        const form = this.closest('form');
                        
                        Swal.fire({
                            title: 'Hapus Arsip?',
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

            attachDeleteListeners();

            // Filters AJAX
            const inputs = document.querySelectorAll('.filter-input');
            const tableBody = document.getElementById('arsipTableBody');
            let timeout = null;

            function fetchData() {
                const search = document.getElementById('searchInput').value;
                const unit = document.getElementById('unitAsalFilter').value;
                const penerima = document.getElementById('penerimaFilter') ? document.getElementById('penerimaFilter').value : '';
                const year = document.getElementById('yearFilter').value;

                const params = new URLSearchParams();
                if(search) params.append('search', search);
                if(unit) params.append('unit_asal', unit);
                if(penerima) params.append('penerima', penerima);
                if(year) params.append('year', year);

                const url = `{{ route('arsip-masuk.index') }}?${params.toString()}`;

                // Update URL history
                window.history.pushState({path: url}, '', url);

                // Add loading opacity
                tableBody.classList.add('opacity-50');

                fetch(url, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newTbody = doc.getElementById('arsipTableBody');
                    if (newTbody) {
                        tableBody.innerHTML = newTbody.innerHTML;
                        attachDeleteListeners(); 
                    }
                    tableBody.classList.remove('opacity-50');
                })
                .catch(error => {
                    console.error('Error:', error);
                    tableBody.classList.remove('opacity-50');
                });
            }

            inputs.forEach(input => {
                input.addEventListener('input', function() {
                    clearTimeout(timeout);
                    timeout = setTimeout(fetchData, 400); // 400ms delay
                });
                if(input.tagName === 'SELECT') {
                    input.addEventListener('change', fetchData);
                }
            });
        });
    </script>
</x-layout>