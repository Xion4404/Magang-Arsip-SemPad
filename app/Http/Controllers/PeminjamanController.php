<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Arsip;
use App\Exports\PeminjamanExport; 
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Str;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        // 1. Statistik
        $totalPeminjaman = Peminjaman::count();
        $masihDipinjam = Peminjaman::where('status', 'Sedang Dipinjam')->count();
        $sudahDikembalikan = Peminjaman::whereIn('status', ['Sudah Dikembalikan', 'Telah Dikembalikan'])->count();

        // 2. Query Dasar
        $query = Peminjaman::with('arsip');

        // --- FILTERING START ---

        // A. Filter Search (Nama, NIP, Unit, Nama Arsip)
        if ($request->has('search') && $request->search != null) {
            $keyword = $request->search;
            $query->where(function($q) use ($keyword) {
                $q->where('nama_peminjam', 'LIKE', "%$keyword%")
                  ->orWhere('nip', 'LIKE', "%$keyword%")
                  ->orWhere('unit_peminjam', 'LIKE', "%$keyword%")
                  ->orWhereHas('arsip', function($qArsip) use ($keyword) {
                      $qArsip->where('nama_berkas', 'LIKE', "%$keyword%")
                             ->orWhere('no_berkas', 'LIKE', "%$keyword%");
                  });
            });
        }

        // B. Filter Status (Radio Button)
        if ($request->has('status') && $request->status != 'All') {
            if ($request->status == 'Sudah Dikembalikan') {
                $query->whereIn('status', ['Sudah Dikembalikan', 'Telah Dikembalikan']);
            } else {
                $query->where('status', $request->status);
            }
        }

        // C. Filter Media (Softfile / Hardfile)
        if ($request->has('media') && $request->media != 'All') {
            // Menggunakan LIKE karena isi database bisa "Hardfile - Asli"
            $query->where('jenis_dokumen', 'LIKE', '%' . $request->media . '%');
        }

        // D. Filter Keamanan (Rahasia / Terbatas / Biasa)
        if ($request->has('keamanan') && $request->keamanan != 'All') {
            $keamanan = $request->keamanan;
            // Gunakan whereHas untuk cek ke tabel relasi 'arsip'
            $query->whereHas('arsip', function($q) use ($keamanan) {
                $q->where('klasifikasi_keamanan', $keamanan);
            });
        }

        // E. Filter Tanggal
        if ($request->start_date) {
            $query->whereDate('tanggal_pinjam', '>=', $request->start_date);
        }
        if ($request->end_date) {
            $query->whereDate('tanggal_pinjam', '<=', $request->end_date);
        }

        // --- FILTERING END ---

        $peminjaman = $query->orderBy('id', 'desc')->get();

        return view('peminjaman.index', compact('peminjaman', 'totalPeminjaman', 'masihDipinjam', 'sudahDikembalikan'));
    }

    // --- FUNGSI LAINNYA TETAP SAMA (CREATE, STORE, EDIT, UPDATE, DLL) ---
    // Pastikan fungsi create, store, edit, update, destroy, complete, export tetap ada di bawah ini.
    // Copy fungsi-fungsi tersebut dari kode sebelumnya jika tertimpa.
    
    public function create()
    {
        $idSedangDipinjam = Peminjaman::where('status', 'Sedang Dipinjam')->pluck('arsip_id')->toArray();
        $daftarArsip = Arsip::whereNotIn('id', $idSedangDipinjam)
                            ->select('id', 'nama_berkas', 'no_berkas', 'klasifikasi_keamanan', 'unit_pengolah')
                            ->get();
        return view('peminjaman.create', compact('daftarArsip'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'nama_peminjam' => 'required',
            'nip' => 'required|numeric',
            'unit' => 'required',
            'jabatan_peminjam' => 'required',
            'jenis_dokumen_utama' => 'required',
            'bukti_pinjam' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'arsip_id' => 'required|array'
        ]);

        $jenisDokumenFinal = $request->jenis_dokumen_utama;
        if ($request->jenis_dokumen_utama == 'Hardfile' && $request->has('detail_fisik')) {
            $jenisDokumenFinal .= ' - ' . $request->detail_fisik; 
        }

        $daftarArsipDipilih = Arsip::whereIn('id', $request->arsip_id)->get();

        foreach ($daftarArsipDipilih as $arsip) {
            $levelArsip = $arsip->klasifikasi_keamanan ?? 'Biasa/Terbuka';
            $jabatan    = $request->jabatan_peminjam;
            $unitUser   = $request->unit;
            $unitArsip  = $arsip->unit_pengolah; 
            
            $isAllowed = false;
            $pesanError = "";

            if ($levelArsip == 'Biasa/Terbuka') {
                $isAllowed = true;
            } elseif ($levelArsip == 'Terbatas') {
                if (in_array($jabatan, ['Direksi', 'Auditor', 'Legal'])) {
                    $isAllowed = true; 
                } elseif (in_array($jabatan, ['Band I', 'Band II', 'Band III'])) {
                    if ($unitArsip && strcasecmp($unitUser, $unitArsip) == 0) {
                        $isAllowed = true;
                    } else {
                        $pesanError = "Pimpinan ($jabatan) hanya boleh akses Arsip Terbatas milik unitnya sendiri.";
                    }
                } else {
                    $pesanError = "Level Staf/Pelaksana tidak diizinkan meminjam Arsip TERBATAS.";
                }
            } elseif ($levelArsip == 'Rahasia') {
                if (in_array($jabatan, ['Direksi', 'Auditor', 'Legal'])) {
                    $isAllowed = true;
                } else {
                    $pesanError = "Arsip RAHASIA hanya boleh diakses oleh Direksi, Legal, atau Auditor.";
                }
            }

            if (!$isAllowed) {
                return back()->withErrors(['msg' => "AKSES DITOLAK! $pesanError"])->withInput();
            }
        }

        foreach ($request->arsip_id as $idArsip) {
            $sedangDipinjam = Peminjaman::where('arsip_id', $idArsip)->where('status', 'Sedang Dipinjam')->exists();
            if ($sedangDipinjam) {
                return back()->withErrors(['msg' => 'Gagal! Salah satu arsip yang dipilih sedang dipinjam orang lain.']);
            }
        }

        $pathBukti = null;
        if ($request->hasFile('bukti_pinjam')) {
            $file = $request->file('bukti_pinjam');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('bukti_pinjam'), $namaFile); 
            $pathBukti = 'bukti_pinjam/' . $namaFile;
        }

        foreach ($request->arsip_id as $idArsip) {
            Peminjaman::create([
                'tanggal_pinjam' => $request->tanggal,
                'nama_peminjam' => $request->nama_peminjam,
                'nip' => $request->nip,
                'unit_peminjam' => $request->unit,
                'jenis_dokumen' => $jenisDokumenFinal,
                'bukti_peminjaman' => $pathBukti,
                'arsip_id' => $idArsip,
                'status' => 'Sedang Dipinjam',
                'jabatan_peminjam' => $request->jabatan_peminjam,
                'is_approved_khusus' => false
            ]);
        }

        return redirect('/peminjaman')->with('success', 'Data peminjaman berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $pinjam = Peminjaman::findOrFail($id);

        $request->validate([
            'tanggal' => 'required|date',
            'nama_peminjam' => 'required',
            'nip' => 'required|numeric',
            'unit' => 'required',
            'jenis_dokumen_utama' => 'required',
            'bukti_pinjam' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', 
        ]);

        $jenisDokumenFinal = $request->jenis_dokumen_utama;
        if ($request->jenis_dokumen_utama == 'Hardfile' && $request->has('detail_fisik')) {
            $jenisDokumenFinal .= ' - ' . $request->detail_fisik; 
        }

        $dataUpdate = [
            'tanggal_pinjam' => $request->tanggal,
            'nama_peminjam' => $request->nama_peminjam,
            'nip' => $request->nip,
            'unit_peminjam' => $request->unit,
            'jenis_dokumen' => $jenisDokumenFinal,
            'jabatan_peminjam' => $request->jabatan_peminjam,
        ];

        if ($request->hasFile('bukti_pinjam')) {
            if ($pinjam->bukti_peminjaman && File::exists(public_path($pinjam->bukti_peminjaman))) {
                File::delete(public_path($pinjam->bukti_peminjaman));
            }
            $file = $request->file('bukti_pinjam');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('bukti_pinjam'), $namaFile);
            $dataUpdate['bukti_peminjaman'] = 'bukti_pinjam/' . $namaFile;
        }

        if ($request->has('arsip_id') && !empty($request->arsip_id)) {
            $newArsipId = is_array($request->arsip_id) ? $request->arsip_id[0] : $request->arsip_id;
            $sedangDipinjam = Peminjaman::where('arsip_id', $newArsipId)
                                        ->where('status', 'Sedang Dipinjam')
                                        ->where('id', '!=', $id) 
                                        ->exists();
            if($sedangDipinjam) {
                 return back()->withErrors(['msg' => 'Gagal update! Arsip pengganti sedang dipinjam orang lain.']);
            }
            $dataUpdate['arsip_id'] = $newArsipId;
        }

        $pinjam->update($dataUpdate);
        return redirect('/peminjaman')->with('success', 'Data peminjaman berhasil diperbarui!');
    }

    public function complete($id)
    {
        $pinjam = Peminjaman::findOrFail($id);
        $pinjam->update(['status' => 'Sudah Dikembalikan']);
        return redirect('/peminjaman')->with('success', 'Arsip telah dikembalikan.');
    }

    public function edit($id)
    {
        $editData = Peminjaman::with('arsip')->findOrFail($id);
        $idDipinjamOrangLain = Peminjaman::where('status', 'Sedang Dipinjam')
                                         ->where('id', '!=', $id) 
                                         ->pluck('arsip_id')->toArray();
        $daftarArsip = Arsip::whereNotIn('id', $idDipinjamOrangLain)
                            ->select('id', 'nama_berkas', 'no_berkas')
                            ->get();
        return view('peminjaman.edit', compact('editData', 'id', 'daftarArsip'));
    }

    public function destroy($id)
    {
        $pinjam = Peminjaman::findOrFail($id);
        if ($pinjam->bukti_peminjaman && File::exists(public_path($pinjam->bukti_peminjaman))) {
            File::delete(public_path($pinjam->bukti_peminjaman));
        }
        $pinjam->delete();
        return redirect('/peminjaman')->with('success', 'Data berhasil dihapus.');
    }

    public function export(Request $request)
    {
        $namaFile = 'Laporan_Peminjaman_' . date('d-m-Y_H-i') . '.xlsx';
        return Excel::download(new PeminjamanExport($request->all()), $namaFile);
    }
}