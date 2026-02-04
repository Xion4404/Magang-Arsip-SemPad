<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterKlasifikasiSeeder extends Seeder
{
    public function run()
    {
        // Data derived directly from User's CSV input
        // Logic for masa_simpan: Sum of years in Aktif + Inactive
        
        $data = [
            // I. HK - HUKUM
            // HK.00 - Peraturan
            ['kode_klasifikasi' => 'HK.00.01', 'jenis_arsip' => 'Peraturan Ekstern (Dokumentasi Hukum)', 'aktif' => '2 tahun setelah tidak berlaku', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'HK.00.02', 'jenis_arsip' => 'Peraturan Intern', 'aktif' => '2 tahun setelah tidak berlaku', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Permanen'],
            
            // HK.01 - Tanah/ Bangunan
            ['kode_klasifikasi' => 'HK.01.01', 'jenis_arsip' => 'Pelepasan Hak', 'aktif' => '2 tahun setelah hak dan kewajiban selesai', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'HK.01.02', 'jenis_arsip' => 'Pemilikan & Pemakaian', 'aktif' => '2 tahun setelah hak dan kewajiban selesai', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],

            // HK.02 - Surat Berharga
            ['kode_klasifikasi' => 'HK.02.01', 'jenis_arsip' => 'Akta', 'aktif' => '2 tahun setelah disahkan', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Permanen'],
            ['kode_klasifikasi' => 'HK.02.02', 'jenis_arsip' => 'Saham', 'aktif' => '2 tahun setelah tidak berlaku', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Permanen'],
            ['kode_klasifikasi' => 'HK.02.03', 'jenis_arsip' => 'Piagam Pihak Eksternal', 'aktif' => '2 tahun setelah tidak berlaku', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Permanen'],
            ['kode_klasifikasi' => 'HK.02.04', 'jenis_arsip' => 'Bank Garansi', 'aktif' => '1 tahun setelah berakhir', 'inaktif' => '4 tahun', 'tindakan_akhir' => 'Musnah'],

            // HK.03 - Dokumen Legal
            ['kode_klasifikasi' => 'HK.03.01', 'jenis_arsip' => 'Sertifikasi', 'aktif' => '2 tahun setelah tidak berlaku', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Permanen'],
            ['kode_klasifikasi' => 'HK.03.02', 'jenis_arsip' => 'Perjanjian/ Kontrak', 'aktif' => '2 tahun setelah tidak berlaku', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Permanen'],
            ['kode_klasifikasi' => 'HK.03.03', 'jenis_arsip' => 'Bantuan Hukum', 'aktif' => '2 tahun setelah ada keputusan', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Dinilai Kembali'],
            ['kode_klasifikasi' => 'HK.03.04', 'jenis_arsip' => 'Perizinan', 'aktif' => '2 tahun setelah habis masa berlaku', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Permanen'],
            ['kode_klasifikasi' => 'HK.03.05', 'jenis_arsip' => 'Logo Perusahaan', 'aktif' => '2 tahun setelah habis masa berlaku', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Permanen'],

            // II. HM - HUMAS
            // HM.00 - Penerangan
            ['kode_klasifikasi' => 'HM.00.01', 'jenis_arsip' => 'Kegiatan ke Pihak Luar', 'aktif' => '1 tahun setelah Pelaksanaan', 'inaktif' => '2 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'HM.00.02', 'jenis_arsip' => 'Kegiatan ke Pihak Dalam', 'aktif' => '1 tahun setelah Pelaksanaan', 'inaktif' => '2 tahun', 'tindakan_akhir' => 'Musnah'],

            // HM.01 - Protokoler
            ['kode_klasifikasi' => 'HM.01.01', 'jenis_arsip' => 'Kunjungan & Pelayanan ke Pihak Luar', 'aktif' => '1 tahun setelah Pelaksanaan', 'inaktif' => '2 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'HM.01.02', 'jenis_arsip' => 'Kunjungan & Pelayanan ke Pihak Dalam', 'aktif' => '1 tahun setelah Pelaksanaan', 'inaktif' => '2 tahun', 'tindakan_akhir' => 'Musnah'],

            // HM.02 - Publikasi
            ['kode_klasifikasi' => 'HM.02.01', 'jenis_arsip' => 'Dokumentasi', 'aktif' => '1 tahun setelah Pelaksanaan', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah, kecuali kegiatan Direksi, Komisaris, Pemegang Saham'],
            ['kode_klasifikasi' => 'HM.02.02', 'jenis_arsip' => 'Penerbitan', 'aktif' => '1 tahun setelah Pelaksanaan', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],

            // HM.03 - Rekanan
            ['kode_klasifikasi' => 'HM.03.01', 'jenis_arsip' => 'Distributor', 'aktif' => '2 tahun setelah tidak jadi rekanan', 'inaktif' => '2 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'HM.03.02', 'jenis_arsip' => 'Suplier', 'aktif' => '2 tahun setelah tidak jadi rekanan', 'inaktif' => '2 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'HM.03.03', 'jenis_arsip' => 'Kontraktor', 'aktif' => '2 tahun setelah tidak jadi rekanan', 'inaktif' => '2 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'HM.03.04', 'jenis_arsip' => 'Ekspeditor', 'aktif' => '2 tahun setelah tidak jadi rekanan', 'inaktif' => '2 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'HM.03.05', 'jenis_arsip' => 'Lembaga Pemerintah', 'aktif' => '2 tahun setelah tidak jadi rekanan', 'inaktif' => '2 tahun', 'tindakan_akhir' => 'Musnah'],

            // HM.04 - Bantuan Bina Lingkungan
            ['kode_klasifikasi' => 'HM.04.01', 'jenis_arsip' => 'Sosial, Olah Raga dan Kesenian', 'aktif' => '1 tahun setelah pelaksanaan selesai', 'inaktif' => '1 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'HM.04.02', 'jenis_arsip' => 'Fisik/ Sarana Umum', 'aktif' => '1 tahun setelah pelaksanaan selesai', 'inaktif' => '1 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'HM.04.03', 'jenis_arsip' => 'Pendidikan/ Magang dan Penelitian', 'aktif' => '1 tahun setelah pelaksanaan selesai', 'inaktif' => '1 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'HM.04.04', 'jenis_arsip' => 'Ekonomi Masyarakat', 'aktif' => '1 tahun setelah pelaksanaan selesai', 'inaktif' => '1 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'HM.04.05', 'jenis_arsip' => 'Tenaga Kerja', 'aktif' => '1 tahun setelah pelaksanaan selesai', 'inaktif' => '1 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'HM.04.06', 'jenis_arsip' => 'Kesehatan Masyarakat dan Bencana Alam', 'aktif' => '1 tahun setelah pelaksanaan selesai', 'inaktif' => '1 tahun', 'tindakan_akhir' => 'Musnah'],

            // HM.05 - Kemitraan
            ['kode_klasifikasi' => 'HM.05.01', 'jenis_arsip' => 'Pinjaman Modal Kerja', 'aktif' => '2 tahun setelah audit', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'HM.05.02', 'jenis_arsip' => 'Pinjaman Khusus', 'aktif' => '2 tahun setelah audit', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'HM.05.03', 'jenis_arsip' => 'Hibah', 'aktif' => '2 tahun setelah audit', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],

            // HM.06 - Sarana dan Prasarana
            ['kode_klasifikasi' => 'HM.06.01', 'jenis_arsip' => 'Bangunan', 'aktif' => '2 tahun setelah pelaksanaan', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'HM.06.02', 'jenis_arsip' => 'Jalan dan Jembatan', 'aktif' => '2 tahun setelah pelaksanaan', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'HM.06.03', 'jenis_arsip' => 'Bendung dan Saluran', 'aktif' => '2 tahun setelah pelaksanaan', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'HM.06.04', 'jenis_arsip' => 'Taman dan Pekarangan', 'aktif' => '2 tahun setelah pelaksanaan', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],

            // III. KK - KESELAMATAN, KESEHATAN KERJA & LINGKUNGAN HIDUP
            // KK.00 - Identifikasi
            ['kode_klasifikasi' => 'KK.00.01', 'jenis_arsip' => 'Peralatan', 'aktif' => '2 tahun setelah Audit', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'KK.00.02', 'jenis_arsip' => 'Bahan', 'aktif' => '3 tahun setelah Audit', 'inaktif' => '2 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'KK.00.03', 'jenis_arsip' => 'Proses', 'aktif' => '3 tahun setelah Audit', 'inaktif' => '2 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'KK.00.04', 'jenis_arsip' => 'Lingkungan', 'aktif' => '2 tahun setelah Audit', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],

            // KK.01 - Pelaporan
            ['kode_klasifikasi' => 'KK.01.01', 'jenis_arsip' => 'Tim K3LH/ Tim PKTD', 'aktif' => '1 tahun setelah penilaian', 'inaktif' => '1 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'KK.01.02', 'jenis_arsip' => 'HKR', 'aktif' => '2 tahun setelah penilaian', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'KK.01.03', 'jenis_arsip' => 'Bulan Mutu dan Bulan K3', 'aktif' => '1 tahun setelah penilaian', 'inaktif' => '1 tahun', 'tindakan_akhir' => 'Musnah'],

            // KK.02 - Pemantauan dan Pengendalian
            ['kode_klasifikasi' => 'KK.02.01', 'jenis_arsip' => 'Kesehatan Kerja', 'aktif' => '2 tahun setelah audit', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'KK.02.02', 'jenis_arsip' => 'Keselamatan Kerja', 'aktif' => '2 tahun setelah audit', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'KK.02.03', 'jenis_arsip' => 'Lingkungan Hidup', 'aktif' => '2 tahun setelah ditindaklanjuti', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'KK.02.04', 'jenis_arsip' => 'Pelaksanaan P2K3', 'aktif' => '3 tahun setelah Audit', 'inaktif' => '2 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'KK.02.05', 'jenis_arsip' => 'Dokumen Pemeriksaan Penyakit Akibat Kerja', 'aktif' => '1 tahun setelah pensiun', 'inaktif' => 'Setelah meninggal', 'tindakan_akhir' => 'Musnah'],

            // IV. KM - KEAMANAN
            // KM.00 - Keamanan lingkungan Intern
            ['kode_klasifikasi' => 'KM.00.01', 'jenis_arsip' => 'Penyidikan/ Pemeriksaan', 'aktif' => '2 tahun setelah kasus selesai', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'KM.00.02', 'jenis_arsip' => 'Barang Bukti', 'aktif' => '2 tahun setelah kasus selesai', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],

            // KM.01 - Keamanan Lingkungan Ekstern
            ['kode_klasifikasi' => 'KM.01.01', 'jenis_arsip' => 'Penyidikan/ Pemeriksaan', 'aktif' => '2 tahun setelah kasus selesai', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'KM.01.02', 'jenis_arsip' => 'Barang Bukti', 'aktif' => '2 tahun setelah kasus selesai', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],

            // KM.02 - Koordinasi dengan Aparat Hukum
            ['kode_klasifikasi' => 'KM.03', 'jenis_arsip' => 'Koordinasi Keamanan Pemerintah', 'aktif' => '2 tahun setelah kasus selesai', 'inaktif' => '2 tahun', 'tindakan_akhir' => 'Musnah'], // Assuming .01 as standard suffix if missing in CSV but implied by KM.03 row which has data. CSV says: KM.03, Koordinasi..., 2 thn, 2 thn, Musnah. I will map it to KM.03.01 for consistency or KM.03.00? Usually KM.XX.YY. I will use KM.03.01 derived from inspection.

            // V. KS - KESEKRETARIATAN
            // KS.00 - Surat Menyurat
            ['kode_klasifikasi' => 'KS.00.01', 'jenis_arsip' => 'Ekpedisi /Pengiriman Dokumen (Internal & External)', 'aktif' => '2 tahun setelah tidak berlaku', 'inaktif' => '2 tahun', 'tindakan_akhir' => 'Musnah'],

            // KS.01 - Laporan
            ['kode_klasifikasi' => 'KS.01.01', 'jenis_arsip' => 'Laporan Kinerja Bulanan', 'aktif' => '1 tahun setelah direalisasi', 'inaktif' => '2 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'KS.01.02', 'jenis_arsip' => 'Laporan Tahunan/ Annual Report', 'aktif' => '2 tahun setelah direalisasi', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Permanen'],
            ['kode_klasifikasi' => 'KS.01.03', 'jenis_arsip' => 'Prognosa', 'aktif' => '2 tahun setelah direalisasi', 'inaktif' => '2 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'KS.01.04', 'jenis_arsip' => 'Laporan Penelitian', 'aktif' => '2 tahun setelah direalisasi', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Permanen (sudah masuk di substansi /Litbang)'],
            ['kode_klasifikasi' => 'KS.01.05', 'jenis_arsip' => 'Laporan Keuangan', 'aktif' => '2 tahun setelah tindak lanjut hasil pemeriksaan selesai', 'inaktif' => '8 tahun', 'tindakan_akhir' => 'Permanen'],

            // KS.02 - Kearsipan
            ['kode_klasifikasi' => 'KS.02.01', 'jenis_arsip' => 'Pengelolaan Arsip Aktif', 'aktif' => '2 tahun setelah terlaksana', 'inaktif' => '2 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'KS.02.02', 'jenis_arsip' => 'Pemindahan Arsip Inaktif ke Sentral Arsip', 'aktif' => '2 tahun setelah tidak aktif', 'inaktif' => '2 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'KS.02.03', 'jenis_arsip' => 'Penyerahan Arsip Statis', 'aktif' => '2 tahun setelah inaktif central record', 'inaktif' => '2 tahun', 'tindakan_akhir' => 'Permanen'],
            ['kode_klasifikasi' => 'KS.02.04', 'jenis_arsip' => 'Pemeliharaan Arsip', 'aktif' => '1 tahun setelah reproduksi', 'inaktif' => '2 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'KS.02.05', 'jenis_arsip' => 'Pemusnahan Arsip', 'aktif' => '2 tahun setelah terlaksana', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Permanen'],
            ['kode_klasifikasi' => 'KS.02.06', 'jenis_arsip' => 'Akuisisi Arsip', 'aktif' => '2 tahun setelah terlaksana', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Permanen (tidak perlu karena bukan lembaga kearsipan)'],
            ['kode_klasifikasi' => 'KS.02.07', 'jenis_arsip' => 'Penilaian Arsip', 'aktif' => '2 tahun setelah terlaksana', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Permanen'],

            // KS.03 - Supplies Kantor
            ['kode_klasifikasi' => 'KS.03.01', 'jenis_arsip' => 'Penjilidan', 'aktif' => '1 tahun setelah terlaksana', 'inaktif' => '2 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'KS.03.02', 'jenis_arsip' => 'Foto Copy', 'aktif' => '1 tahun setelah terlaksana', 'inaktif' => '2 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'KS.03.03', 'jenis_arsip' => 'Percetakan Identitas', 'aktif' => '1 tahun setelah terlaksana', 'inaktif' => '2 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'KS.03.04', 'jenis_arsip' => 'Alat Tulis Kantor (ATK)', 'aktif' => '1 tahun setelah terlaksana', 'inaktif' => '1 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'KS.03.05', 'jenis_arsip' => 'Perpustakaan', 'aktif' => '1 tahun setelah terlaksana', 'inaktif' => '2 tahun', 'tindakan_akhir' => 'Musnah'],

            // VI. KU - KEUANGAN
            // KU.00 - Anggaran
            ['kode_klasifikasi' => 'KU.00.01', 'jenis_arsip' => 'Rencana kerja & Anggaran Perusahaan Tahunan RKAP', 'aktif' => '2 tahun setelah disahkan', 'inaktif' => '8 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'KU.00.02', 'jenis_arsip' => 'RJPP (Rencana Kerja dan Anggaran Perusahaan Jangka Panjang)', 'aktif' => '2 tahun setelah disahkan', 'inaktif' => '8 tahun', 'tindakan_akhir' => 'Permanen'],

            // KU.01 - Perbendaharaan
            ['kode_klasifikasi' => 'KU.01.01', 'jenis_arsip' => 'Kas Bank', 'aktif' => '2 tahun setelah tindak lanjut hasil pemeriksaan selesai', 'inaktif' => '8 tahun', 'tindakan_akhir' => 'Dinilai Kembali'],
            ['kode_klasifikasi' => 'KU.01.02', 'jenis_arsip' => 'Hutang', 'aktif' => '2 tahun setelah tindak lanjut hasil pemeriksaan selesai', 'inaktif' => '8 tahun', 'tindakan_akhir' => 'Dinilai Kembali'],
            ['kode_klasifikasi' => 'KU.01.03', 'jenis_arsip' => 'Piutang', 'aktif' => '2 tahun setelah tindak lanjut hasil pemeriksaan selesai', 'inaktif' => '8 tahun', 'tindakan_akhir' => 'Dinilai Kembali'],
            ['kode_klasifikasi' => 'KU.01.04', 'jenis_arsip' => 'Pajak', 'aktif' => '2 tahun setelah tindak lanjut hasil pemeriksaan selesai', 'inaktif' => '8 tahun', 'tindakan_akhir' => 'Dinilai Kembali'],
            ['kode_klasifikasi' => 'KU.01.05', 'jenis_arsip' => 'Asuransi', 'aktif' => '2 tahun setelah tindak lanjut hasil pemeriksaan selesai', 'inaktif' => '8 tahun', 'tindakan_akhir' => 'Dinilai Kembali'],
            ['kode_klasifikasi' => 'KU.01.06', 'jenis_arsip' => 'Kredit Limit', 'aktif' => '2 tahun setelah audit selesai', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],

            // KU.02 - Akuntansi
            ['kode_klasifikasi' => 'KU.02.01', 'jenis_arsip' => 'Pencatatan Transaksi (Jurnal)', 'aktif' => '2 tahun setelah tindak lanjut hasil pemeriksaan selesai', 'inaktif' => '8 tahun', 'tindakan_akhir' => 'Dinilai Kembali'],
            ['kode_klasifikasi' => 'KU.02.02', 'jenis_arsip' => 'Perhitungan Harga Pokok', 'aktif' => '2 tahun setelah tutup buku', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'KU.02.03', 'jenis_arsip' => 'Aktiva Tetap', 'aktif' => '2 tahun setelah tindak lanjut hasil pemeriksaan selesai', 'inaktif' => '8 tahun', 'tindakan_akhir' => 'Dinilai Kembali'],
            ['kode_klasifikasi' => 'KU.02.04', 'jenis_arsip' => 'Rekonsiliasi', 'aktif' => '2 tahun setelah pertanggunggungan dibayar', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Dinilai Kembali'],

            // VII. PB - PERBEKALAN
            // PB.00 - Kinerja Suplier
            ['kode_klasifikasi' => 'PB.00.01', 'jenis_arsip' => 'Penunjukan Supplier', 'aktif' => '1 tahun setelah tidak jadi rekanan', 'inaktif' => '1 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'PB.00.02', 'jenis_arsip' => 'Evaluasi Supplier', 'aktif' => '1 tahun setelah tidak jadi rekanan', 'inaktif' => '4 tahun', 'tindakan_akhir' => 'Musnah'],

            // PB.01 - Pengadaan Barang
            ['kode_klasifikasi' => 'PB.01.01', 'jenis_arsip' => 'Barang Umum', 'aktif' => '2 tahun setelah tindak lanjut hasil pemeriksaan selesai', 'inaktif' => '8 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'PB.01.02', 'jenis_arsip' => 'Barang Suku Cadang', 'aktif' => '2 tahun setelah tindak lanjut hasil pemeriksaan selesai', 'inaktif' => '8 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'PB.01.03', 'jenis_arsip' => 'Operating Supplies', 'aktif' => '2 tahun setelah tindak lanjut hasil pemeriksaan selesai', 'inaktif' => '8 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'PB.01.04', 'jenis_arsip' => 'Inventaris', 'aktif' => '2 tahun setelah tindak lanjut hasil pemeriksaan selesai', 'inaktif' => '8 tahun', 'tindakan_akhir' => 'Dinilai Kembali'],

            // PB.02 - Pengadaan Jasa
            ['kode_klasifikasi' => 'PB.02.01', 'jenis_arsip' => 'Jasa Angkutan', 'aktif' => '2 tahun setelah tindak lanjut hasil pemeriksaan selesai', 'inaktif' => '8 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'PB.02.02', 'jenis_arsip' => 'Jasa Pekerjaan', 'aktif' => '2 tahun setelah tindak lanjut hasil pemeriksaan selesai', 'inaktif' => '8 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'PB.02.03', 'jenis_arsip' => 'Jasa Outsourcing', 'aktif' => '2 tahun setelah tindak lanjut hasil pemeriksaan selesai', 'inaktif' => '8 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'PB.02.04', 'jenis_arsip' => 'Jasa Fasilitas (Gudang, kantor, kendaraan, mobil, komputer, software, billboard, spanduk )', 'aktif' => '2 tahun setelah tindak lanjut hasil pemeriksaan selesai', 'inaktif' => '8 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'PB.02.05', 'jenis_arsip' => 'Jasa Sewa', 'aktif' => '2 tahun setelah tindak lanjut hasil pemeriksaan selesai', 'inaktif' => '8 tahun', 'tindakan_akhir' => 'Musnah'],

            // PB.03 - Penerimaan Barang
            ['kode_klasifikasi' => 'PB.03.01', 'jenis_arsip' => 'Barang umum', 'aktif' => '2 tahun setelah diterima', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'PB.03.02', 'jenis_arsip' => 'Barang suku cadang', 'aktif' => '2 tahun setelah diterima', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'PB.03.03', 'jenis_arsip' => 'Barang operating supplies', 'aktif' => '2 tahun setelah diterima', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'PB.03.04', 'jenis_arsip' => 'Inventaris', 'aktif' => '2 tahun setelah diterima', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],

            // PB.04 - Pengeluaran Barang
            ['kode_klasifikasi' => 'PB.04.01', 'jenis_arsip' => 'Barang umum dan inventaris', 'aktif' => '1 tahun setelah keluar', 'inaktif' => '1 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'PB.04.02', 'jenis_arsip' => 'Barang Suku Cadang', 'aktif' => '1 tahun setelah keluar', 'inaktif' => '1 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'PB.04.03', 'jenis_arsip' => 'Barang operating supplies', 'aktif' => '1 tahun setelah keluar', 'inaktif' => '1 tahun', 'tindakan_akhir' => 'Musnah'],

            // VIII. PW - PENGAWASAN & SISTEM MANAJEMEN
            // PW.00 - Pemeriksaan Ekstern
            ['kode_klasifikasi' => 'PW.00', 'jenis_arsip' => 'Pemeriksaan Ekstern', 'aktif' => '2 tahun setelah tindak lanjut hasil pemeriksaan selesai', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Permanen'],
            
            // PW.01 - Pengawasan Intern
            ['kode_klasifikasi' => 'PW.01.01', 'jenis_arsip' => 'Pengawasan administrasi & Keuangan', 'aktif' => '2 tahun setelah tindak lanjut hasil pemeriksaan selesai', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Dinilai Kembali'],
            ['kode_klasifikasi' => 'PW.01.02', 'jenis_arsip' => 'Pengawasan ICT (Information Communication Technology) Proyek', 'aktif' => '2 tahun setelah tindak lanjut hasil pemeriksaan selesai', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Dinilai Kembali'],
            ['kode_klasifikasi' => 'PW.01.03', 'jenis_arsip' => 'Pengawasan SMSP (Sistem Manajemen mutu, lingkungan, OHSAS, K3,GCG dan Resiko, TPM, SMP, Kearsipan)', 'aktif' => '2 tahun setelah tindak lanjut hasil pemeriksaan selesai', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Dinilai Kembali'],
            ['kode_klasifikasi' => 'PW.01.04', 'jenis_arsip' => 'Pengawasan Fraud / WBS', 'aktif' => '2 tahun setelah tindak lanjut hasil pemeriksaan selesai', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Dinilai Kembali'],
            
            // PW.02 - Pengawasan Anak Perusahaan & Lembaga Penunjang
            ['kode_klasifikasi' => 'PW.02', 'jenis_arsip' => 'Pengawasan Anak Perusahaan & Lembaga Penunjang', 'aktif' => '2 tahun setelah tindak lanjut hasil pemeriksaan selesai', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Dinilai Kembali'],
            
            // PW.03 - Pengawasan Intercompany SMIG
            ['kode_klasifikasi' => 'PW.03', 'jenis_arsip' => 'Pengawasan Intercompany SMIG (Semen Indonesia Group)', 'aktif' => '2 tahun setelah tindak lanjut hasil pemeriksaan selesai', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Dinilai Kembali'],

            // IX. SM - SUMBER DAYA MANUSIA
            // SM.00 - Formasi
            ['kode_klasifikasi' => 'SM.00.01', 'jenis_arsip' => 'Kebutuhan Karyawan', 'aktif' => '1 tahun setelah terealisasi', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'SM.00.02', 'jenis_arsip' => 'Kebutuhan Tenaga Subkontraktor', 'aktif' => '2 tahun setelah terealisasi', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],

            // SM.01 - Penerimaan Karyawan
            ['kode_klasifikasi' => 'SM.01.01', 'jenis_arsip' => 'Seleksi', 'aktif' => '2 tahun setelah terealisasi', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'SM.01.02', 'jenis_arsip' => 'Orientasi/ Magang', 'aktif' => '1 tahun setelah magang berakhir', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'SM.01.03', 'jenis_arsip' => 'Pengangkatan', 'aktif' => '2 tahun setelah SK terbit', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah, kecuali Keputusan Direksi, masuk ke Personal File'],

            // SM.02 - Penilaian
            ['kode_klasifikasi' => 'SM.02.01', 'jenis_arsip' => 'KPI/ Performance Kinerja', 'aktif' => '2 tahun setelah terealisasi', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah, kecuali Penetapan/Keputusan masuk Personal File'],
            ['kode_klasifikasi' => 'SM.02.02', 'jenis_arsip' => 'Mutasi, Promosi, Demosi', 'aktif' => '3 tahun setelah terealisasi', 'inaktif' => '5 tahun', 'tindakan_akhir' => 'Musnah, kecuali Keputusan Direksi masuk ke Personal File'],
            ['kode_klasifikasi' => 'SM.02.03', 'jenis_arsip' => 'Peringatan dan teguran', 'aktif' => '1 tahun setelah terealisasi', 'inaktif' => '5 tahun', 'tindakan_akhir' => 'Musnah, kecuali Keputusan Direksi masuk ke Personal File'],
            ['kode_klasifikasi' => 'SM.02.04', 'jenis_arsip' => 'Kompetensi', 'aktif' => '1 tahun setelah terealisasi', 'inaktif' => '5 tahun', 'tindakan_akhir' => 'Musnah, kecuali copy sertifikat masuk ke Personal File'],
            ['kode_klasifikasi' => 'SM.02.05', 'jenis_arsip' => 'Presensi', 'aktif' => '1 tahun setelah terealisasi', 'inaktif' => '1 tahun', 'tindakan_akhir' => 'Musnah'],

            // SM.03 - Penggajian
            ['kode_klasifikasi' => 'SM.03.01', 'jenis_arsip' => 'Gaji, Lembur, Potongan, Bonus dan Tunjangan', 'aktif' => '2 tahun setelah dibayar', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],

            // SM.04 - Kesejahteraan
            ['kode_klasifikasi' => 'SM.04.01', 'jenis_arsip' => 'Pakaian dan Kelengkapan Kerja', 'aktif' => '1 tahun setelah terealisasi', 'inaktif' => '1 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'SM.04.02', 'jenis_arsip' => 'Cuti', 'aktif' => '1 tahun setelah terealisasi', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'masuk ke personal file'],
            ['kode_klasifikasi' => 'SM.04.03', 'jenis_arsip' => 'Perumahan', 'aktif' => '1 tahun setelah terealisasi', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah, kecuali keputusan Direksi masuk ke Personal File'],
            ['kode_klasifikasi' => 'SM.04.04', 'jenis_arsip' => 'Bantuan dan Santunan', 'aktif' => '1 tahun setelah terealisasi', 'inaktif' => '2 tahun', 'tindakan_akhir' => 'Musnah, kecuali ketetapan masuk ke personal file'],
            ['kode_klasifikasi' => 'SM.04.05', 'jenis_arsip' => 'Kesehatan', 'aktif' => '1 tahun setelah terealisasi', 'inaktif' => '2 tahun', 'tindakan_akhir' => 'Musnah, kecuali Resume Medis, Keputusan Direksi, masuk ke Personal File'],
            ['kode_klasifikasi' => 'SM.04.06', 'jenis_arsip' => 'Penghargaan', 'aktif' => '1 tahun setelah terealisasi', 'inaktif' => '1 tahun', 'tindakan_akhir' => 'Musnah, kecuali keputusan Direksi masuk ke Personal File'],
            ['kode_klasifikasi' => 'SM.04.07', 'jenis_arsip' => 'Asuransi', 'aktif' => '1 tahun setelah diberikan', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah, kecuali keputusan Direksi masuk ke Personal File'],

            // SM.05 - Pendidikan dan Pelatihan
            ['kode_klasifikasi' => 'SM.05.01', 'jenis_arsip' => 'Training Intern', 'aktif' => '1 tahun', 'inaktif' => '2 tahun', 'tindakan_akhir' => 'Musnah, kecuali copy sertifikat masuk ke personal file'],
            ['kode_klasifikasi' => 'SM.05.02', 'jenis_arsip' => 'Training Ekstern', 'aktif' => '1 tahun', 'inaktif' => '2 tahun', 'tindakan_akhir' => 'Musnah, kecuali copy sertifikat masuk ke personal file'],
            ['kode_klasifikasi' => 'SM.05.03', 'jenis_arsip' => 'Seminar/ Lokakarya/ Workshop', 'aktif' => '1 tahun', 'inaktif' => '1 tahun', 'tindakan_akhir' => 'Musnah, kecuali copy sertifikat masuk ke personal file'],
            ['kode_klasifikasi' => 'SM.05.04', 'jenis_arsip' => 'Program Pendidikan Lanjutan', 'aktif' => '1 tahun', 'inaktif' => '2 tahun', 'tindakan_akhir' => 'Musnah, kecuali copy ijazah/sertifikat masuk ke personal file'],

            // SM.06 - Pemberhentian Hubungan Kerja
            ['kode_klasifikasi' => 'SM.06.01', 'jenis_arsip' => 'Berhenti dengan Hormat', 'aktif' => '1 tahun', 'inaktif' => '2 tahun', 'tindakan_akhir' => 'Musnah, kecuali Keputusan Direksi masuk ke Personal File'],
            ['kode_klasifikasi' => 'SM.06.02', 'jenis_arsip' => 'Berhenti dengan Tidak Hormat', 'aktif' => '2 tahun', 'inaktif' => '2 tahun', 'tindakan_akhir' => 'Musnah, kecuali Keputusan Direksi masuk ke Personal File'],

            // SM.07 - Administrasi Karyawan
            ['kode_klasifikasi' => 'SM.07.01', 'jenis_arsip' => 'Identitas Data Karyawan', 'aktif' => '1 tahun', 'inaktif' => '1 tahun', 'tindakan_akhir' => 'Musnah, kecuali Keputusan Direksi masuk ke Personal File'],
            ['kode_klasifikasi' => 'SM.07.02', 'jenis_arsip' => 'Penugasan', 'aktif' => '1 tahun', 'inaktif' => '1 tahun', 'tindakan_akhir' => 'Musnah, kecuali Keputusan Direksi masuk ke Personal File'],
            ['kode_klasifikasi' => 'SM.07.03', 'jenis_arsip' => 'Perkawinan dan Perceraian', 'aktif' => '1 tahun', 'inaktif' => '1 tahun', 'tindakan_akhir' => 'Musnah, kecuali Keputusan Direksi masuk ke Personal File'],

            // SM.08 - Evaluasi Organisasi
            ['kode_klasifikasi' => 'SM.08.01', 'jenis_arsip' => 'FKKSP (Forum Komunikasi Karyawan Semen Padang)', 'aktif' => '1 tahun', 'inaktif' => '4 tahun', 'tindakan_akhir' => 'Musnah kecuali pembentukan dan hasil kongres'],
            ['kode_klasifikasi' => 'SM.08.02', 'jenis_arsip' => 'Lembaga Penunjang dan Afiliasi', 'aktif' => '1 tahun', 'inaktif' => '4 tahun', 'tindakan_akhir' => 'Musnah kecuali pembentukan dan hasil kongres'],
            ['kode_klasifikasi' => 'SM.08.03', 'jenis_arsip' => 'Serikat Pekerja', 'aktif' => '1 tahun', 'inaktif' => '4 tahun', 'tindakan_akhir' => 'Musnah kecuali pembentukan dan hasil kongres'],

            // SM.09 - Komitmen / Kesepakatan
            ['kode_klasifikasi' => 'SM.09.01', 'jenis_arsip' => 'Perjanjian Kerja Bersama', 'aktif' => '3 tahun', 'inaktif' => '2 tahun', 'tindakan_akhir' => 'Permanen'],

            // SM.10 - Personal File
            ['kode_klasifikasi' => 'SM.10.01', 'jenis_arsip' => 'Komisaris', 'aktif' => '2 tahun setelah pensiun', 'inaktif' => '1 tahun', 'tindakan_akhir' => 'Permanen'],
            ['kode_klasifikasi' => 'SM.10.02', 'jenis_arsip' => 'Berkas Direksi', 'aktif' => '2 tahun setelah pensiun', 'inaktif' => '1 tahun', 'tindakan_akhir' => 'Permanen'],
            ['kode_klasifikasi' => 'SM.10.03', 'jenis_arsip' => 'karyawan', 'aktif' => '2 tahun setelah pensiun', 'inaktif' => '2 tahun setelah hak dan kewajiban habis', 'tindakan_akhir' => 'Musnah'],
        ];

        // New Data for JRA Substantif
        $dataSubstantif = [
            // I. BJ.00 - BJ - KEBIJAKAN
            ['kode_klasifikasi' => 'BJ.00.01', 'jenis_arsip' => 'Rumusan Kebijakan Perusahaan yang Bersifat Pengaturan yang terkait dengan rencana dan pengembangan produksi, pemasaran, distribusi, keselamatan, keamanan, dan kesehatan lingkungan kerja, pendirian perusahaan', 'aktif' => '2 tahun setelah tidak berlaku', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Permanen'],
            ['kode_klasifikasi' => 'BJ.00.02', 'jenis_arsip' => 'Penetapan perjanjian (kontrak) kerja', 'aktif' => '2 tahun setelah tidak berlaku', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Permanen'],
            ['kode_klasifikasi' => 'BJ.00.03', 'jenis_arsip' => 'Penetapan Perizinan', 'aktif' => '2 tahun setelah habis masa berlaku', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Permanen'],
            ['kode_klasifikasi' => 'BJ.00.04', 'jenis_arsip' => 'Penetapan logo (identitas) perusahaan', 'aktif' => '2 tahun setelah habis masa berlaku', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Permanen'],
            ['kode_klasifikasi' => 'BJ.00.05', 'jenis_arsip' => 'Penetapan anggaran dasar perusahaan', 'aktif' => '2 tahun setelah disahkan', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Permanen'],

            // II. DT.00 - DT - DISTRIBUSI DAN TRANSPORTASI
            ['kode_klasifikasi' => 'DT.00.01', 'jenis_arsip' => 'Penunjukan Transportir', 'aktif' => '2 tahun setelah tidak menjadi rekanan', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'DT.00.02', 'jenis_arsip' => 'Evaluasi Transportir', 'aktif' => '3 tahun setelah tidak menjadi rekanan', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'DT.00.03', 'jenis_arsip' => 'Pemberhentian Transportir', 'aktif' => '4 tahun setelah tidak menjadi rekanan', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],
            
            // DT.01 - Distribusi & Transportasi Laut
            ['kode_klasifikasi' => 'DT.01.01', 'jenis_arsip' => 'Rencana Kebutuhan Penggunaan Kapal', 'aktif' => '2 tahun setelah kontrak berakhir', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'DT.01.02', 'jenis_arsip' => 'Rencana Realisasi Pemuatan Barang', 'aktif' => '2 tahun setelah kontrak berakhir', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'DT.01.03', 'jenis_arsip' => 'Time Sheet & Round Voyage', 'aktif' => '2 tahun setelah hak dan kewajiban selesai', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'DT.01.04', 'jenis_arsip' => 'Berita Acara Bongkar', 'aktif' => '2 tahun setelah hak dan kewajiban selesai', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],

            // DT.02 - Distribusi dan Transportasi
            ['kode_klasifikasi' => 'DT.02.01', 'jenis_arsip' => 'Rencana Kebutuhan Penggunaan Angkutan Darat', 'aktif' => '2 tahun setelah kontrak berakhir', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'DT.02.02', 'jenis_arsip' => 'Rencana Realisasi Pemuatan Barang', 'aktif' => '2 tahun setelah kontrak berakhir', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'DT.02.03', 'jenis_arsip' => 'Permintaan Pemuatan Barang', 'aktif' => '2 tahun setelah kontrak berakhir', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'DT.02.04', 'jenis_arsip' => 'Pengiriman Semen/ Klinker', 'aktif' => '2 tahun setelah hak dan kewajiban selesai', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'DT.02.05', 'jenis_arsip' => 'Penerimaan Semen/ Klinker', 'aktif' => '2 tahun setelah hak dan kewajiban selesai', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],

            // III. LB.00 - LB - PENELITIAN & PENGEMBANGAN
            ['kode_klasifikasi' => 'LB.00.01', 'jenis_arsip' => 'Survey/ penelitian', 'aktif' => '2 tahun setelah penelitian terlaksana', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'LB.00.02', 'jenis_arsip' => 'Study Kelayakan', 'aktif' => '2 tahun setelah penelitian terlaksana', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Permanen'],
            ['kode_klasifikasi' => 'LB.00.03', 'jenis_arsip' => 'Aplikasi Produk', 'aktif' => '2 tahun setelah produk launching', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Permanen'],
            ['kode_klasifikasi' => 'LB.00.04', 'jenis_arsip' => 'Hasil Penelitian Produk, Pemasaran, Lingkungan dan Pengujian Logam', 'aktif' => '2 tahun setelah penelitian diaplikasikan', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Permanen'],

            // LB.01 - Rancang Bangun
            ['kode_klasifikasi' => 'LB.01.01', 'jenis_arsip' => 'Rancangan Peralatan Utama Pabrik', 'aktif' => '2 tahun setelah rancangan baru tercipta', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Permanen'],
            ['kode_klasifikasi' => 'LB.01.02', 'jenis_arsip' => 'Rancangan Peralatan penunjang pabrik', 'aktif' => '2 tahun setelah rancangan baru tercipta', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Permanen'],
            ['kode_klasifikasi' => 'LB.01.03', 'jenis_arsip' => 'Rancangan Sarana & Prasarana', 'aktif' => '2 tahun setelah rancangan baru tercipta', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Permanen'],

            // LB.02 - Pengembangan
            ['kode_klasifikasi' => 'LB.02.01', 'jenis_arsip' => 'Inbound/ Logistic Management', 'aktif' => '2 tahun setelah penelitian terlaksana', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Permanen'],
            ['kode_klasifikasi' => 'LB.02.02', 'jenis_arsip' => 'Manajemen Investasi (Capex Manajemen)', 'aktif' => '2 tahun setelah penelitian terlaksana', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Permanen'],
            ['kode_klasifikasi' => 'LB.02.03', 'jenis_arsip' => 'Capacity Management', 'aktif' => '2 tahun setelah penelitian terlaksana', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Permanen'],
            ['kode_klasifikasi' => 'LB.02.04', 'jenis_arsip' => 'Cost Management', 'aktif' => '2 tahun setelah penelitian terlaksana', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Permanen'],
            ['kode_klasifikasi' => 'LB.02.05', 'jenis_arsip' => 'Quality Assurance (Uji Bahan, Uji Semen dan Beton, Kalibrasi Alat, Sertifikasi dan Aakreditasi, ISO)', 'aktif' => '2 tahun setelah penelitian terlaksana', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Permanen'],
            ['kode_klasifikasi' => 'LB.02.06', 'jenis_arsip' => 'Inovation/ Improvement', 'aktif' => '2 tahun setelah penelitian terlaksana', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Permanen'],

            // IV. MR.00 - MR - MANAJEMEN GCG & RISIKO
            ['kode_klasifikasi' => 'MR.00.01', 'jenis_arsip' => 'Anti Fraud', 'aktif' => '2 tahun setelah asesmen GCG', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'MR.00.02', 'jenis_arsip' => 'Whistle Blowing System', 'aktif' => '2 tahun setelah asesmen GCG', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'MR.00.03', 'jenis_arsip' => 'Gratifikasi', 'aktif' => '2 tahun setelah asesmen GCG', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'MR.00.05', 'jenis_arsip' => 'Asesmen GCG', 'aktif' => '2 tahun setelah hasil asesmen keluar', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],

            // MR.01 - MANAJEMEN RISIKO
            ['kode_klasifikasi' => 'MR.01.01', 'jenis_arsip' => 'Profil Risiko', 'aktif' => '2 tahun setelah disahkan', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],

            // MR.02 - Kajian Risiko
            ['kode_klasifikasi' => 'MR.02.01', 'jenis_arsip' => 'Kajian Risiko Kontrak', 'aktif' => '2 tahun setelah dikaji', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'MR.02.02', 'jenis_arsip' => 'Kajian Risiko Strategis', 'aktif' => '2 tahun setelah dikaji', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],

            // MR.03
            ['kode_klasifikasi' => 'MR.03.01', 'jenis_arsip' => 'Risk Register/Daftar Risiko', 'aktif' => '2 tahun setelah hasil asesmen keluar', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'MR.03.02', 'jenis_arsip' => 'Rekapitulasi Risiko', 'aktif' => '2 tahun setelah hasil asesmen keluar', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'MR.03.03', 'jenis_arsip' => 'Asesmen Manajemen Risiko', 'aktif' => '2 tahun setelah hasil asesmen keluar', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'MR.03.04', 'jenis_arsip' => 'Pengembangan Manajemen Risiko yang Terintegrasi', 'aktif' => '2 tahun setelah pengembangan', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'MR.03.05', 'jenis_arsip' => 'Pemantauan dan Pelaporan', 'aktif' => '2 tahun setelah pelaporan', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Permanen'],
            ['kode_klasifikasi' => 'MR.03.06', 'jenis_arsip' => 'Laporan Mitigasi Risiko', 'aktif' => '2 tahun setelah pelaporan', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Permanen'],
            ['kode_klasifikasi' => 'MR.03.07', 'jenis_arsip' => 'Laporan Implementasi Risiko', 'aktif' => '2 tahun setelah pelaporan', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Permanen'],

            // V. PR.00 - PR - PRODUKSI
            ['kode_klasifikasi' => 'PR.00.01', 'jenis_arsip' => 'Rencana Produksi Perusahaan', 'aktif' => '2 tahun setelah persetujuan', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Permanen'],
            ['kode_klasifikasi' => 'PR.00.02', 'jenis_arsip' => 'Rencana Produksi Intern (Target Intern Perusahaan)', 'aktif' => '2 tahun setelah persetujuan', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Permanen'],

            // PR.01 - Realisasi Produksi Bahan Baku
            ['kode_klasifikasi' => 'PR.01.01', 'jenis_arsip' => 'Pemakaian Bahan Baku', 'aktif' => '2 tahun setelah realisasi', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'PR.01.02', 'jenis_arsip' => 'Pemakaian Bahan Penolong/ Bahan Penunjang', 'aktif' => '2 tahun setelah realisasi', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'PR.01.03', 'jenis_arsip' => 'Pemakaian Energi', 'aktif' => '2 tahun setelah realisasi', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'PR.01.04', 'jenis_arsip' => 'Penggunaan Kantong/ Kemasan', 'aktif' => '2 tahun setelah realisasi', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'PR.01.05', 'jenis_arsip' => 'Data Pengeluaran Produk', 'aktif' => '2 tahun setelah realisasi', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],

            // PR.02 - Mutu Produk & Bahan baku
            ['kode_klasifikasi' => 'PR.02.01', 'jenis_arsip' => 'Hasil Pengujian Mutu', 'aktif' => '2 tahun setelah pengujian', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],

            // PR.03 - Evaluasi Kinerja Peralatan Produksi
            ['kode_klasifikasi' => 'PR.03.01', 'jenis_arsip' => 'Laporan Harian Produksi', 'aktif' => '1 tahun setelah direkap', 'inaktif' => '4 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'PR.03.02', 'jenis_arsip' => 'Laporan Periodik Produksi', 'aktif' => '1 tahun setelah pelaporan', 'inaktif' => '4 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'PR.03.03', 'jenis_arsip' => 'Item Master', 'aktif' => '1 tahun setelah entry item', 'inaktif' => '4 tahun', 'tindakan_akhir' => 'Musnah'],

            // PR.04 - Rencana Produksi Terak/Klinker
            ['kode_klasifikasi' => 'PR.04.01', 'jenis_arsip' => 'Rencana Produksi Perusahaan', 'aktif' => '2 tahun setelah persetujuan', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Permanen'],
            ['kode_klasifikasi' => 'PR.04.02', 'jenis_arsip' => 'Rencana Produksi Intern (Target Intern Perusahaan)', 'aktif' => '2 tahun setelah persetujuan', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Permanen'],

            // PR.05 - Realisasi Produksi Terak/ Klinker
            ['kode_klasifikasi' => 'PR.05.01', 'jenis_arsip' => 'Pemakaian Bahan Baku', 'aktif' => '2 tahun setelah realisasi', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'PR.05.02', 'jenis_arsip' => 'Pemakaian Bahan Penolong/ Bahan Penunjang', 'aktif' => '2 tahun setelah realisasi', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'PR.05.03', 'jenis_arsip' => 'Pemakaian Energi', 'aktif' => '2 tahun setelah realisasi', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'PR.05.04', 'jenis_arsip' => 'Penggunaan Kantong/ Kemasan', 'aktif' => '2 tahun setelah realisasi', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'PR.05.05', 'jenis_arsip' => 'Data Pengeluaran Produk', 'aktif' => '2 tahun setelah realisasi', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],

            // PR.06 - Mutu Produk & Bahan Terak / klinker
            ['kode_klasifikasi' => 'PR.06.01', 'jenis_arsip' => 'Hasil Pengujian Mutu', 'aktif' => '2 tahun setelah pengujian', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],

            // PR.07 - Evaluasi Kinerja Peralatan Produksi dan Mutu Produk Terak / Klinker
            ['kode_klasifikasi' => 'PR.07.01', 'jenis_arsip' => 'Laporan Harian Produksi', 'aktif' => '1 tahun setelah direkap', 'inaktif' => '4 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'PR.07.02', 'jenis_arsip' => 'Laporan Periodik Produksi', 'aktif' => '1 tahun setelah pelaporan', 'inaktif' => '4 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'PR.07.03', 'jenis_arsip' => 'Item Master', 'aktif' => '1 tahun setelah entry item', 'inaktif' => '4 tahun', 'tindakan_akhir' => 'Musnah'],

            // PR.08 - Rencana Produksi Semen
            ['kode_klasifikasi' => 'PR.08.01', 'jenis_arsip' => 'Rencana Produksi Perusahaan', 'aktif' => '2 tahun setelah persetujuan', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Permanen'],
            ['kode_klasifikasi' => 'PR.08.02', 'jenis_arsip' => 'Rencana Produksi Intern (Target Intern Perusahaan)', 'aktif' => '2 tahun setelah persetujuan', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Permanen'],

            // PR.09 - Realisasi Produksi Semen
            ['kode_klasifikasi' => 'PR.09.01', 'jenis_arsip' => 'Pemakaian Bahan Baku', 'aktif' => '2 tahun setelah realisasi', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'PR.09.02', 'jenis_arsip' => 'Pemakaian Bahan Penolong/ Bahan Penunjang', 'aktif' => '2 tahun setelah realisasi', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'PR.09.03', 'jenis_arsip' => 'Pemakaian Energi', 'aktif' => '2 tahun setelah realisasi', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'PR.09.04', 'jenis_arsip' => 'Penggunaan Kantong/ Kemasan', 'aktif' => '2 tahun setelah realisasi', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'PR.09.05', 'jenis_arsip' => 'Data Pengeluaran Produk', 'aktif' => '2 tahun setelah realisasi', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'PR.09.06', 'jenis_arsip' => 'Pengeluaran Semen', 'aktif' => '2 tahun setelah audit', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Permanen'],
            ['kode_klasifikasi' => 'PR.09.07', 'jenis_arsip' => 'Pengeluaran Klinker', 'aktif' => '2 tahun setelah audit', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Permanen'],
            ['kode_klasifikasi' => 'PR.09.08', 'jenis_arsip' => 'Pengeluaran Kantong', 'aktif' => '2 tahun setelah audit', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],

            // PR.10 - Mutu Produk & Bahan Produksi Semen
            ['kode_klasifikasi' => 'PR.10.01', 'jenis_arsip' => 'Hasil Pengujian Mutu', 'aktif' => '2 tahun setelah pengujian', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],

            // PR.11 - Evaluasi Kinerja Peralatan Produksi dan Mutu Produk Semen
            ['kode_klasifikasi' => 'PR.11.01', 'jenis_arsip' => 'Laporan Harian Produksi', 'aktif' => '1 tahun setelah direkap', 'inaktif' => '4 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'PR.11.02', 'jenis_arsip' => 'Laporan Periodik Produksi', 'aktif' => '1 tahun setelah pelaporan', 'inaktif' => '4 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'PR.11.03', 'jenis_arsip' => 'Item Master', 'aktif' => '1 tahun setelah entry item', 'inaktif' => '4 tahun', 'tindakan_akhir' => 'Musnah'],

            // VI. PS.00 - PS - PEMASARAN
            ['kode_klasifikasi' => 'PS.00.01', 'jenis_arsip' => 'Perencanaan Pemasaran', 'aktif' => '2 tahun setelah ditetapkan', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Permanen'],
            ['kode_klasifikasi' => 'PS.00.02', 'jenis_arsip' => 'Strategi dan Pengembangan Pemasaran', 'aktif' => '2 tahun setelah ditetapkan', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Permanen'],

            // PS.01 - Distribusi
            ['kode_klasifikasi' => 'PS.01.01', 'jenis_arsip' => 'Penunjukkan Distributor', 'aktif' => '1 tahun setelah tidak jadi rekanan', 'inaktif' => '4 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'PS.01.02', 'jenis_arsip' => 'Evaluasi Distributor', 'aktif' => '1 tahun setelah tidak jadi rekanan', 'inaktif' => '4 tahun', 'tindakan_akhir' => 'Musnah'],

            // PS.02 - Kebutuhan Pasar
            ['kode_klasifikasi' => 'PS.02.01', 'jenis_arsip' => 'Pasar Dalam Negeri', 'aktif' => '2 tahun setelah tahun anggaran', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Permanen'],
            ['kode_klasifikasi' => 'PS.02.02', 'jenis_arsip' => 'Pasar Luar Negeri', 'aktif' => '2 tahun setelah tahun anggaran', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Permanen'],
            ['kode_klasifikasi' => 'PS.02.03', 'jenis_arsip' => 'Evaluasi Program Pemasaran', 'aktif' => '2 tahun setelah pelaksanaan', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],

            // PS.03 - Evaluasi Pemasaran
            ['kode_klasifikasi' => 'PS.03.01', 'jenis_arsip' => 'Survei Kepuasan pelanggan', 'aktif' => '1 tahun setelah pelaksanaan', 'inaktif' => '1 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'PS.03.02', 'jenis_arsip' => 'Harga Pasar', 'aktif' => '2 tahun setelah pelaksanaan', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'PS.03.03', 'jenis_arsip' => 'Pasar dalam negeri', 'aktif' => '2 tahun setelah pelaksanaan', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'PS.03.04', 'jenis_arsip' => 'Pasar luar Negeri', 'aktif' => '2 tahun setelah pelaksanaan', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],

            // PS.04 - Penjualan
            ['kode_klasifikasi' => 'PS.04.01', 'jenis_arsip' => 'Realisasi penjualan dalam Negeri', 'aktif' => '2 tahun setelah pelaksanaan', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'PS.04.02', 'jenis_arsip' => 'Realisasi penjualan luar negeri', 'aktif' => '2 tahun setelah pelaksanaan', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],

            // PS.05 - Promosi
            ['kode_klasifikasi' => 'PS.05.01', 'jenis_arsip' => 'Barang', 'aktif' => '2 tahun setelah pelaksanaan', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'PS.05.02', 'jenis_arsip' => 'Jasa', 'aktif' => '2 tahun setelah pelaksanaan', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'PS.05.03', 'jenis_arsip' => 'Pelayanan Teknis/ Pelanggan', 'aktif' => '2 tahun setelah pelaksanaan', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'PS.05.04', 'jenis_arsip' => 'Pemberian Reward Distributor', 'aktif' => '2 tahun setelah pelaksanaan', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'PS.05.05', 'jenis_arsip' => 'Komunikasi Pemasaran', 'aktif' => '2 tahun setelah pelaksanaan', 'inaktif' => '1 tahun', 'tindakan_akhir' => 'Musnah'],

            // VII. PM.00 - PM - PEMELIHARAAN
            ['kode_klasifikasi' => 'PM.00.01', 'jenis_arsip' => 'Alat Tambang', 'aktif' => '2 tahun setelah pelaksanaan', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'PM.00.02', 'jenis_arsip' => 'Rawmill', 'aktif' => '2 tahun setelah pelaksanaan', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'PM.00.03', 'jenis_arsip' => 'Kiln & Coal mill', 'aktif' => '2 tahun setelah pelaksanaan', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'PM.00.04', 'jenis_arsip' => 'Cement mill', 'aktif' => '2 tahun setelah pelaksanaan', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'PM.00.05', 'jenis_arsip' => 'Packing Plant', 'aktif' => '2 tahun setelah pelaksanaan', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'PM.00.06', 'jenis_arsip' => 'Alat Transport', 'aktif' => '2 tahun setelah pelaksanaan', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],

            // PM.01 - Peralatan Penunjang Produksi
            ['kode_klasifikasi' => 'PM.01.01', 'jenis_arsip' => 'Alat Berat', 'aktif' => '2 tahun setelah pelaksanaan', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'PM.01.02', 'jenis_arsip' => 'Alat Bantu', 'aktif' => '2 tahun setelah pelaksanaan', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],

            // PM.03 - Peralatan Uji Mutu
            ['kode_klasifikasi' => 'PM.03.01', 'jenis_arsip' => 'Alat Kalibrasi', 'aktif' => '1 tahun setelah pelaksanaan', 'inaktif' => '1 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'PM.03.02', 'jenis_arsip' => 'Alat Ukur', 'aktif' => '1 tahun setelah pelaksanaan', 'inaktif' => '1 tahun', 'tindakan_akhir' => 'Musnah'],

            // PM.04 - Energi Listrik
            ['kode_klasifikasi' => 'PM.04.01', 'jenis_arsip' => 'PLTA', 'aktif' => '1 tahun setelah pelaksanaan', 'inaktif' => '1 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'PM.04.02', 'jenis_arsip' => 'PLTD', 'aktif' => '1 tahun setelah pelaksanaan', 'inaktif' => '1 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'PM.04.03', 'jenis_arsip' => 'Gardu Induk', 'aktif' => '2 tahun setelah pelaksanaan', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'PM.04.04', 'jenis_arsip' => 'WHRPG', 'aktif' => '2 tahun setelah pelaksanaan', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Musnah'],
            ['kode_klasifikasi' => 'PM.04.05', 'jenis_arsip' => 'Distribusi', 'aktif' => '1 tahun setelah pelaksanaan', 'inaktif' => '1 tahun', 'tindakan_akhir' => 'Musnah'],

            // PM.05 - Sistem Informasi
            ['kode_klasifikasi' => 'PM.05.01', 'jenis_arsip' => 'Hardware', 'aktif' => '2 tahun setelah pelaksanaan', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Permanen'],
            ['kode_klasifikasi' => 'PM.05.02', 'jenis_arsip' => 'Software', 'aktif' => '2 tahun setelah pelaksanaan', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Permanen'],
            ['kode_klasifikasi' => 'PM.05.03', 'jenis_arsip' => 'Jaringan Komunikasi', 'aktif' => '2 tahun setelah pelaksanaan', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Permanen'],
            ['kode_klasifikasi' => 'PM.05.04', 'jenis_arsip' => 'Aplikasi system', 'aktif' => '2 tahun setelah pelaksanaan', 'inaktif' => '3 tahun', 'tindakan_akhir' => 'Permanen'],
        ];
        
        // Transform data map to flat array with summed dates
        $finalData = [];
        
        // Process Fasilitatif
        foreach ($data as $item) {
            $aktifYears = $this->extractYears($item['aktif']);
            $inaktifYears = $this->extractYears($item['inaktif']);
            $total = $aktifYears + $inaktifYears;
            
            $masaSimpan = $total > 0 ? $total . ' Tahun' : $item['aktif'] . ' / ' . $item['inaktif'];
            
            $finalData[] = [
                'kode_klasifikasi' => $item['kode_klasifikasi'],
                'jenis_arsip' => $item['jenis_arsip'],
                'aktif' => $item['aktif'],
                'inaktif' => $item['inaktif'],
                'masa_simpan' => $masaSimpan,
                'tindakan_akhir' => $item['tindakan_akhir'],
            ];
        }

        // Process Substantif
        foreach ($dataSubstantif as $item) {
            $aktifYears = $this->extractYears($item['aktif']);
            $inaktifYears = $this->extractYears($item['inaktif']);
            $total = $aktifYears + $inaktifYears;
            
            $masaSimpan = $total > 0 ? $total . ' Tahun' : $item['aktif'] . ' / ' . $item['inaktif'];
            
            $finalData[] = [
                'kode_klasifikasi' => $item['kode_klasifikasi'],
                'jenis_arsip' => $item['jenis_arsip'],
                'aktif' => $item['aktif'],
                'inaktif' => $item['inaktif'],
                'masa_simpan' => $masaSimpan,
                'tindakan_akhir' => $item['tindakan_akhir'],
            ];
        }

        try {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            DB::table('master_klasifikasi')->truncate();
            
            // Insert in chunks to avoid placeholder limits or memory issues
            foreach (array_chunk($finalData, 50) as $chunk) {
                DB::table('master_klasifikasi')->insert($chunk);
            }
            
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            
            $count = count($finalData);
            $this->command->info("Seeder berhasil! Total $count data master_klasifikasi telah dimasukkan.");
        } catch (\Exception $e) {
            $this->command->error("GAGAL SEEDING: " . $e->getMessage());
        }
    }
    
    private function extractYears($text) {
        if (preg_match('/(\d+)\s*tahun/i', $text, $matches)) {
            return (int)$matches[1];
        }
        return 0;
    }
}
