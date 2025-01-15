
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
    </style>
</head>
<body>
    <h1>Laporan QR Code</h1>
<table style="width: 100%; border-collapse: collapse; text-align: center;">
    @foreach ($assets->chunk(3) as $chunk)
    <tr>
        @foreach ($chunk as $asset)
        <td style="padding: 10px;">
            <img src="{{ $asset->qr_code }}" alt="QR Code" width="200" height="200">
            <p>{{$asset->no_urut}}/{{ $asset->no_inventaris }}</p>
        </td>
        @endforeach
        <!-- Jika kolom kurang dari 3, tambahkan kolom kosong -->
        @for ($i = count($chunk); $i < 3; $i++)
        <td style="padding: 10px;"></td>
        @endfor
    </tr>
    @endforeach
</table>

</body>
</html>
