<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Terima kasih</title>
</head>
<body style="font-family: Arial, sans-serif; line-height:1.6;">
  <h2>Terima kasih, {{ $rating->name }}! 🎉</h2>

  <p>Komentar dan rating kamu sudah kami terima.</p>

  <p><strong>Rating:</strong> {{ $rating->rating }}/5</p>
  <p><strong>Komentar:</strong><br>{{ $comment->comment }}</p>

  <hr>
  <p style="font-size:12px;color:#777;">StudentPedia</p>
</body>
</html>
