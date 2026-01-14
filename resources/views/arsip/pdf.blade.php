<!DOCTYPE html>
<html>
<head>
    <title>Daftar Arsip - PT Semen Padang</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10pt;
        }
        .header {
            width: 100%;
            border-bottom: 2px solid #8B0000; /* Red border */
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header table {
            width: 100%;
        }
        .header td {
            vertical-align: middle;
        }
        .logo {
            width: 80px;
        }
        .title {
            text-align: center;
            color: #8B0000;
        }
        .title h1 {
            margin: 0;
            font-size: 18pt;
            text-transform: uppercase;
        }
        .title h2 {
            margin: 0;
            font-size: 14pt;
        }
        .title p {
            margin: 0;
            font-size: 9pt;
        }
        
        table.data {
            width: 100%;
            border-collapse: collapse;
        }
        table.data th, table.data td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }
        table.data th {
            background-color: #f2f2f2;
            font-weight: bold;
            color: #8B0000;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <table>
            <tr>
                <td style="width: 100px;">
                    <img src="{{ public_path('images/logo-sp.png') }}" class="logo" alt="Logo">
                </td>
                <td class="title">
                    <h1>PT Semen Padang</h1>
                    <h2>Daftar Arsip Dokumen</h2>
                    <p>Indarung, Padang 25237, Sumatera Barat</p>
                </td>
                <td style="width: 100px;"></td> <!-- Spacer for balance -->
            </tr>
        </table>
    </div>

    <table class="data">
        <thead>
            <tr>
                <th>No</th>
                <th>No Berkas</th>
                <th>Kode Klasifikasi</th>
                <th>Nama Berkas</th>
                <th>Isi Berkas</th>
                <th>Tahun</th>
                <th>Tanggal Masuk</th>
                <th>Jumlah</th>
                <th>Masa Simpan</th>
                <th>Status</th>
                <th>Lokasi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($arsips as $index => $arsip)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>{{ $arsip->no_berkas }}</td>
                <td>{{ $arsip->klasifikasi->kode_klasifikasi ?? '-' }}</td>
                <td>{{ $arsip->nama_berkas }}</td>
                <td>{{ $arsip->isi_berkas }}</td>
                <td style="text-align: center;">{{ $arsip->tahun }}</td>
                <td style="text-align: center;">{{ \Carbon\Carbon::parse($arsip->tanggal_masuk)->format('d/m/Y') }}</td>
                <td style="text-align: center;">{{ $arsip->jumlah }}</td>
                <td>{{ $arsip->klasifikasi->masa_simpan ?? '-' }}</td>
                <td>{{ $arsip->klasifikasi->tindakan_akhir ?? '-' }}</td>
                <td>{{ $arsip->no_box }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
