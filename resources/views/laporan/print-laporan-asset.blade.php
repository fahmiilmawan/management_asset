<!DOCTYPE html>
<html>
<head>
    <title>Laporan Asset</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Laporan Asset</h1>
    <table>
        <thead>
            <tr>
                <th>QR Code</th>
                <th>No Inventaris</th>
                <th>Nama Asset</th>
                <th>Untuk Unit</th>
                <th>Jumlah</th>
                <th>Berada di</th>
                <th>Periode</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($assets as $asset)
                <tr>
                    <td> <img src="{{ $asset->qr_code }}" width="50px" height="50px"></td>
                    <td>{{  $asset->no_inventaris }}</td>
                    <td>{{ $asset->barang->nama_barang }}</td>
                    <td>{{ $asset->unit->nama_unit }}</td>
                    <td>{{ $asset->jumlah }}</td>
                    <td>{{ $asset->ruangan->nama_ruangan }}</td>
                    <td>{{ $asset->tahun }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
