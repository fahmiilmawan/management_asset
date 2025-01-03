<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pengadaan</title>
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
    <h1>Laporan Pengadaan Barang</h1>
    <table>
        <thead>
            <tr>
                <th>Nama Barang </th>
                <th>Diajukan Oleh</th>
                <th>Untuk Ruangan</th>
                <th>Satuan Pengadaan</th>
                <th>Harga Satuan</th>
                <th>Jumlah Pengadaan</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pengadaans as $pengadaan)
                <tr>
                   <td>{{ $pengadaan->nama_barang_pengadaan }}</td>
                   <td>{{ $pengadaan->user->nama_lengkap }}</td>
                   <td>{{ $pengadaan->ruangan->nama_ruangan }}</td>
                   <td>{{ $pengadaan->satuan_pengadaan }}</td>
                   <td>Rp.{{ number_format($pengadaan->harga_satuan, 0, ',', '.') }}</td>
                   <td>{{ $pengadaan->jumlah_pengadaan }}</td>
                   <td>Rp.{{ number_format($pengadaan->total_harga, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
