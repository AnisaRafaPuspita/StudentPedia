<!DOCTYPE html>
<html>
<body>
    <h2>Terima kasih, {{ $rating->nama_pengunjung }}! 🎉</h2>

    <p>Kamu sudah memberi ulasan untuk produk:</p>
    <b>{{ $product->nama_produk }}</b>

    <p>Rating: ⭐ {{ $rating->rating }}</p>
    <p>Komentar: "{{ $rating->komentar }}"</p>

    <br>
    <p>Salam hangat,</p>
    <p><b>StudentPedia</b></p>
</body>
</html>
