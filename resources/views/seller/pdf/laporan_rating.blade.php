<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Rating Produk</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        h2 { margin-bottom: 3px; }
        table { width:100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border:1px solid #ddd; padding:6px; }
        th { background:#f5f5f5; }
    </style>
</head>
<body>
    <h2>Laporan Rating Produk</h2>
    <p>Toko: {{ $seller->nama_toko }}</p>
    <p>Tanggal: {{ now()->format('d M Y') }}</p>

    <table>
        <thead>
        <tr>
            <th>No</th>
            <th>Nama Produk</th>
            <th>Kategori</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Rating</th>
        </tr>
        </thead>
        <tbody>
        @foreach($products as $i => $p)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $p->nama_produk }}</td>
                <td>{{ $p->category->nama_kategori ?? '-' }}</td>
                <td>Rp {{ number_format($p->harga,0,',','.') }}</td>
                <td>{{ $p->stok }}</td>
                <td>{{ number_format($p->ratings_avg_rating ?? 0, 2) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>
