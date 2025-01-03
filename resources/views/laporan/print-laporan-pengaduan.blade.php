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
    <h1>Laporan Pengaduan Barang</h1>
    <table>
        <thead>
            <tr>
                <th>Nama Barang </th>
                <th>Pengadu</th>
                <th>Dari Ruangan</th>
                <th>Pengaduan</th>
                <th>Status</th>
                <th>Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pengaduans as $pengaduan)
                <tr>
                  <td>{{ $pengaduan->asset->barang->nama_barang }}</td>
                  <td>{{ $pengaduan->user->nama_lengkap }}</td>
                  <td>{{ $pengaduan->asset->ruangan->nama_ruangan }}</td>
                  <td>{{ $pengaduan->pengaduan }}</td>
                  <td>{{ $pengaduan->status }}</td>
                  <td>{{ $pengaduan->deskripsi }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
