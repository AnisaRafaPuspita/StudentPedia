<?php

namespace App\Mail;

use App\Models\Rating;
use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReviewThanksMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Rating $rating,
        public Comment $comment
    ) {}

    public function build()
    {
        return $this
            ->subject('Terima kasih atas komentar Anda!')
            ->view('emails.review_thanks');
    }
}
