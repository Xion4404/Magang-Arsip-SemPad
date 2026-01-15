<x-layout>
    <div class="max-w-4xl mx-auto my-10">
        <div class="bg-[#8B1A1A] rounded-t-2xl shadow-lg relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-r from-red-900 to-[#8B1A1A]"></div>
            <div class="absolute top-0 right-0 p-4 opacity-10">
                 <svg class="w-24 h-24 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <div class="p-8 relative z-10">
                <h2 class="text-3xl font-bold text-white">Edit Monitoring Kinerja Karyawan</h2>
                <p class="text-red-100 mt-2">Silakan ubah data monitoring di bawah ini</p>
            </div>
        </div>
        
        <div class="bg-white p-8 rounded-b-2xl shadow-xl border border-red-50">
            <form action="{{ route('monitoring.update', $monitoring->id) }}" method="POST">
                 @csrf
                 @method('PUT')
                 <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-6">
                     <!-- PIC -->
                     <div>
                         <label class="block text-gray-800 font-bold mb-2 text-sm">PIC</label>
                         <select name="user_id" required class="w-full bg-[#FFF5F5] border border-red-200 rounded-lg p-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#8B1A1A]">
                             @foreach($users as $user)
                                 <option value="{{ $user->id }}" {{ $monitoring->user_id == $user->id ? 'selected' : '' }}>{{ $user->nama }}</option>
                             @endforeach
                         </select>
                     </div>

                     <!-- Tanggal Kerja -->
                     <div>
                         <label class="block text-gray-800 font-bold mb-2 text-sm">Tanggal Kerja</label>
                         <input type="date" name="tanggal_kerja" value="{{ $monitoring->tanggal_kerja }}" required class="w-full bg-[#FFF5F5] border border-red-200 rounded-lg p-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#8B1A1A]">
                     </div>

                     <!-- Nomor Box (Filter) -->
                     <div>
                         <label class="block text-gray-800 font-bold mb-2 text-sm">Nomor Box</label>
                         @php
                            $currentBox = null;
                            if (preg_match('/Pengerjaan Box:\s*([^\s|]+)/', $monitoring->keterangan, $matches)) {
                                $currentBox = $matches[1];
                            }
                            $uniqueBoxes = $allBerkas->unique('no_box')->sortBy('no_box');
                         @endphp
                         <select id="box_filter" class="w-full bg-[#FFF5F5] border border-red-200 rounded-lg p-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#8B1A1A]">
                             <option value="" disabled {{ is_null($currentBox) ? 'selected' : '' }}>Pilih Nomor Box</option>
                             @foreach($uniqueBoxes as $box)
                                 <option value="{{ $box->no_box }}" {{ $currentBox == $box->no_box ? 'selected' : '' }}>Box {{ $box->no_box }}</option>
                             @endforeach
                         </select>
                     </div>

                     <!-- Jumlah Box Selesai -->
                     <div>
                         <label class="block text-gray-800 font-bold mb-2 text-sm">Jumlah Box Selesai</label>
                         <input type="number" name="jumlah_box_selesai" value="{{ $monitoring->jumlah_box_selesai }}" class="w-full bg-[#FFF5F5] border border-red-200 rounded-lg p-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#8B1A1A]" placeholder="0">
                     </div>

                     <!-- Nama Berkas -->
                     <div>
                         <label class="block text-gray-800 font-bold mb-2 text-sm">Nama Berkas</label>
                         @php
                            $currentBerkasName = null;
                            $currentBerkasId = null;
                            if (preg_match('/Berkas:\s*([^|]+)/', $monitoring->keterangan, $matches)) {
                                $currentBerkasName = trim($matches[1]);
                                // Try to find the ID based on name and box/arsip if possible, 
                                // but name is unique enough for display. 
                                // To find ID, we check $allBerkas.
                                // We filtered by Box, so we should look for name in that box? 
                                // Actually we just need to find *a* berkas that matches to set the ID.
                                $foundBerkas = $allBerkas->first(function($item) use ($currentBerkasName, $currentBox) {
                                    return $item->nama_berkas === $currentBerkasName && 
                                           ($currentBox ? $item->no_box == $currentBox : true);
                                });
                                if($foundBerkas) $currentBerkasId = $foundBerkas->id;
                            }
                         @endphp
                         <select name="berkas_id" id="berkas_select" required class="w-full bg-[#FFF5F5] border border-red-200 rounded-lg p-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#8B1A1A]" data-selected="{{ $currentBerkasId }}">
                             <option value="" disabled selected>Pilih Nomor Box Terlebih Dahulu</option>
                             <!-- Options populated by JS -->
                         </select>
                     </div>

                     <!-- Tahapan Pengarsipan -->
                     <div>
                         <label class="block text-gray-800 font-bold mb-2 text-sm">Tahapan Pengarsipan</label>
                         <select name="tahapan" required class="w-full bg-[#FFF5F5] border border-red-200 rounded-lg p-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#8B1A1A]">
                            <option value="" disabled>Pilih Tahapan</option>
                            <option value="Pemilahan" {{ $monitoring->tahapan == 'Pemilahan' ? 'selected' : '' }}>Pemilahan</option>
                            <option value="Pendataan" {{ $monitoring->tahapan == 'Pendataan' ? 'selected' : '' }}>Pendataan</option>
                            <option value="Pelabelan" {{ $monitoring->tahapan == 'Pelabelan' ? 'selected' : '' }}>Pelabelan</option>
                         </select>
                     </div>

                     <!-- Keterangan -->
                     <div class="md:col-span-2">
                         <label class="block text-gray-800 font-bold mb-2 text-sm">Keterangan</label>
                         <textarea name="keterangan" rows="3" class="w-full bg-[#FFF5F5] border border-red-200 rounded-lg p-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#8B1A1A]" placeholder="Opsional">{{ $monitoring->keterangan }}</textarea>
                     </div>

                     <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const boxFilter = document.getElementById('box_filter');
                            const berkasSelect = document.getElementById('berkas_select');
                            const allBerkas = @json($allBerkas);
                            const initialSelectedBerkasId = berkasSelect.getAttribute('data-selected');

                            function filterBerkas(selectedId = null) {
                                const selectedBox = boxFilter.value;
                                
                                berkasSelect.innerHTML = '<option value="" disabled selected>Pilih Nama Berkas</option>';
                                
                                if (!selectedBox) return;

                                const filtered = allBerkas.filter(item => item.no_box == selectedBox);
                                
                                if (filtered.length === 0) {
                                    berkasSelect.innerHTML = '<option value="" disabled>Tidak ada berkas di box ini</option>';
                                    return;
                                }

                                filtered.forEach(item => {
                                    const option = document.createElement('option');
                                    option.value = item.id;
                                    const unitAsal = item.arsip_masuk ? item.arsip_masuk.unit_asal : '-';
                                    option.textContent = `${item.nama_berkas} (${unitAsal})`;
                                    
                                    if(selectedId && item.id == selectedId) {
                                        option.selected = true;
                                    }
                                    
                                    berkasSelect.appendChild(option);
                                });
                            }

                            if(boxFilter) {
                                boxFilter.addEventListener('change', () => filterBerkas());
                                
                                // Initial load
                                if(boxFilter.value) {
                                    filterBerkas(initialSelectedBerkasId);
                                }
                            }
                        });
                     </script>
    
                     <!-- Empty Div for Spacing -->
                     <div class="hidden md:block"></div>
    
                 </div>
    
                 <div class="flex justify-end mt-10 gap-4">
                     <a href="{{ route('monitoring.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-10 rounded-lg shadow-lg transform transition hover:scale-105 flex items-center justify-center">
                         Kembali
                     </a>
                     <button type="submit" class="bg-[#8B1A1A] hover:bg-[#6e1515] text-white font-bold py-3 px-10 rounded-lg shadow-lg transform transition hover:scale-105">
                         Update
                     </button>
                 </div>
            </form>
        </div>
    </div>
</x-layout>