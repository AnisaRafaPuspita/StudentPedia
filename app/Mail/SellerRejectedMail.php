<?php

namespace App\Mail;

use App\Models\Seller;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SellerRejectedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $seller;

    /**
     * Create a new message instance.
     */
    public function __construct(Seller $seller)
    {
        $this->seller = $seller;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Pengajuan Seller Anda Ditolak')
                    ->view('emails.seller_rejected');
    }
}
