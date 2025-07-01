<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class HiredMail extends Mailable
{
    use Queueable, SerializesModels;
    public $application;
    public $letter;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($application, $letter)
    {
        //
        $this->application = $application;
        $this->letter = $letter;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
                    return $this->from('no-reply@career.shabatprinting.com', 'Recruitment Shabat Printing')
                    ->subject('Selamat! Anda Diterima')
                    ->view('emails.hired-mail');
    }
}
