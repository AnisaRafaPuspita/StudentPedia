<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Keaktifan Penjual</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; }
        th { background: #eee; }
        h2 { margin-bottom: 5px; }
    </style>
</head>

<body>

<h2>Laporan Daftar Akun Penjual Berdasarkan Status</h2>
<p>Tanggal dibuat: {{ $tanggal }} oleh {{ $pemroses }}

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama User</th>
            <th>Nama PIC</th>
            <th>Nama Toko</th>
            <th>Status</th>
        </tr>
    </thead>

    <tbody>
        @foreach($data as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->user->name }}</td>
            <td>{{ $item->nama_pic }}</td>
            <td>{{ $item->nama_toko }}</td>
            <td>{{ $item->status_label }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
