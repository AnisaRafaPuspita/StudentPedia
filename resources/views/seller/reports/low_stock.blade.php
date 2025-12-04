<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Daftar Produk Segera Dipesan</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; }
        h1 { font-size: 16px; margin-bottom: 0; }
        h2 { font-size: 13px; margin-top: 5px; }
        p  { margin: 3px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        th, td { border: 1px solid #000; padding: 5px 6px; }
        th { background-color: #f0f0f0; }
        .text-right { text-align: right; }
        .small-note { font-size: 9px; margin-top: 6px; }
    </style>
</head>
<body>
    <p>(SRS-MartPlace-14)</p>
    <h1>Laporan Daftar Produk Segera Dipesan</h1>
    <p>
        Tanggal dibuat: {{ $generated_at->format('d-m-Y') }}
        oleh <strong>{{ $user_name }}</strong>
    </p>
    <p>Nama Toko: <strong>{{ $seller->nama_toko }}</strong></p>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 35%;">Produk</th>
                <th style="width: 30%;">Kategori</th>
                <th style="width: 15%;">Harga</th>
                <th style="width: 15%;">Stok</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $index => $product)
                <tr>
                    <td class="text-right">{{ $index + 1 }}</td>
                    <td>{{ $product->nama_produk }}</td>
                    <td>{{ optional($product->category)->nama ?? '-' }}</td>
                    <td class="text-right">
                        Rp {{ number_format($product->harga, 0, ',', '.') }}
                    </td>
                    <td class="text-right">{{ $product->stok }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p class="small-note">
        ***) Diurutkan berdasarkan kategori dan produk.
    </p>
</body>
</html>
