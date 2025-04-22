<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address; // <-- Make sure this is here
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Support\Facades\File;

class sendMail extends Mailable
{
    use Queueable, SerializesModels;
    public $mailData;

    public $fromAddress;

    /**
     * Create a new message instance.
     */
    public function __construct($mailData, $fromAddress = null)
    {
        //
        $this->mailData = $mailData;
        $this->fromAddress = $fromAddress;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $fromEmail = $this->fromAddress['email'];
        $fromName = $this->fromAddress['name'];
        return new Envelope(
            from: new Address('ihmportal@sosgroup.in'),

            replyTo: [new Address($fromEmail, $fromName)],
            subject: $this->mailData['title'],
        );
    }


    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.sendemail',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {

        if ($this->mailData['attachments']) {
            return collect($this->mailData['attachments'])
                ->map(function ($filePath) {
                    return Attachment::fromPath($filePath);
                })
                ->toArray();
            $this->deleteAttachments();
        } else {
            return [];
        }
    }
    public function deleteAttachments()
    {
        // Check if attachments exist and remove them
        if (!empty($this->mailData['attachments'])) {
            foreach ($this->mailData['attachments'] as $filePath) {
                // Check if the file exists before deleting
                if (File::exists($filePath)) {
                    File::delete($filePath); // Remove the file
                }
            }
        }
    }
}
