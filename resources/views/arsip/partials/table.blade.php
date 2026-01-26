<div class="overflow-x-auto rounded-t-3xl text-sm">
    <table class="w-full text-left border-collapse min-w-[1000px]">
        <thead>
            <tr class="bg-red-900 text-white uppercase tracking-wider text-xs shadow-md">
                <th class="py-5 px-4 font-bold w-12 text-center rounded-tl-3xl">
                    <input type="checkbox" onclick="toggleAll(this)" class="rounded border-none focus:ring-0 text-red-600 bg-white cursor-pointer w-4 h-4">
                </th>
                
                {{-- Main Info --}}
                <th class="py-5 px-4 font-bold whitespace-nowrap">No Berkas</th>
                <th class="py-5 px-4 font-bold whitespace-nowrap">Kode Klasifikasi</th>
                <th class="py-5 px-4 font-bold whitespace-nowrap">Nama Berkas</th>
                
                {{-- Details --}}
                <th class="py-5 px-4 font-bold min-w-[250px]">Isi Berkas</th>
                <th class="py-5 px-4 font-bold text-center whitespace-nowrap">Tahun</th>
                <th class="py-5 px-4 font-bold text-center whitespace-nowrap">Tanggal</th>
                <th class="py-5 px-4 font-bold text-center whitespace-nowrap">Jml</th>

                {{-- Statuses --}}
                <th class="py-5 px-4 font-bold text-center whitespace-nowrap">Hak Akses</th>
                <th class="py-5 px-4 font-bold text-center whitespace-nowrap">Masa Simpan</th>
                <th class="py-5 px-4 font-bold text-center whitespace-nowrap">Tindakan</th>
                <th class="py-5 px-4 font-bold text-center whitespace-nowrap">Box</th>

                {{-- Context --}}
                <th class="py-5 px-4 font-bold whitespace-nowrap">Unit Pengolah</th>
                <th class="py-5 px-4 font-bold text-center whitespace-nowrap rounded-tr-3xl">Jenis</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 bg-white">
            @forelse ($arsips as $arsip)
                <tr class="group hover:bg-red-50/40 transition-all duration-200 hover:shadow-sm">
                    {{-- Checkbox --}}
                    <td class="py-5 px-4 text-center border-r border-gray-100 align-top bg-gray-50/30 group-hover:bg-transparent">
                        <input type="checkbox" name="selected_arsip[]" value="{{ $arsip->id }}" class="rounded border-gray-300 text-red-600 focus:ring-red-500 cursor-pointer">
                    </td>
                    
                    {{-- Main Info --}}
                    <td class="py-5 px-4 font-bold text-gray-800 align-top border-r border-gray-100 bg-gray-50/30 group-hover:bg-transparent">
                        <span class="font-mono text-red-900 bg-red-100/50 py-1 px-2 rounded whitespace-nowrap">{{ $arsip->no_berkas }}</span>
                    </td>
                    <td class="py-5 px-4 text-gray-700 font-medium align-top border-r border-gray-100 bg-gray-50/30 group-hover:bg-transparent">
                        <div class="flex items-center gap-2 whitespace-nowrap">
                             <span class="w-2 h-2 rounded-full bg-red-500"></span>
                             {{ $arsip->klasifikasi->kode_klasifikasi ?? '-' }}
                        </div>
                        <div class="text-xs text-gray-500 mt-1 max-w-[150px] truncate" title="{{ $arsip->klasifikasi->jenis_arsip ?? '' }}">
                            {{ $arsip->klasifikasi->jenis_arsip ?? '' }}
                        </div>
                    </td>
                    <td class="py-5 px-4 text-gray-900 font-bold text-base align-top border-r border-gray-100 bg-gray-50/30 group-hover:bg-transparent">
                        {{ $arsip->nama_berkas }}
                    </td>

                    {{-- Details (Using Accessors) --}}
                    <td class="py-5 px-4 text-gray-700 align-top border-r border-gray-100 leading-relaxed">
                        {{ $arsip->isi }}
                    </td>
                    <td class="py-5 px-4 text-center text-gray-600 font-medium border-r border-gray-100">
                        {{ $arsip->tahun }}
                    </td>
                    <td class="py-5 px-4 text-center text-gray-500 text-xs border-r border-gray-100">
                        {{ $arsip->tanggal_masuk ? \Carbon\Carbon::parse($arsip->tanggal_masuk)->format('dM Y') : '-' }}
                    </td>
                     <td class="py-5 px-4 text-center font-bold text-gray-800 border-r border-gray-100">
                        {{ $arsip->jumlah }}
                    </td>

                    {{-- Metadata Pills --}}
                    <td class="py-5 px-4 text-center border-r border-gray-100">
                        @php
                            $akses = $arsip->hak_akses;
                            $colorClass = 'bg-gray-100 text-gray-700'; // Default
                            if(in_array($akses, ['Biasa', 'Terbuka'])) $colorClass = 'bg-green-100 text-green-700';
                            elseif($akses == 'Terbatas') $colorClass = 'bg-yellow-100 text-yellow-700';
                            elseif(in_array($akses, ['Rahasia', 'Tertutup'])) $colorClass = 'bg-red-100 text-red-700';
                            elseif($akses == 'Sangat Rahasia') $colorClass = 'bg-red-200 text-red-800';
                        @endphp
                        
                        @if($akses && $akses != '-')
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold {{ $colorClass }}">
                                {{ $akses }}
                            </span>
                        @else
                            <span class="text-gray-300">-</span>
                        @endif
                    </td>
                    <td class="py-5 px-4 text-center text-gray-600 border-r border-gray-100">
                        {{ $arsip->masa_simpan }}
                    </td>
                    <td class="py-5 px-4 text-center border-r border-gray-100">
                        @if ($arsip->tindakan_akhir == 'Musnah')
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-red-50 text-red-600 border border-red-100">
                                Musnah
                            </span>
                        @elseif($arsip->tindakan_akhir == 'Permanen')
                             <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-blue-50 text-blue-600 border border-blue-100">
                                Permanen
                            </span>
                        @else
                            <span class="text-gray-300 text-xs">-</span>
                        @endif
                    </td>
                    <td class="py-5 px-4 text-center font-mono text-xs font-bold text-gray-600 border-r border-gray-100">
                        {{ $arsip->no_box ?? '-' }}
                    </td>

                    {{-- Unit --}}
                    <td class="py-5 px-4 text-gray-600 text-xs font-medium border-r border-gray-100 align-top bg-gray-50/30 group-hover:bg-transparent">
                        {{ $arsip->unit_pengolah ?? '-' }}
                    </td>

                    {{-- Media --}}
                    <td class="py-5 px-4 text-center">
                        @if($arsip->jenis_media)
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-purple-50 text-purple-700 border border-purple-100">
                                {{ $arsip->jenis_media }}
                            </span>
                        @else
                            <span class="text-gray-300">-</span>
                        @endif
                    </td>
                </tr>

            @empty
            <tr>
                <td colspan="14" class="py-16 text-center">
                    <div class="flex flex-col items-center justify-center text-gray-400">
                        <div class="bg-gray-50 p-6 rounded-full mb-4">
                            <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <p class="text-lg font-bold text-gray-500">Belum ada data arsip</p>
                        <p class="text-sm">Silakan tambahkan arsip baru melalui tombol di atas.</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-8 px-4">
    {{ $arsips->appends(request()->query())->links() }}
</div>
