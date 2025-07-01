<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InterviewCallMail extends Mailable
{
    use Queueable, SerializesModels;
    public $application;
    public $messageText;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($application, $messageText)
    {
        //
        $this->application = $application;
        $this->messageText = $messageText;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('no-reply@career.shabatprinting.com', 'Recruitment Shabat Printing')
            ->subject('Pemanggilan Wawancara')
            ->view('emails.interview-call');
    }
}
