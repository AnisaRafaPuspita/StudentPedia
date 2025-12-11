<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Rating Produk</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color:#000; }
        .title { font-weight:700; font-size:14px; margin-bottom:2px; }
        .subtitle { font-style: italic; margin-bottom:12px; }

        table { width:100%; border-collapse: collapse; margin-top:8px; }
        th, td { border:1px solid #000; padding:6px 8px; }
        th { font-weight:700; text-align:center; }

        td.no { width:5%; text-align:center; }
        td.text { text-align:left; }
        td.num { text-align:center; white-space:nowrap; }

        .note { margin-top:8px; font-style: italic; font-size:11px; }
    </style>
</head>
<body>

    <div class="title">Laporan Daftar Produk Berdasarkan Rating</div>

    <div class="subtitle">
        Tanggal dibuat: {{ now()->format('d-m-Y') }} oleh
        {{ auth()->user()->name ?? 'NamaAkunPemroses' }}
    </div>

    <table>
        <thead>
        <tr>
            <th>No</th>
            <th>Produk</th>
            <th>Kategori</th>
            <th>Harga</th>
            <th>Stock</th>
            <th>Rating</th>
        </tr>
        </thead>
        <tbody>
        @foreach($products as $i => $p)
            <tr>
                <td class="no">{{ $i+1 }}</td>
                <td class="text">{{ $p->nama_produk }}</td>
                <td class="text">{{ $p->category->nama_kategori ?? '-' }}</td>
                <td class="num">Rp {{ number_format($p->harga,0,',','.') }}</td>
                <td class="num">{{ $p->stok }}</td>
                <td class="num">{{ number_format($p->ratings_avg_rating ?? 0, 2) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="note">***) urutkan berdasarkan rating</div>

</body>
</html>
