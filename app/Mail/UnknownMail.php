<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UnknownMail extends Mailable
{
    use Queueable, SerializesModels;
    public $emailData;

    /**
     * Create a new message instance.
     */
    public function __construct($emailData)
    {
        //
        $this->emailData = $emailData;

    }
    public function build()
    {
        return $this->subject('For Reminder')
                    ->markdown('emails.unknown')
                    ->with([
                        'messageBody' => $this->emailData['message'],
                    ]);
    }

    /**
     * Get the message envelope.
     */
   

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    
}
