<!DOCTYPE html>
<html>
<body style="font-family: Arial, sans-serif;">

    <h2>Akun Seller Anda Telah Diaktifkan</h2>

    <p>Halo <strong>{{ $seller->nama_pic }}</strong>,</p>

    <p>
        Pengajuan Anda sebagai seller di <strong>Katalog PPL</strong>
        telah <span style="color: green; font-weight:bold;">DITERIMA</span>.
    </p>

    <p>Akun seller Anda sekarang sudah aktif dan siap digunakan.</p>

    <p>
        Silakan login melalui link berikut:<br>
        <a href="{{ url('/login') }}">{{ url('/login') }}</a>
    </p>

    <br>
    <p>Salam,<br>
    <strong>Tim Platform Katalog PPL</strong></p>

</body>
</html>
