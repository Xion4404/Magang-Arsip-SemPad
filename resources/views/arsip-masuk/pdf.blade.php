<!DOCTYPE html>
<html>
<head>
    <title>Daftar Arsip Masuk - PT Semen Padang</title>
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
            background-color: #fce4e4; /* Light pinkish background matching the image */
            font-weight: bold;
            color: #000; /* Black text for headers based on user image */
            text-align: center;
            vertical-align: middle;
        }
    </style>
</head>
<body>
    <div class="header">
        <table>
            <tr>
                <td style="width: 100px;">
                    <img src="{{ $isPdf ? public_path('images/logo-sp.png') : asset('images/logo-sp.png') }}" class="logo" alt="Logo">
                </td>
                <td class="title">
                    <h1>PT Semen Padang</h1>
                    <h2>Daftar Arsip Masuk</h2>
                    <p>Indarung, Padang 25237, Sumatera Barat</p>
                </td>
                <td style="width: 100px;"></td> <!-- Spacer for balance -->
            </tr>
        </table>
    </div>

    <table class="data">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 20%;">No Berita Acara</th>
                <th style="width: 25%;">Unit Asal</th>
                <th style="width: 15%;">Tanggal Terima</th>
                <th style="width: 10%;">Jml Box</th>
                <th style="width: 25%;">Penerima</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $item)
            <tr>
                <td style="text-align: center;">{{ $loop->iteration }}</td>
                <td>{{ $item->nomor_berita_acara }}</td>
                <td>{{ $item->unit_asal }}</td>
                <td style="text-align: center;">{{ \Carbon\Carbon::parse($item->tanggal_terima)->format('d M Y') }}</td>
                <td style="text-align: center;">{{ $item->jumlah_box_masuk }}</td>
                <td>{{ $item->penerima->nama ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @if(isset($isPdf) && !$isPdf)
        <script>
            window.onload = function() {
                window.print();
            }
        </script>
    @endif
</body>
</html>
