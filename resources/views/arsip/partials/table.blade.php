<div class="overflow-x-auto">
    <table class="w-full text-center border-collapse text-[11px] md:text-xs">
        <thead>
            <tr class="border-b-2 border-red-50">
                <th class="py-4 font-bold text-red-800 w-10 selection-col">
                    <input type="checkbox" onclick="toggleAll(this)" class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                </th>
                @foreach(['No Berkas', 'Kode Klasifikasi', 'Nama Berkas', 'Isi Berkas', 'Tahun Berkas', 'Tanggal Masuk Berkas', 'Jumlah', 'Masa Simpan', 'Permanen/Musnah', 'No. Box/Lokasi'] as $header)
                    <th class="py-4 font-bold text-red-800">{{ $header }}</th>
                @endforeach
                <th class="py-4 font-bold text-red-800 jenis-arsip-col">Jenis Arsip</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-red-50">
            @forelse ($arsips as $arsip)
            <tr class="hover:bg-red-50/50 transition duration-150">
                <td class="py-4 w-10 selection-col">
                    <input type="checkbox" name="selected_arsip[]" value="{{ $arsip->id }}" class="rounded border-gray-300 text-red-600 focus:ring-red-500">
                </td>
                <td class="py-4 text-red-900 font-medium">{{ $arsip->no_berkas }}</td>
                <td class="py-4 text-red-900">{{ $arsip->klasifikasi->kode_klasifikasi ?? '-' }}</td>
                <td class="py-4 text-red-900">{{ $arsip->nama_berkas }}</td>
                <td class="py-4 text-red-900 italic">
                    <span class="print:hidden">{{ Str::limit($arsip->isi_berkas, 30) }}</span>
                    <span class="hidden print:block">{{ $arsip->isi_berkas }}</span>
                </td>
                <td class="py-4 text-red-900">{{ $arsip->tahun }}</td>
                <td class="py-4 text-red-900">{{ \Carbon\Carbon::parse($arsip->tanggal_masuk)->format('d/m/y') }}</td>
                <td class="py-4 text-red-900 font-bold">{{ $arsip->jumlah }}</td>
                <td class="py-4 text-red-900">{{ $arsip->klasifikasi->masa_simpan ?? '-' }}</td>
                <td class="py-4 text-red-900">{{ $arsip->klasifikasi->tindakan_akhir ?? '-' }}</td>
                <td class="py-4 text-red-900">{{ $arsip->no_box }}</td>
                <td class="py-4 text-red-900 jenis-arsip-col">{{ $arsip->jenis_media }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="12" class="py-8 text-center text-gray-500 italic">Belum ada data arsip.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-8">
    {{ $arsips->appends(request()->query())->links() }}
</div>
