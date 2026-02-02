<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\DetailPeminjaman;
use App\Models\Arsip;
use App\Exports\PeminjamanExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        // 1. Statistik (Total Item Arsip)
        $totalPeminjaman = DetailPeminjaman::count();
        $masihDipinjam = DetailPeminjaman::whereHas('peminjaman', function ($q) {
            $q->where('status', 'Sedang Dipinjam');
        })->where('jenis_arsip', '!=', 'Softfile')->count();

        $sudahDikembalikan = DetailPeminjaman::where(function ($q) {
            $q->whereHas('peminjaman', function ($qp) {
                $qp->whereIn('status', ['Sudah Dikembalikan', 'Telah Dikembalikan']);
            })->orWhere('jenis_arsip', 'Softfile');
        })->count();

        // 2. Query Utama (Detail Based)
        $query = DetailPeminjaman::with(['peminjaman', 'arsip']);

        // 3. Filter Search
        if ($request->filled('search')) {
            $keyword = $request->search;
            $query->where(function ($q) use ($keyword) {
                // Cari di Parent
                $q->whereHas('peminjaman', function ($qP) use ($keyword) {
                    $qP->where('nama_peminjam', 'LIKE', "%$keyword%")
                        ->orWhere('nip', 'LIKE', "%$keyword%")
                        ->orWhere('unit_peminjam', 'LIKE', "%$keyword%");
                })
                    // Cari di Detail
                    ->orWhere('nama_arsip', 'LIKE', "%$keyword%")
                    ->orWhere('no_box', 'LIKE', "%$keyword%")
                    // Cari di Relasi Arsip
                    ->orWhereHas('arsip', function ($qArsip) use ($keyword) {
                        $qArsip->where('nama_berkas', 'LIKE', "%$keyword%")
                            ->orWhere('no_berkas', 'LIKE', "%$keyword%");
                    });
            });
        }

        // 4. Filter Lainnya
        if ($request->has('status') && $request->status != 'All') {
            $status = $request->status;

            if ($status == 'Sudah Dikembalikan') {
                $query->where(function ($q) {
                    $q->whereHas('peminjaman', function ($qp) {
                        $qp->whereIn('status', ['Sudah Dikembalikan', 'Telah Dikembalikan']);
                    })->orWhere('jenis_arsip', 'Softfile');
                });
            } else if ($status == 'Sedang Dipinjam') {
                $query->whereHas('peminjaman', function ($q) {
                    $q->where('status', 'Sedang Dipinjam');
                })->where('jenis_arsip', '!=', 'Softfile');
            } else {
                $query->whereHas('peminjaman', function ($q) use ($status) {
                    $q->where('status', $status);
                });
            }
        }

        if ($request->has('media') && $request->media != 'All') {
            $query->where('jenis_arsip', $request->media);
        }

        if ($request->has('keamanan') && $request->keamanan != 'All') {
            $query->where('hak_akses', $request->keamanan);
        }

        if ($request->start_date) {
            $query->whereHas('peminjaman', function ($q) use ($request) {
                $q->whereDate('tanggal_pinjam', '>=', $request->start_date);
            });
        }
        if ($request->end_date) {
            $query->whereHas('peminjaman', function ($q) use ($request) {
                $q->whereDate('tanggal_pinjam', '<=', $request->end_date);
            });
        }

        // 5. Sorting Dynamic
        $sort = $request->get('sort', 'latest_added');

        $query->select('detail_peminjaman.*')
            ->join('peminjaman', 'detail_peminjaman.peminjaman_id', '=', 'peminjaman.id');

        switch ($sort) {
            case 'oldest_added':
                $query->orderBy('detail_peminjaman.created_at', 'asc');
                break;
            case 'latest_date':
                $query->orderBy('peminjaman.tanggal_pinjam', 'desc');
                break;
            case 'oldest_date':
                $query->orderBy('peminjaman.tanggal_pinjam', 'asc');
                break;
            case 'latest_added':
            default:
                $query->orderBy('detail_peminjaman.created_at', 'desc');
                break;
        }

        // Pagination diperbesar jadi 25 agar semua data 22 baris muncul
        $peminjaman = $query->paginate(25)->withQueryString();

        return view('peminjaman.index', compact('peminjaman', 'totalPeminjaman', 'masihDipinjam', 'sudahDikembalikan'));
    }

    public function create()
    {
        // 1. Cek Arsip yang Sedang Dipinjam
        // Filter: whereNotNull agar data manual (NULL) tidak merusak query
        $arsipDipinjam = DetailPeminjaman::whereHas('peminjaman', function ($q) {
            $q->where('status', 'Sedang Dipinjam');
        })->whereNotNull('arsip_id')->pluck('arsip_id');

        // 2. Ambil Arsip Available
        $daftarArsip = Arsip::whereNotIn('id', $arsipDipinjam)
            ->select('id', 'nama_berkas', 'no_berkas', 'no_box', 'hak_akses', 'unit_pengolah')
            ->orderBy('nama_berkas', 'asc')
            ->get();

        return view('peminjaman.create', compact('daftarArsip'));
    }

    public function store(Request $request)
    {
        // 1. Validasi
        $request->validate([
            'tanggal' => 'required|date',
            'nama_peminjam' => 'required',
            'nip' => 'required',
            'unit' => 'required',
            'jabatan_peminjam' => 'required',
            'keperluan' => 'required',
            'items_source' => 'required|array|min:1',
            'bukti_pinjam.*' => 'nullable|file|mimes:jpeg,png,jpg,pdf,doc,docx|max:10240'
        ]);

        // 2. Validasi Ketersediaan (Double Check)
        $sources = $request->items_source;
        for ($i = 0; $i < count($sources); $i++) {
            if ($sources[$i] == 'db' && !empty($request->items_arsip_id[$i])) {
                $idArsip = $request->items_arsip_id[$i];
                $sedangDipinjam = DetailPeminjaman::where('arsip_id', $idArsip)
                    ->whereHas('peminjaman', function ($q) {
                        $q->where('status', 'Sedang Dipinjam');
                    })->exists();

                if ($sedangDipinjam) {
                    return back()->withErrors(['msg' => 'Gagal! Salah satu arsip sedang dipinjam orang lain.'])->withInput();
                }
            }
        }

        // 3. Upload File
        $filePaths = [];
        if ($request->hasFile('bukti_pinjam')) {
            foreach ($request->file('bukti_pinjam') as $file) {
                $filename = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
                $file->move(public_path('bukti_pinjam'), $filename);
                $filePaths[] = 'bukti_pinjam/' . $filename;
            }
        }

        // 4. Simpan Parent (Peminjaman)
        $peminjaman = Peminjaman::create([
            'tanggal_pinjam' => $request->tanggal,
            'nama_peminjam' => $request->nama_peminjam,
            'nip' => $request->nip,
            'unit_peminjam' => $request->unit,
            'jabatan_peminjam' => $request->jabatan_peminjam,
            'keperluan' => $request->keperluan,
            'bukti_peminjaman' => !empty($filePaths) ? json_encode($filePaths) : null,
            'status' => 'Sedang Dipinjam',
            'is_approved_khusus' => 0
        ]);

        // 5. Simpan Detail (DENGAN LOGIKA SNAPSHOT)
        for ($i = 0; $i < count($sources); $i++) {

            $arsipId = null;
            $namaArsip = null;
            $noBox = null;
            $hakAkses = $request->items_akses_manual[$i] ?? 'Biasa';

            // LOGIKA UTAMA: Tentukan Nama & Box
            if ($sources[$i] == 'db' && !empty($request->items_arsip_id[$i])) {
                // Jika dari DB, kita CARI datanya dan SIMPAN TEKSNYA juga
                $arsipMaster = Arsip::find($request->items_arsip_id[$i]);
                if ($arsipMaster) {
                    $arsipId = $arsipMaster->id;
                    $namaArsip = $arsipMaster->nama_berkas; // COPY NAMA
                    $noBox = $arsipMaster->no_box;          // COPY BOX
                    $hakAkses = $arsipMaster->klasifikasi_keamanan; // COPY AKSES
                }
            } else {
                // Jika Manual, ambil dari input
                $arsipId = null;
                $namaArsip = $request->items_nama_manual[$i];
                $noBox = $request->items_box_manual[$i];
            }

            DetailPeminjaman::create([
                'peminjaman_id' => $peminjaman->id,
                'arsip_id' => $arsipId,
                'nama_arsip' => $namaArsip, // Pasti terisi (Text)
                'no_arsip' => null,         // Dikosongkan sesuai request
                'no_box' => $noBox,         // Pasti terisi (Text)
                'hak_akses' => $hakAkses,
                'jenis_arsip' => $request->items_media[$i],
                'detail_fisik' => $request->items_fisik[$i] ?? null,
            ]);
        }

        return redirect('/peminjaman')->with('success', 'Data peminjaman berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $editData = Peminjaman::with(['details.arsip'])->findOrFail($id);

        $arsipDipinjam = DetailPeminjaman::whereHas('peminjaman', function ($q) use ($id) {
            $q->where('status', 'Sedang Dipinjam')
                ->where('id', '!=', $id);
        })->whereNotNull('arsip_id')->pluck('arsip_id');

        $daftarArsip = Arsip::whereNotIn('id', $arsipDipinjam)
            ->select('id', 'nama_berkas', 'no_berkas', 'no_box', 'klasifikasi_keamanan')
            ->orderBy('nama_berkas', 'asc')
            ->get();

        $currentItems = $editData->details->map(function ($detail) {
            return [
                'id' => $detail->arsip_id,
                'source' => $detail->arsip_id ? 'db' : 'manual',
                // Ambil dari detail->nama_arsip karena sekarang sudah pasti ada isinya (Snapshot)
                'display_name' => $detail->nama_arsip ?? ($detail->arsip->nama_berkas ?? '-'),
                'nama_manual' => $detail->nama_arsip,
                'no_box' => $detail->no_box,
                'akses' => $detail->hak_akses,
                'media' => $detail->jenis_arsip,
                'fisik' => $detail->detail_fisik
            ];
        });

        return view('peminjaman.edit', compact('editData', 'id', 'daftarArsip', 'currentItems'));
    }

    public function update(Request $request, $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        $request->validate([
            'tanggal' => 'required|date',
            'nama_peminjam' => 'required',
            'items_source' => 'required|array|min:1',
        ]);

        // Handle File
        $existingFiles = json_decode($peminjaman->bukti_peminjaman) ?? [];
        if (!is_array($existingFiles) && $peminjaman->bukti_peminjaman)
            $existingFiles = [$peminjaman->bukti_peminjaman];

        if ($request->boolean('delete_existing_bukti')) {
            foreach ($existingFiles as $file) {
                if (File::exists(public_path($file)))
                    File::delete(public_path($file));
            }
            $existingFiles = [];
        }

        if ($request->hasFile('bukti_pinjam')) {
            foreach ($request->file('bukti_pinjam') as $file) {
                $filename = time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
                $file->move(public_path('bukti_pinjam'), $filename);
                $existingFiles[] = 'bukti_pinjam/' . $filename;
            }
        }

        $peminjaman->update([
            'tanggal_pinjam' => $request->tanggal,
            'nama_peminjam' => $request->nama_peminjam,
            'nip' => $request->nip,
            'unit_peminjam' => $request->unit,
            'jabatan_peminjam' => $request->jabatan_peminjam,
            'keperluan' => $request->keperluan,
            'bukti_peminjaman' => count($existingFiles) > 0 ? json_encode($existingFiles) : null,
        ]);

        DetailPeminjaman::where('peminjaman_id', $id)->delete();

        if ($request->has('items_source')) {
            $sources = $request->items_source;
            for ($i = 0; $i < count($sources); $i++) {

                // Cek Validasi
                if ($sources[$i] == 'db' && !empty($request->items_arsip_id[$i])) {
                    $idArsip = $request->items_arsip_id[$i];
                    $sedangDipinjam = DetailPeminjaman::where('arsip_id', $idArsip)
                        ->where('peminjaman_id', '!=', $id)
                        ->whereHas('peminjaman', function ($q) {
                            $q->where('status', 'Sedang Dipinjam');
                        })->exists();

                    if ($sedangDipinjam)
                        return back()->withErrors(['msg' => 'Gagal update! Arsip dipinjam orang lain.']);
                }

                // SIAPKAN DATA (SNAPSHOT LOGIC JUGA DITERAPKAN DISINI)
                $arsipId = null;
                $namaArsip = null;
                $noBox = null;
                $hakAkses = $request->items_akses_manual[$i] ?? 'Biasa';

                if ($sources[$i] == 'db' && !empty($request->items_arsip_id[$i])) {
                    $arsipMaster = Arsip::find($request->items_arsip_id[$i]);
                    if ($arsipMaster) {
                        $arsipId = $arsipMaster->id;
                        $namaArsip = $arsipMaster->nama_berkas; // Copy Name
                        $noBox = $arsipMaster->no_box;          // Copy Box
                        $hakAkses = $arsipMaster->klasifikasi_keamanan; // Copy Akses
                    }
                } else {
                    $arsipId = null;
                    $namaArsip = $request->items_nama_manual[$i];
                    $noBox = $request->items_box_manual[$i];
                }

                DetailPeminjaman::create([
                    'peminjaman_id' => $id,
                    'arsip_id' => $arsipId,
                    'nama_arsip' => $namaArsip, // Pasti terisi
                    'no_arsip' => null,
                    'no_box' => $noBox,         // Pasti terisi
                    'hak_akses' => $hakAkses,
                    'jenis_arsip' => $request->items_media[$i],
                    'detail_fisik' => $request->items_fisik[$i] ?? null,
                ]);
            }
        }

        return redirect('/peminjaman')->with('success', 'Data peminjaman berhasil diperbarui!');
    }

    public function complete($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->update(['status' => 'Sudah Dikembalikan']);
        return back()->with('success', 'Arsip telah dikembalikan.');
    }

    public function destroy($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $files = json_decode($peminjaman->bukti_peminjaman) ?? [];
        if (!is_array($files) && $peminjaman->bukti_peminjaman)
            $files = [$peminjaman->bukti_peminjaman];

        foreach ($files as $file) {
            if (File::exists(public_path($file)))
                File::delete(public_path($file));
        }

        $peminjaman->delete();
        return back()->with('success', 'Data berhasil dihapus.');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;
        if (empty($ids)) {
            return back()->with('error', 'Tidak ada data yang dipilih.');
        }

        $count = 0;
        foreach ($ids as $id) {
            $detail = DetailPeminjaman::find($id);
            if ($detail) {
                $peminjamanId = $detail->peminjaman_id;
                $detail->delete();
                $count++;

                // Cek apakah parent peminjaman sudah kosong
                $remainingDetails = DetailPeminjaman::where('peminjaman_id', $peminjamanId)->count();
                if ($remainingDetails == 0) {
                    $peminjaman = Peminjaman::find($peminjamanId);
                    if ($peminjaman) {
                        // Hapus file bukti jika ada
                        $files = json_decode($peminjaman->bukti_peminjaman) ?? [];
                        if (!is_array($files) && $peminjaman->bukti_peminjaman)
                            $files = [$peminjaman->bukti_peminjaman];

                        foreach ($files as $file) {
                            if (File::exists(public_path($file)))
                                File::delete(public_path($file));
                        }
                        $peminjaman->delete();
                    }
                }
            }
        }

        return back()->with('success', "$count data berhasil dihapus.");
    }

    public function export(Request $request)
    {
        $namaFile = 'Laporan_Peminjaman_' . date('d-m-Y_H-i') . '.xlsx';
        return Excel::download(new PeminjamanExport($request->all()), $namaFile);
    }
}