<div class="overflow-x-auto">
    <table class="w-full text-center border-collapse text-[11px] md:text-xs">
        <thead>
            <tr class="border-b-2 border-red-50">
                <th class="py-4 font-bold text-red-800 w-10 selection-col">
                    <input type="checkbox" onclick="toggleAll(this)" class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                </th>
                {{-- Parent Headers --}}
                <th class="py-4 font-bold text-red-800">No Berkas</th>
                <th class="py-4 font-bold text-red-800">Kode Klasifikasi</th>
                <th class="py-4 font-bold text-red-800">Nama Berkas</th>
                
                {{-- Child Headers --}}
                <th class="py-4 font-bold text-red-800 w-1/4">Isi Berkas</th>
                <th class="py-4 font-bold text-red-800">Tahun</th>
                <th class="py-4 font-bold text-red-800">Tanggal</th>
                <th class="py-4 font-bold text-red-800">Jumlah</th>

                {{-- Child Headers (Metadata) --}}
                <th class="py-4 font-bold text-red-800">Hak Akses</th>
                <th class="py-4 font-bold text-red-800">Masa Simpan</th>
                <th class="py-4 font-bold text-red-800 px-3">Permanen/Musnah</th>
                <th class="py-4 font-bold text-red-800">No. Box</th>

                {{-- Parent Headers --}}
                <th class="py-4 font-bold text-red-800">Unit</th>
                <th class="py-4 font-bold text-red-800 jenis-arsip-col">Jenis Arsip</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-red-50">
            @forelse ($arsips as $arsip)
                @php 
                    $isiCount = $arsip->isiArsip->count();
                    $rowspan = $isiCount > 0 ? $isiCount : 1;
                    $firstIsi = $isiCount > 0 ? $arsip->isiArsip->first() : null;
                @endphp

                <tr class="hover:bg-red-50/50 transition duration-150 align-top group">
                    {{-- Parent Columns (First Row) --}}
                    <td class="py-4 w-10 selection-col border-r border-red-50" rowspan="{{ $rowspan }}">
                        <input type="checkbox" name="selected_arsip[]" value="{{ $arsip->id }}" class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                    </td>
                    <td class="py-4 text-red-900 font-medium border-r border-red-50" rowspan="{{ $rowspan }}">
                        {{ $arsip->no_berkas }}
                    </td>
                    <td class="py-4 text-red-900 border-r border-red-50" rowspan="{{ $rowspan }}">
                        {{ $arsip->klasifikasi->kode_klasifikasi ?? '-' }}
                    </td>
                    <td class="py-4 text-red-900 border-r border-red-50 px-2" rowspan="{{ $rowspan }}">
                        {{ $arsip->nama_berkas }}
                    </td>

                    {{-- First Child Row --}}
                    {{-- Isi, Tahun, Tanggal, Jumlah --}}
                    <td class="py-4 text-red-900 italic text-left px-2 border-r border-red-50">
                        {{ $firstIsi ? $firstIsi->isi : '-' }}
                    </td>
                    <td class="py-4 text-red-900 border-r border-red-50">
                        {{ $firstIsi ? $firstIsi->tahun : ($arsip->tahun ?? '-') }}
                    </td>
                    <td class="py-4 text-red-900 border-r border-red-50">
                        {{ $firstIsi && $firstIsi->tanggal ? \Carbon\Carbon::parse($firstIsi->tanggal)->format('d/m/y') : ($arsip->tanggal_masuk ? \Carbon\Carbon::parse($arsip->tanggal_masuk)->format('d/m/y') : '-') }}
                    </td>
                     <td class="py-4 text-red-900 font-bold border-r border-red-50">
                        {{ $firstIsi ? $firstIsi->jumlah : ($arsip->jumlah ?? '-') }}
                    </td>

                    {{-- Child Metadata: Hak Akses, Masa Simpan, Tindakan, No Box --}}
                    <td class="py-4 text-red-900 border-r border-red-50">
                        {{ $firstIsi->hak_akses ?? '-' }}
                    </td>
                    <td class="py-4 text-red-900 border-r border-red-50">
                        {{ $firstIsi->masa_simpan ?? ($arsip->klasifikasi->masa_simpan ?? '-') }}
                    </td>
                    <td class="py-4 text-red-900 border-r border-red-50">
                        {{ $firstIsi->tindakan_akhir ?? ($arsip->klasifikasi->tindakan_akhir ?? '-') }}
                    </td>
                    <td class="py-4 text-red-900 border-r border-red-50">
                        {{ $firstIsi->no_box ?? '-' }}
                    </td>

                    {{-- Parent Column: Unit --}}
                    <td class="py-4 text-red-900 border-r border-red-50" rowspan="{{ $rowspan }}">
                        {{ $arsip->unit_pengolah ?? '-' }}
                    </td>

                    {{-- Child Column: Media --}}
                    <td class="py-4 text-red-900 jenis-arsip-col">
                        {{ $firstIsi->jenis_media ?? '-' }}
                    </td>
                </tr>

                {{-- Remaining Child Rows --}}
                @if($isiCount > 1)
                    @foreach($arsip->isiArsip->skip(1) as $isi)
                    <tr class="hover:bg-red-50/50 transition duration-150 align-top">
                        <td class="py-4 text-red-900 italic text-left px-2 border-r border-red-50">
                            {{ $isi->isi }}
                        </td>
                        <td class="py-4 text-red-900 border-r border-red-50">
                            {{ $isi->tahun ?? '-' }}
                        </td>
                        <td class="py-4 text-red-900 border-r border-red-50">
                            {{ $isi->tanggal ? \Carbon\Carbon::parse($isi->tanggal)->format('d/m/y') : '-' }}
                        </td>
                         <td class="py-4 text-red-900 font-bold border-r border-red-50">
                            {{ $isi->jumlah ?? '-' }}
                        </td>
                        <td class="py-4 text-red-900 border-r border-red-50">
                            {{ $isi->hak_akses ?? '-' }}
                        </td>
                        <td class="py-4 text-red-900 border-r border-red-50">
                            {{ $isi->masa_simpan ?? '-' }}
                        </td>
                        <td class="py-4 text-red-900 border-r border-red-50">
                            {{ $isi->tindakan_akhir ?? '-' }}
                        </td>
                        <td class="py-4 text-red-900 border-r border-red-50">
                            {{ $isi->no_box ?? '-' }}
                        </td>
                        {{-- Unit skipped (rowspan) --}}
                        <td class="py-4 text-red-900 jenis-arsip-col">
                            {{ $isi->jenis_media ?? '-' }}
                        </td>
                    </tr>
                    @endforeach
                @endif

            @empty
            <tr>
                <td colspan="14" class="py-8 text-center text-gray-500 italic">Belum ada data arsip.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-8">
    {{ $arsips->appends(request()->query())->links() }}
</div>
