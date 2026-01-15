<x-layout>
    <div class="bg-red-800 text-white p-6 rounded-xl shadow-lg mb-8 relative overflow-hidden">
        <div class="absolute top-0 right-0 p-4 opacity-10">
             <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14z"/><path d="M7 12h2v5H7zm4-3h2v8h-2zm4-3h2v11h-2z"/></svg>
        </div>
        <h2 class="text-2xl font-bold relative z-10">Daftar Arsip Masuk</h2>
        <p class="text-red-100 mt-1 relative z-10">Kelola dan pantau arsip yang masuk ke unit kearsipan.</p>
    </div>

    <!-- Toolbar -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <!-- Filters & Search -->
        <div class="flex items-center gap-3 w-full md:w-auto flex-wrap">
             <!-- Search -->
             <div class="relative w-full md:w-64">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </span>
                <input type="text" id="searchInput" value="{{ request('search') }}" placeholder="Cari Arsip..." class="w-full py-2 pl-10 pr-4 border border-gray-200 rounded-md focus:outline-none focus:ring-1 focus:ring-red-800 text-sm filter-input" autocomplete="off">
             </div>
             
             <!-- Filter: Unit Asal -->
             <div class="w-full md:w-48">
                 <select id="unitAsalFilter" class="w-full bg-[#5c1313] hover:bg-[#4a0f0f] text-white py-2 px-3 border-none rounded-lg focus:outline-none focus:ring-0 text-sm font-medium cursor-pointer filter-input">
                     <option value="" class="bg-white text-gray-800">Semua Unit Asal</option>
                     @foreach($unitAsalOptions as $unit)
                         <option value="{{ $unit }}" {{ request('unit_asal') == $unit ? 'selected' : '' }} class="bg-white text-gray-800">{{ $unit }}</option>
                     @endforeach
                 </select>
             </div>

             <!-- Filter: Penerima -->
             <div class="w-full md:w-48">
                 <select id="penerimaFilter" class="w-full bg-[#5c1313] hover:bg-[#4a0f0f] text-white py-2 px-3 border-none rounded-lg focus:outline-none focus:ring-0 text-sm font-medium cursor-pointer filter-input">
                     <option value="" class="bg-white text-gray-800">Semua Penerima</option>
                     @foreach($users as $user)
                         <option value="{{ $user->id }}" {{ request('penerima') == $user->id ? 'selected' : '' }} class="bg-white text-gray-800">{{ $user->nama }}</option>
                     @endforeach
                 </select>
             </div>

            <!-- Reset Button -->
            @if(request('search') || request('unit_asal') || request('penerima'))
                <a href="{{ route('arsip-masuk.index') }}" class="text-xs text-red-600 font-semibold hover:underline px-2">Reset</a>
            @endif
        </div>

        <a href="{{ route('arsip-masuk.create') }}" class="bg-red-800 hover:bg-red-900 text-white px-6 py-2.5 rounded-lg font-bold shadow-md flex items-center gap-2 transition transform hover:scale-105">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Arsip Masuk
        </a>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-red-100">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-center">
                <thead class="bg-white border-b border-red-100">
                    <tr>
                        <th class="py-5 px-4 font-bold text-gray-900 tracking-wide">No</th>
                        <th class="py-5 px-4 font-bold text-gray-900 tracking-wide border-l border-red-50">Nomor Berita Acara</th>
                        <th class="py-5 px-4 font-bold text-gray-900 tracking-wide border-l border-red-50">Unit Asal</th>
                        <th class="py-5 px-4 font-bold text-gray-900 tracking-wide border-l border-red-50">Tanggal Terima</th>
                        <th class="py-5 px-4 font-bold text-gray-900 tracking-wide border-l border-red-50">Jumlah Box</th>
                        <th class="py-5 px-4 font-bold text-gray-900 tracking-wide border-l border-red-50">Total Berkas</th>
                        <th class="py-5 px-4 font-bold text-gray-900 tracking-wide border-l border-red-50">Penerima</th>
                        <th class="py-5 px-4 font-bold text-gray-900 tracking-wide border-l border-red-50">Aksi</th>
                    </tr>
                </thead>
                <tbody id="arsipTableBody" class="divide-y divide-red-50 bg-[#FFF5F5]">
                    @forelse($arsipMasuk as $item)
                    <tr class="hover:bg-red-50 transition duration-150 ease-in-out">
                        <td class="py-4 px-4 text-red-900 font-medium">{{ $loop->iteration }}</td>
                        <td class="py-4 px-4 text-red-900">{{ $item->nomor_berita_acara }}</td>
                        <td class="py-4 px-4 text-red-900">{{ $item->unit_asal }}</td>
                        <td class="py-4 px-4 text-red-900">{{ \Carbon\Carbon::parse($item->tanggal_terima)->format('d/m/Y') }}</td>
                        <td class="py-4 px-4 text-red-900">{{ $item->jumlah_box_masuk }} Box</td>
                        <td class="py-4 px-4 text-red-900">{{ $item->berkas->count() }} Berkas</td>
                        <td class="py-4 px-4 text-red-900">{{ $item->penerima->nama ?? '-' }}</td>
                        <td class="py-4 px-4">
                            <a href="{{ route('arsip-masuk.show', $item->id) }}" class="inline-flex items-center justify-center bg-white border border-red-200 text-red-700 hover:bg-red-50 hover:text-red-900 px-3 py-1.5 rounded-lg text-xs font-semibold shadow-sm transition-all duration-200 gap-1" title="Lihat Detail">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-10 text-gray-500 italic">Belum ada data arsip masuk.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('.filter-input');
            const tableBody = document.getElementById('arsipTableBody');
            let timeout = null;

            function fetchData() {
                const search = document.getElementById('searchInput').value;
                const unit = document.getElementById('unitAsalFilter').value;
                const penerima = document.getElementById('penerimaFilter').value;

                const params = new URLSearchParams();
                if(search) params.append('search', search);
                if(unit) params.append('unit_asal', unit);
                if(penerima) params.append('penerima', penerima);

                const url = `{{ route('arsip-masuk.index') }}?${params.toString()}`;

                // Update URL history
                window.history.pushState({path: url}, '', url);

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
                    }
                })
                .catch(error => console.error('Error:', error));
            }

            inputs.forEach(input => {
                input.addEventListener('input', function() {
                    clearTimeout(timeout);
                    timeout = setTimeout(fetchData, 300);
                });
                // For select elements, trigger immediately on change
                if(input.tagName === 'SELECT') {
                    input.addEventListener('change', fetchData);
                }
            });
        });
    </script>
</x-layout>
