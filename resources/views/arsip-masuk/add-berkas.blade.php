<x-layout>
    <div class="max-w-6xl mx-auto my-10">
        <!-- Header Info -->
        <div class="bg-[#e92027] rounded-t-2xl shadow-lg p-6 text-white mb-6">
            <h2 class="text-2xl font-bold">Input Berkas Arsip (Tahap 2/2)</h2>
            <div class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4 text-sm bg-[#e92027] bg-opacity-30 p-4 rounded-lg">
                <div>
                    <span class="block opacity-70">Unit Asal</span>
                    <span class="font-bold text-lg">{{ $arsipMasuk->unit_asal }}</span>
                </div>
                <div>
                    <span class="block opacity-70">Jumlah Box</span>
                    <span class="font-bold text-lg">{{ $arsipMasuk->jumlah_box_masuk }}</span>
                </div>
                <div>
                    <span class="block opacity-70">Tanggal Terima</span>
                    <span class="font-bold text-lg">{{ \Carbon\Carbon::parse($arsipMasuk->tanggal_terima)->format('d/m/Y') }}</span>
                </div>
                <div>
                    <span class="block opacity-70">Penerima</span>
                    <span class="font-bold text-lg">{{ $arsipMasuk->penerima->nama ?? '-' }}</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Form Input Berkas -->
            <div class="lg:col-span-1">
                <div class="bg-white p-6 rounded-2xl shadow-lg border border-red-100 sticky top-4">
                    <h3 class="text-xl font-bold text-[#e92027] mb-4 border-b pb-2">Tambah Berkas</h3>
                    
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="bg-red-100 border border-[#e92027] text-[#c41820] px-4 py-3 rounded relative mb-4">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>- {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ isset($berkas) ? route('arsip-masuk.berkas.update', ['id' => $arsipMasuk->id, 'berkasId' => $berkas->id]) : route('arsip-masuk.berkas.store', $arsipMasuk->id) }}" method="POST">
                        @csrf
                        @if(isset($berkas))
                            @method('PUT')
                        @endif
                        
                        <div class="space-y-6">
                            <!-- No Box -->
                            <div>
                                <label class="block text-gray-800 font-bold mb-2 text-sm">No Box</label>
                                <input type="text" name="no_box" required 
                                    value="{{ old('no_box', $berkas->no_box ?? '') }}"
                                    class="w-full bg-white border border-gray-300 rounded-xl p-4 focus:ring-1 focus:ring-[#e92027] focus:outline-none placeholder-gray-400 transition-shadow" 
                                    placeholder="Contoh: 1">
                            </div>

                            <!-- Custom Cascading Dropdown -->
                            <div>
                                <label class="block text-gray-800 font-bold mb-2 text-sm">Kode Klasifikasi</label>
                                
                                <div class="relative" id="customDropdown">
                                    <!-- Trigger Button -->
                                    <div id="dropdownTrigger" class="w-full bg-white border border-gray-300 rounded-xl p-4 cursor-pointer flex justify-between items-center hover:border-red-300 transition-colors shadow-sm group">
                                        <span id="triggerText" class="text-gray-500 font-medium">Pilih Kode Klasifikasi</span>
                                        <svg class="w-5 h-5 text-gray-400 group-hover:text-[#e92027] transition-colors transform transition-transform" id="chevronIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>

                                    <!-- Dropdown Menu -->
                                    <div id="dropdownMenu" class="hidden absolute z-50 w-full mt-2 bg-white rounded-xl shadow-xl border border-red-100 overflow-hidden ring-1 ring-black ring-opacity-5">
                                        <!-- Header -->
                                        <div class="bg-red-50 px-4 py-3 border-b border-red-100 flex justify-between items-center">
                                            <span id="dropdownHeader" class="text-xs font-bold text-[#a0131a] uppercase tracking-wider">PILIH JENIS JRA</span>
                                            <button type="button" id="resetStepBtn" class="text-[#e92027] hover:text-[#c41820] text-xs font-semibold hidden">
                                                <span class="flex items-center gap-1">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                                                    KEMBALI
                                                </span>
                                            </button>
                                        </div>
                                        
                                        <!-- List Options -->
                                        <ul id="dropdownList" class="max-h-64 overflow-y-auto py-1">
                                            <!-- Items will be injected here -->
                                        </ul>
                                    </div>
                                </div>

                                <!-- Hidden Input -->
                                <input type="hidden" name="klasifikasi_id" id="klasifikasi_id" value="{{ old('klasifikasi_id', $berkas->klasifikasi_id ?? '') }}" required>
                                
                                <!-- Selection Status -->
                                <div id="finalDisplay" class="hidden mt-3">
                                    <div class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-900 p-4 rounded-xl shadow-sm">
                                        <div class="bg-green-100 p-2 rounded-full flex-shrink-0">
                                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        </div>
                                        <div class="flex-grow min-w-0">
                                            <div class="text-xs text-green-600 font-bold uppercase">Klasifikasi Terpilih</div>
                                            <div id="finalLabel" class="font-medium text-sm truncate"></div>
                                        </div>
                                        <button type="button" id="fullResetBtn" class="text-gray-400 hover:text-[#e92027] p-1 flex-shrink-0">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                // Elements
                                const trigger = document.getElementById('dropdownTrigger');
                                const menu = document.getElementById('dropdownMenu');
                                const list = document.getElementById('dropdownList');
                                const header = document.getElementById('dropdownHeader');
                                const subTriggerText = document.getElementById('triggerText');
                                const chevron = document.getElementById('chevronIcon');
                                const resetStepBtn = document.getElementById('resetStepBtn');
                                const hiddenInput = document.getElementById('klasifikasi_id');
                                const finalDisplay = document.getElementById('finalDisplay');
                                const finalLabel = document.getElementById('finalLabel');
                                const fullResetBtn = document.getElementById('fullResetBtn');

                                const baseUrl = "{{ route('arsip-masuk.get-klasifikasi-options') }}";
                                
                                // Init Edit State if value exists
                                if (hiddenInput.value) {
                                    // Normally we might fetch label via AJAX, but for simplicity we rely on backend passing it or just basic
                                    // For deeper implementation we could pass the label from controller.
                                    // Here we'll try to use a data attribute if provided, or generic
                                    @if(isset($berkas) && $berkas->klasifikasi)
                                        finalLabel.textContent = "{{ $berkas->klasifikasi->kode_klasifikasi }} - {{ $berkas->klasifikasi->jenis_arsip }}";
                                        trigger.classList.add('hidden');
                                        finalDisplay.classList.remove('hidden');
                                    @endif
                                }

                                // ... JS logic continues ...
                                // State
                                let currentLevel = 0;
                                let selections = { jra: null, pokok: null, sub: null };
                                let crumbs = [];

                                // Open/Close Logic
                                trigger.addEventListener('click', () => {
                                    if(hiddenInput.value) return; // Prevent opening if already selected
                                    toggleMenu();
                                });
                                
                                function toggleMenu(forceState = null) {
                                    const isHidden = menu.classList.contains('hidden');
                                    const show = forceState !== null ? forceState : isHidden;
                                    
                                    if(show) {
                                        menu.classList.remove('hidden');
                                        chevron.classList.add('rotate-180');
                                        // Load initial data if empty
                                        if(list.children.length === 0) loadOptions(0);
                                    } else {
                                        menu.classList.add('hidden');
                                        chevron.classList.remove('rotate-180');
                                    }
                                }

                                // Load Data
                                function loadOptions(level, parent = null, jraType = null) {
                                    list.innerHTML = '<li class="px-4 py-3 text-center text-gray-400 text-sm">Memuat data...</li>';
                                    
                                    let url = `${baseUrl}?level=${level}`;
                                    if (parent) url += `&parent=${encodeURIComponent(parent)}`;
                                    if (jraType) url += `&jra_type=${encodeURIComponent(jraType)}`;

                                    fetch(url)
                                        .then(res => res.json())
                                        .then(data => {
                                            renderList(data, level);
                                            updateHeader(level);
                                        })
                                        .catch(() => {
                                            list.innerHTML = '<li class="px-4 py-3 text-center text-[#e92027] text-sm">Gagal memuat data.</li>';
                                        });
                                }

                                function renderList(data, level) {
                                    list.innerHTML = '';
                                    if(data.length === 0) {
                                        list.innerHTML = '<li class="px-4 py-3 text-center text-gray-400 text-sm">Tidak ada opsi tersedia.</li>';
                                        return;
                                    }

                                    data.forEach(item => {
                                        const li = document.createElement('li');
                                        li.className = 'px-4 py-3 hover:bg-red-50 cursor-pointer text-gray-700 text-sm flex justify-between items-center transition-colors border-b border-gray-50 last:border-0 group';
                                        li.innerHTML = `
                                            <span class="font-medium group-hover:text-[#c41820]">${item.label}</span>
                                            <svg class="w-4 h-4 text-gray-300 group-hover:text-[#e92027]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                        `;
                                        
                                        li.addEventListener('click', (e) => {
                                            e.stopPropagation();
                                            handleSelection(item, level);
                                        });
                                        list.appendChild(li);
                                    });
                                }

                                function updateHeader(level) {
                                    const titles = ["PILIH JENIS JRA", "PILIH POKOK MASALAH", "PILIH SUB MASALAH", "PILIH KLASIFIKASI AKHIR"];
                                    header.textContent = titles[level];
                                    
                                    if(level > 0) {
                                        resetStepBtn.classList.remove('hidden');
                                    } else {
                                        resetStepBtn.classList.add('hidden');
                                    }
                                }

                                function handleSelection(item, level) {
                                    const val = item.id || item.code;
                                    const label = item.label;

                                    if(level === 0) {
                                        selections.jra = { code: val, label: label };
                                        crumbs = [label];
                                        loadOptions(1, null, val);
                                        currentLevel = 1;
                                    } 
                                    else if(level === 1) {
                                        selections.pokok = { code: val, label: label };
                                        crumbs = [selections.jra.label, item.code]; // Show code for compactness
                                        loadOptions(2, val);
                                        currentLevel = 2;
                                    } 
                                    else if(level === 2) {
                                        selections.sub = { code: val, label: label };
                                        crumbs = [selections.jra.label, selections.pokok.code, item.code];
                                        loadOptions(3, val);
                                        currentLevel = 3;
                                    } 
                                    else if(level === 3) {
                                        // Final
                                        hiddenInput.value = val;
                                        finalLabel.textContent = label;
                                        toggleMenu(false); // Close menu
                                        
                                        // Show Final Display
                                        trigger.classList.add('hidden'); // Hide trigger
                                        finalDisplay.classList.remove('hidden');
                                    }
                                    
                                    // Update Trigger Text Breadcrumbs
                                    if(level < 3) {
                                        subTriggerText.textContent = crumbs.join(' > ');
                                        subTriggerText.classList.remove('text-gray-500');
                                        subTriggerText.classList.add('text-gray-900');
                                    }
                                }

                                // Reset Step Logic (Back Button)
                                resetStepBtn.addEventListener('click', (e) => {
                                    e.stopPropagation();
                                    if(currentLevel > 0) {
                                        currentLevel--;
                                        if (currentLevel === 0) {
                                            crumbs = [];
                                            subTriggerText.textContent = "Pilih Kode Klasifikasi";
                                            subTriggerText.classList.add('text-gray-500');
                                            loadOptions(0);
                                        } else if (currentLevel === 1) {
                                            crumbs = [selections.jra.label];
                                            subTriggerText.textContent = crumbs.join(' > ');
                                            loadOptions(1, null, selections.jra.code);
                                        } else if (currentLevel === 2) {
                                            crumbs = [selections.jra.label, selections.pokok.code];
                                            subTriggerText.textContent = crumbs.join(' > ');
                                            loadOptions(2, selections.pokok.code);
                                        }
                                    }
                                });


                                // Full Reset (X button on success card)
                                fullResetBtn.addEventListener('click', () => {
                                    currentLevel = 0;
                                    selections = { jra: null, pokok: null, sub: null };
                                    hiddenInput.value = "";
                                    
                                    finalDisplay.classList.add('hidden');
                                    trigger.classList.remove('hidden');
                                    subTriggerText.textContent = "Pilih Kode Klasifikasi";
                                    subTriggerText.classList.add('text-gray-500');
                                    
                                    loadOptions(0);
                                });

                                // Close clicking outside
                                document.addEventListener('click', (e) => {
                                    if(!trigger.contains(e.target) && !menu.contains(e.target)) {
                                        toggleMenu(false);
                                    }
                                });
                            });
                            </script>

                            <div>
                                <label class="block text-gray-800 font-bold mb-2 text-sm">Nama Berkas</label>
                                <input type="text" name="nama_berkas" required 
                                    value="{{ old('nama_berkas', $berkas->nama_berkas ?? '') }}"
                                    class="w-full bg-white border border-gray-300 rounded-xl p-4 focus:ring-1 focus:ring-[#e92027] focus:outline-none placeholder-gray-400 transition-shadow">
                            </div>

                            <div>
                                <label class="block text-gray-800 font-bold mb-2 text-sm">Isi Berkas</label>
                                <textarea name="isi_berkas" rows="3" 
                                    class="w-full bg-white border border-gray-300 rounded-xl p-4 focus:ring-1 focus:ring-[#e92027] focus:outline-none placeholder-gray-400 transition-shadow">{{ old('isi_berkas', $berkas->isi_berkas ?? '') }}</textarea>
                            </div>

                            <div>
                                <label class="block text-gray-800 font-bold mb-2 text-sm">Tanggal Berkas</label>
                                <input type="date" name="tanggal_berkas" 
                                    value="{{ old('tanggal_berkas', $berkas->tanggal_berkas ?? '') }}"
                                    class="w-full bg-white border border-gray-300 rounded-xl p-4 focus:ring-1 focus:ring-[#e92027] focus:outline-none placeholder-gray-400 transition-shadow">
                            </div>

                            <div>
                                <label class="block text-gray-800 font-bold mb-2 text-sm">Jumlah</label>
                                <input type="number" name="jumlah" 
                                    value="{{ old('jumlah', $berkas->jumlah ?? '') }}"
                                    class="w-full bg-white border border-gray-300 rounded-xl p-4 focus:ring-1 focus:ring-[#e92027] focus:outline-none placeholder-gray-400 transition-shadow">
                            </div>

                            <div class="flex gap-3 mt-4">
                                @if(isset($berkas))
                                    <a href="{{ route('arsip-masuk.berkas.create', $arsipMasuk->id) }}" class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-bold py-4 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 text-center">
                                        Batal Edit
                                    </a>
                                @endif
                                <button type="submit" class="flex-1 bg-[#e92027] hover:bg-[#a92b2b] text-white font-bold py-4 rounded-xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5">
                                    {{ isset($berkas) ? 'Simpan Perubahan' : 'Tambah Berkas' }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- List Berkas Table -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-lg border border-red-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                        <h3 class="text-lg font-bold text-gray-800">Daftar Berkas Terinput</h3>
                        <span class="bg-red-100 text-[#e92027] text-xs font-bold px-3 py-1 rounded-full">{{ $arsipMasuk->berkas->count() }} Berkas</span>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-center">
                            <thead class="bg-gray-100 text-gray-700">
                                <tr>
                                    <th class="py-3 px-4">No Box</th>
                                    <th class="py-3 px-4">Klasifikasi</th>
                                    <th class="py-3 px-4">Nama Berkas</th>
                                    <th class="py-3 px-4">Tgl Berkas</th>
                                    <th class="py-3 px-4">Masa Simpan</th>
                                    <th class="py-3 px-4">Tindakan Akhir</th>
                                    <th class="py-3 px-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($arsipMasuk->berkas as $file)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-3 px-4">{{ $file->no_box }}</td>
                                    <td class="py-3 px-4 font-medium text-gray-900">{{ $file->klasifikasi->kode_klasifikasi }}</td>
                                    <td class="py-3 px-4">{{ $file->nama_berkas }}</td>
                                    <td class="py-3 px-4">{{ \Carbon\Carbon::parse($file->tanggal_berkas)->format('d/m/Y') }}</td>
                                    <td class="py-3 px-4">
                                        <div class="flex flex-col text-xs">
                                            <span class="font-semibold text-gray-700">Aktif: {{ $file->klasifikasi->aktif }}</span>
                                            <span class="text-gray-500">Inaktif: {{ $file->klasifikasi->inaktif }}</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4">
                                        @if($file->klasifikasi->tindakan_akhir == 'Musnah')
                                            <span class="px-2 py-1 bg-red-100 text-[#c41820] rounded-full text-xs font-bold">Musnah</span>
                                        @else
                                            <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-bold">{{ $file->klasifikasi->tindakan_akhir }}</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="flex justify-center gap-2">
                                            <a href="{{ route('arsip-masuk.berkas.edit', ['id' => $arsipMasuk->id, 'berkasId' => $file->id]) }}" class="text-blue-500 hover:text-blue-700">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            </a>
                                            <form action="{{ route('arsip-masuk.berkas.destroy', ['id' => $arsipMasuk->id, 'berkasId' => $file->id]) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="text-[#e92027] hover:text-[#c41820] delete-btn-berkas">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="py-8 text-gray-400 italic">Belum ada berkas ditambahkan.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <a href="{{ route('arsip-masuk.index') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-lg shadow-lg transform transition hover:scale-105">
                        Selesai & Simpan Semua
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SweetAlert2 Script -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('.delete-btn-berkas');
        
        deleteButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('form');
                
                Swal.fire({
                    title: 'Hapus Berkas?',
                    text: "Apakah Anda yakin ingin menghapus berkas ini? Data yang dihapus tidak dapat dikembalikan.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#e92027',
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
    });
</script>

</x-layout>