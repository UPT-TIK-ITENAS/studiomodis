<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PeminjamanApprove extends Mailable
{
    use Queueable, SerializesModels;
    public $borrows, $status;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($borrows, $status)
    {
        $this->borrows = $borrows;
        $this->status = $status;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("Studio Modis - Permintaan Peminjaman di $this->status!")->view('layouts.emails.peminjaman_approve');
    }
}
