<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Produk per Kategori</title>
    <style>
        bbody { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; }
        th { background: #eee; }
        h2 { margin-bottom: 5px; }
    </style>
</head>

<body>

<h2>Laporan Produk per Kategori</h2>
<p>Tanggal dibuat: {{ $tanggal }} oleh {{ $pemroses }}

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Produk</th>
            <th>Kategori</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Nama Toko</th>
        </tr>
    </thead>

    <tbody>
        @foreach($data as $i => $item)
        <tr>
            <td>{{ $i+1 }}</td>
            <td>{{ $item->produk }}</td>
            <td>{{ $item->kategori }}</td>
            <td>{{ number_format($item->harga, 0, ',', '.') }}</td>
            <td>{{ $item->stok }}</td>
            <td>{{ $item->nama_toko }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
