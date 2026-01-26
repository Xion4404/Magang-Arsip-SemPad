<x-layout>
    {{-- Print Header (Visible only in Print) --}}
    <div id="print-header" class="hidden mb-8 border-b-2 border-red-800 pb-4">
        <div class="flex items-center justify-between px-8">
            <img src="{{ asset('images/logo-sp.png') }}" alt="Logo" class="h-20 w-auto">
            <div class="text-center">
                <h1 class="text-2xl font-bold text-red-800 uppercase">PT Semen Padang</h1>
                <h2 class="text-xl font-bold text-gray-800">Daftar Arsip Dokumen</h2>
                <p class="text-sm text-gray-600">Indarung, Padang 25237, Sumatera Barat</p>
            </div>
            <div class="w-20"></div> {{-- Spacer --}}
        </div>
    </div>

    {{-- Main Container --}}
    <div class="min-h-screen bg-gray-50 pb-20 print:bg-white print:pb-0">
        
        {{-- Header Section --}}
        <div class="bg-red-800 rounded-b-[3rem] shadow-2xl pt-8 pb-32 px-4 md:px-6 print:hidden relative overflow-hidden">
             {{-- Decor --}}
            <div class="absolute top-0 right-0 w-64 h-64 bg-red-700 rounded-full mix-blend-multiply filter blur-3xl opacity-50 -mr-20 -mt-20"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-red-900 rounded-full mix-blend-multiply filter blur-3xl opacity-50 -ml-20 -mb-20"></div>

            <div class="w-full max-w-[98%] mx-auto flex flex-col md:flex-row justify-between items-center gap-6 relative z-10">
                <div class="text-center md:text-left">
                    <h1 class="text-4xl font-black text-white tracking-tight mb-2">Daftar Arsip</h1>
                    <p class="text-red-100 font-medium">Kelola dan monitor seluruh dokumen arsip perusahaan.</p>
                </div>
                <a href="/input-arsip" class="group bg-white text-red-800 px-8 py-4 rounded-2xl font-bold shadow-lg hover:shadow-xl hover:scale-105 transition-all flex items-center gap-3">
                    <div class="bg-red-100 p-1 rounded-lg group-hover:bg-red-200 transition">
                         <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    </div>
                    <span>TAMBAH ARSIP</span>
                </a>
            </div>
        </div>

        {{-- Content Card --}}
        <div class="w-full max-w-[98%] mx-auto -mt-20 px-2 md:px-0 print:mt-0 print:px-0 relative z-20">
            <div class="bg-white rounded-[2.5rem] shadow-xl border border-gray-100 p-6 md:p-8 print:shadow-none print:border-0 print:p-0">
                
                {{-- Toolbar (Search & Filters) --}}
                <form action="/arsip" method="GET" class="flex flex-col xl:flex-row items-center gap-4 mb-6 print:hidden">
                    {{-- Search Input --}}
                    <div class="relative w-full xl:w-96 group">
                        <span class="absolute inset-y-0 left-4 flex items-center text-gray-400 group-focus-within:text-red-500 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </span>
                        <input type="text" name="search" placeholder="Cari dokumen..." value="{{ request('search') }}" 
                            class="w-full pl-12 pr-4 py-4 border-2 border-gray-100 rounded-2xl outline-none focus:border-red-500 focus:ring-4 focus:ring-red-100 transition shadow-sm font-medium text-gray-700">
                    </div>
                    
                    {{-- Sorting & Filters --}}
                    <div class="flex flex-wrap gap-3 w-full xl:w-auto">
                        {{-- Filter Tindakan (Permanen / Musnah) --}}
                         <select name="filter_tindakan" onchange="this.form.submit()" class="px-5 py-4 border-2 border-gray-100 rounded-2xl text-sm font-bold text-gray-600 outline-none cursor-pointer focus:border-red-500 focus:text-red-600 transition hover:bg-gray-50">
                            <option value="">Semua Status</option>
                            <option value="Permanen" {{ request('filter_tindakan') == 'Permanen' ? 'selected' : '' }}>Permanen</option>
                            <option value="Musnah" {{ request('filter_tindakan') == 'Musnah' ? 'selected' : '' }}>Musnah</option>
                        </select>

                        {{-- Filter Tahun --}}
                        <select name="filter_tahun" onchange="this.form.submit()" class="px-5 py-4 border-2 border-gray-100 rounded-2xl text-sm font-bold text-gray-600 outline-none cursor-pointer focus:border-red-500 focus:text-red-600 transition hover:bg-gray-50">
                            <option value="">Semua Tahun</option>
                            @foreach($availableYears as $year)
                                <option value="{{ $year }}" {{ request('filter_tahun') == $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endforeach
                        </select>

                        <select name="sort" onchange="this.form.submit()" class="px-5 py-4 border-2 border-gray-100 rounded-2xl text-sm font-bold text-gray-600 outline-none cursor-pointer focus:border-red-500 focus:text-red-600 transition hover:bg-gray-50">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                            <option value="year_desc" {{ request('sort') == 'year_desc' ? 'selected' : '' }}>Tahun ↓</option>
                            <option value="year_asc" {{ request('sort') == 'year_asc' ? 'selected' : '' }}>Tahun ↑</option>
                        </select>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="ml-auto flex flex-wrap gap-2 w-full xl:w-auto justify-end">
                        <button type="button" onclick="submitExport('excel')" class="bg-green-50 text-green-700 px-5 py-3 rounded-xl font-bold hover:bg-green-100 hover:-translate-y-1 transition flex items-center gap-2 border border-green-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Excel
                        </button>
                        <button type="button" onclick="submitExport('pdf')" class="bg-red-50 text-red-700 px-5 py-3 rounded-xl font-bold hover:bg-red-100 hover:-translate-y-1 transition flex items-center gap-2 border border-red-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                            PDF
                        </button>
                        <button type="button" onclick="printTable()" class="bg-gray-100 text-gray-700 px-5 py-3 rounded-xl font-bold hover:bg-gray-200 hover:-translate-y-1 transition flex items-center gap-2 border border-gray-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                            Print
                        </button>
                    </div>
                </form>

                <form id="export-form" action="/arsip/export" method="POST" target="_blank" class="hidden">
                    @csrf
                    <input type="hidden" name="type" id="export-type">
                    <input type="hidden" name="ids" id="export-ids">
                    {{-- Carry over search & filter params --}}
                    <input type="hidden" name="search" value="{{ request('search') }}">
                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                    <input type="hidden" name="filter_tindakan" value="{{ request('filter_tindakan') }}">
                    <input type="hidden" name="filter_tahun" value="{{ request('filter_tahun') }}">
                </form>

                <div id="arsip-table-container">
                    @include('arsip.partials.table')
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.querySelector('input[name="search"]');
            const tableContainer = document.getElementById('arsip-table-container');
            let typingTimer;
            const doneTypingInterval = 500; // 500ms delay

            if (searchInput) {
                searchInput.addEventListener('keyup', function() {
                    clearTimeout(typingTimer);
                    typingTimer = setTimeout(performSearch, doneTypingInterval);
                });

                searchInput.addEventListener('keydown', function() {
                    clearTimeout(typingTimer);
                });
            }

            function performSearch() {
                const query = searchInput.value;
                const url = new URL(window.location.href);
                url.searchParams.set('search', query);
                // Reset to page 1 on new search
                url.searchParams.set('page', 1);

                // Update URL without refresh
                window.history.pushState({}, '', url);

                fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    tableContainer.innerHTML = html;
                })
                .catch(error => console.error('Error:', error));
            }
        });

        // Global functions for buttons
        function submitExport(type) {
            const checkedBoxes = document.querySelectorAll('input[name="selected_arsip[]"]:checked');
            const ids = Array.from(checkedBoxes).map(cb => cb.value);
            
            document.getElementById('export-type').value = type;
            document.getElementById('export-ids').value = JSON.stringify(ids);
            document.getElementById('export-form').submit();
        }

        function printTable() {
            // Determine if we need to filter by selection
            const checkedBoxes = document.querySelectorAll('input[name="selected_arsip[]"]:checked');
            const ids = Array.from(checkedBoxes).map(cb => cb.value);
            
            if (ids.length > 0) {
                // Temporarily hide unselected rows
                document.querySelectorAll('tbody tr').forEach(tr => {
                    const cb = tr.querySelector('input[name="selected_arsip[]"]');
                    if (cb && !cb.checked) {
                        tr.classList.add('print:hidden');
                    } else {
                        tr.classList.remove('print:hidden');
                    }
                });
            } else {
                // Show all if nothing selected
                document.querySelectorAll('tbody tr').forEach(tr => tr.classList.remove('print:hidden'));
            }

            window.print();
            
            // Cleanup (optional, showing all again after print dialog closes)
            // But browsers block JS during print dialog, so this runs after.
            // Keeping them hidden might be confusing if user cancels print, so maybe restore?
            // setTimeout(() => {
            //     document.querySelectorAll('.print:hidden').forEach(el => el.classList.remove('print:hidden'));
            // }, 1000);
        }

        function toggleAll(source) {
            checkboxes = document.querySelectorAll('input[name="selected_arsip[]"]');
            for(var i=0, n=checkboxes.length;i<n;i++) {
                checkboxes[i].checked = source.checked;
            }
        }
    </script>
    
    <style>
        @media print {
            @page {
                size: landscape;
                margin: 1cm;
            }
            body {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                background-color: white !important;
            }
            body * {
                visibility: hidden;
            }
            #arsip-table-container, #arsip-table-container *, #print-header, #print-header * {
                visibility: visible;
            }
            #print-header {
                display: block !important;
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
            }
            #arsip-table-container {
                position: absolute;
                top: 150px; /* Adjust based on header height */
                left: 0;
                width: 100%;
            }
            
            /* Hide columns specifically requested */
            .jenis-arsip-col, .selection-col {
                display: none !important;
            }

            /* Ensure table looks good */
            table {
                width: 100% !important;
                border-collapse: collapse;
                border: 2px solid #000;
            }
            th, td {
                border: 1px solid #000 !important;
                padding: 6px !important;
                font-size: 9pt !important;
                color: black !important;
            }
            th {
                background-color: #fce4e4 !important; /* Light red background for header */
            }
            
            /* Hide actions/links */
            a { text-decoration: none; color: black; }
        }
    </style>
</x-layout>