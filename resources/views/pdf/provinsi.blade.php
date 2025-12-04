<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Toko per Provinsi</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; }
        th { background: #eee; }
        h2 { margin-bottom: 5px; }
    </style>
</head>
<body>

<h2>Laporan Daftar Toko Berdasarkan Lokasi Propinsi</h2>
<p>Tanggal dibuat: {{ $tanggal }} oleh <b>{{ $pemroses }}</b></p>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Toko</th>
            <th>Nama PIC</th>
            <th>Provinsi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $i => $d)
        <tr>
            <td>{{ $i+1 }}</td>
            <td>{{ $d->nama_toko }}</td>
            <td>{{ $d->nama_pic }}</td>
            <td>{{ $d->provinsi }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
