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
                <div class="flex flex-col xl:flex-row items-center gap-4 mb-6 print:hidden">
                    <form id="filterForm" action="/arsip" method="GET" class="contents">
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
    
                            {{-- Filter Box --}}
                            <select name="filter_box" onchange="this.form.submit()" class="px-5 py-4 border-2 border-gray-100 rounded-2xl text-sm font-bold text-gray-600 outline-none cursor-pointer focus:border-red-500 focus:text-red-600 transition hover:bg-gray-50">
                                <option value="">Semua Box</option>
                                @foreach($availableBoxes as $box)
                                    <option value="{{ $box }}" {{ request('filter_box') == $box ? 'selected' : '' }}>Box {{ $box }}</option>
                                @endforeach
                            </select>
    
                            <select name="sort" onchange="this.form.submit()" class="px-5 py-4 border-2 border-gray-100 rounded-2xl text-sm font-bold text-gray-600 outline-none cursor-pointer focus:border-red-500 focus:text-red-600 transition hover:bg-gray-50">
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                                <option value="year_desc" {{ request('sort') == 'year_desc' ? 'selected' : '' }}>Tahun ↓</option>
                                <option value="year_asc" {{ request('sort') == 'year_asc' ? 'selected' : '' }}>Tahun ↑</option>
                            </select>
                        </div>
                    </form>


                    {{-- Action Buttons (Right Aligned) --}}
                    <div class="ml-auto flex items-center gap-3 w-full xl:w-auto justify-end">
                        
                        {{-- Import Button --}}
                        <div x-data="{ open: false }">
                            <button type="button" @click="open = true" class="px-5 py-4 bg-green-50 text-green-700 rounded-2xl font-bold flex items-center gap-2 hover:bg-green-100 transition shadow-sm border border-green-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                <span>Import</span>
                            </button>

                            {{-- Modal Import --}}
                            <div x-show="open" style="display: none;" class="fixed inset-0 z-[999] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                    <div x-show="open" @click="open = false" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                                    <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="relative inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                                        <form action="{{ route('arsip.import.process') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                                <div class="sm:flex sm:items-start">
                                                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                                                        <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                                    </div>
                                                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Import Data Arsip</h3>
                                                        <div class="mt-2">
                                                            <p class="text-sm text-gray-500 mb-4">
                                                                Upload file Excel (.xlsx, .xls) sesuai template. Pastikan "No Berkas" & "Nama Berkas" terisi di baris pertama tiap grup.
                                                            </p>
                                                            <input type="file" name="file" required class="block w-full text-sm text-gray-500
                                                              file:mr-4 file:py-2 file:px-4
                                                              file:rounded-full file:border-0
                                                              file:text-sm file:font-semibold
                                                              file:bg-green-50 file:text-green-700
                                                              hover:file:bg-green-100 cursor-pointer border rounded-lg p-2
                                                            "/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                                <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                                                    Import
                                                </button>
                                                <button type="button" @click="open = false" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                                    Batal
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Existing Export Buttons --}}
                        {{-- Wrapper for Excel Button form (assumed) --}}
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
                </div>

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
                margin: 5mm;
            }
            body {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                background-color: white !important;
                font-size: 10pt; /* Increased from 8px to 10pt for better fullness */
            }

            /* RESET: Break out of the app shell layout */
            html, body, div, main, section, header, footer {
                background-color: white !important;
                color: black !important;
                margin: 0 !important;
                padding: 0 !important;
                float: none !important;
                position: static !important;
                overflow: visible !important;
                height: auto !important;
                width: auto !important;
                display: block !important;
                max-height: none !important;
                min-height: 0 !important;
                transform: none !important;
                box-shadow: none !important;
                border: none !important;
                transition: none !important;
            }

            /* Explicitly hide specific UI components hierarchy */
            aside, /* Sidebar */
            nav, 
            .sidebar, 
            #sidebar-wrapper,
            form, /* Search & Filter forms */
            .hidden, /* Tailwind hidden classes */
            .print\:hidden /* Tailwind print:hidden */
            {
                display: none !important;
            }

            /* Hide the main app header (red gradient one) */
            /* We need a specific selector if it's generic 'header', assume direct child of body path */
            body > div > div > header {
                display: none !important;
            }
            /* Backup hiding */
            header.bg-gradient-to-r {
                display: none !important;
            }

            /* Make Print Header Visible and Static */
            #print-header {
                display: block !important;
                border-bottom: 3px solid #8B0000;
                padding: 0 0 10px 0;
                margin-bottom: 20px !important;
                width: 100% !important;
            }

            /* Main Table Container */
            #arsip-table-container {
                display: block !important;
                width: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            /* Ensure main content wrapper is visible */
            #main-content-wrapper, main {
                display: block !important;
                width: 100% !important;
            }

            /* Break pages correctly */
            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }
            thead {
                display: table-header-group;
            }
            tfoot {
                display: table-footer-group;
            }

            /* Overrides for Table structure from partials */
            .overflow-x-auto {
                overflow: visible !important;
                display: block !important;
                width: 100% !important;
                margin: 0 !important;
            }
            
            table {
                min-width: 0 !important;
                width: 100% !important;
                table-layout: fixed;
                border-collapse: collapse;
                border: 2px solid #000;
                margin: 0 !important;
            }
            
            /* Hide unused columns to save space */
            .group-hover\:shadow-sm, .shadow-md {
                box-shadow: none !important;
            }
            
            th, td {
                word-wrap: break-word;
                overflow-wrap: break-word;
                white-space: normal !important;
                padding: 6px 4px !important;
                border: 1px solid #000 !important;
                color: black !important;
                background: white !important;
                vertical-align: top;
            }
            
            th {
                background-color: #fce4e4 !important;
                font-weight: bold;
                text-align: center;
                vertical-align: middle;
                font-size: 10pt !important;
            }
            
            td {
                 font-size: 9pt !important;
            }

            /* Column Widths (Approximation for A4 Landscape) - Total 100% visible */
            
            /* 1. Checkbox: HIDE */
            th:nth-child(1), td:nth-child(1) { display: none !important; width: 0 !important; }

            /* 2. No Berkas: 5% */
            th:nth-child(2), td:nth-child(2) { width: 4%; text-align: center !important; }
            
            /* 3. Kode Klasifikasi: 8% */
            th:nth-child(3), td:nth-child(3) { width: 7%; }
            
            /* 4. Nama Berkas: 15% */
            th:nth-child(4), td:nth-child(4) { width: 14%; }
            
            /* 5. Isi Berkas: 20% */
            th:nth-child(5), td:nth-child(5) { width: 19%; }
            
            /* 6. Tahun: 4% */
            th:nth-child(6), td:nth-child(6) { width: 4%; text-align: center !important; }
            
            /* 7. Tanggal: 6% */
            th:nth-child(7), td:nth-child(7) { width: 6%; text-align: center !important; }
            
            /* 8. Jml: 3% */
            th:nth-child(8), td:nth-child(8) { width: 3%; text-align: center !important; }
            
            /* 9. Hak Akses: 6% */
            th:nth-child(9), td:nth-child(9) { width: 6%; text-align: center !important; }
            
            /* 10. Masa Simpan: 6% */
            th:nth-child(10), td:nth-child(10) { width: 6%; text-align: center !important; }
            
            /* 11. Tindakan: 6% */
            th:nth-child(11), td:nth-child(11) { width: 6%; text-align: center !important; }
            
            /* 12. Box: 3% */
            th:nth-child(12), td:nth-child(12) { width: 4%; text-align: center !important; }
            
            /* 13. Unit Pengolah: 7% */
            th:nth-child(13), td:nth-child(13) { width: 15%; }
            
            /* 14. Jenis: 5% */
            th:nth-child(14), td:nth-child(14) { width: 6%; text-align: center !important; }
            
            /* 15. Aksi: HIDE */
            th:nth-child(15), td:nth-child(15) { display: none !important; width: 0 !important; }

            /* Hide Actions & Checkbox inputs specifically */
            th:last-child, td:last-child {
               display: none !important;
            }
            input[type="checkbox"] {
                display: none !important;
            }
            
            /* Fix badges in print */
            .rounded-full, .rounded-lg {
                background: none !important;
                border: none !important;
                padding: 0 !important;
                color: black !important;
                display: inline;
            }
        }
    </style>
</x-layout>