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

    <div class="bg-red-800 text-white p-4 rounded-t-xl shadow-lg flex justify-between items-center print:hidden">
        <h2 class="text-xl font-bold uppercase tracking-tight">Kelola dan monitor seluruh dokumen arsip</h2>
        <a href="/input-arsip" class="bg-white text-red-800 px-4 py-2 rounded-lg text-xs font-bold hover:bg-gray-100 transition shadow-sm">
            + TAMBAH ARSIP
        </a>
    </div>

    <div class="bg-white p-6 rounded-b-xl shadow-md border border-gray-100 min-h-[500px]">
        <form action="/arsip" method="GET" class="flex flex-wrap items-center gap-4 mb-8">
            <div class="relative w-full md:w-80">
                <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </span>
                <input type="text" name="search" placeholder="Search..." value="{{ request('search') }}" class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg outline-none focus:ring-1 focus:ring-red-500 text-sm">
            </div>
            
            {{-- Sorting Menu --}}
            <select name="sort" onchange="this.form.submit()" class="border border-gray-200 rounded-lg px-4 py-2 text-sm text-gray-500 outline-none cursor-pointer focus:border-red-500">
                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru Ditambahkan</option>
                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama Ditambahkan</option>
                <option value="year_desc" {{ request('sort') == 'year_desc' ? 'selected' : '' }}>Tahun Terbaru</option>
                <option value="year_asc" {{ request('sort') == 'year_asc' ? 'selected' : '' }}>Tahun Terlama</option>
            </select>

            <div class="flex gap-2">
                <select class="border border-gray-200 rounded-lg px-4 py-2 text-sm text-gray-500 outline-none hidden"><option>Klasifikasi</option></select>
                <select class="border border-gray-200 rounded-lg px-4 py-2 text-sm text-gray-500 outline-none hidden"><option>Tahun</option></select>
            </div>

            {{-- Export & Print Buttons --}}
            <div class="ml-auto flex gap-2">
                <button type="button" onclick="submitExport('excel')" class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-green-700 transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Excel
                </button>
                <button type="button" onclick="submitExport('pdf')" class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-red-700 transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    PDF
                </button>
                <button type="button" onclick="printTable()" class="bg-gray-700 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-gray-800 transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Print
                </button>
            </div>
        </form>

        <form id="export-form" action="/arsip/export" method="POST" target="_blank" class="hidden">
            @csrf
            <input type="hidden" name="type" id="export-type">
            <input type="hidden" name="ids" id="export-ids">
            {{-- Carry over search params --}}
            <input type="hidden" name="search" value="{{ request('search') }}">
            <input type="hidden" name="sort" value="{{ request('sort') }}">
        </form>

        <div id="arsip-table-container">
            @include('arsip.partials.table')
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