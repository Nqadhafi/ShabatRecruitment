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
    public $pdfPath;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($application, $letter, $pdf = null)
    {
        //
        $this->application = $application;
        $this->letter = $letter;
        $this->pdfPath = $pdf;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $mail = $this->from('no-reply@career.shabatprinting.com', 'Recruitment Shabat Printing')
            ->subject('Selamat! Anda Diterima')
            ->view('emails.hired-mail');

        if ($this->pdfPath) {
            $mail->attach(storage_path('app/public/' . $this->pdfPath), [
                'mime' => 'application/pdf',
            ]);
        }

        return $mail;
    }
}
