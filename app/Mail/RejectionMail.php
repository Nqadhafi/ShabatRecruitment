<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RejectionMail extends Mailable
{
    use Queueable, SerializesModels;
    public $application;
    public $reason;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($application, $reason)
    {
        //
        $this->application = $application;
        $this->reason = $reason;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
                    return $this->from('no-reply@career.shabatprinting.com', 'Recruitment Shabat Printing')
                    ->subject('Status Lamaran Anda')
                    ->view('emails.rejection-mail');
    }
}
