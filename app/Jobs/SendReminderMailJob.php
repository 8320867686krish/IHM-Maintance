<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendReminderMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $to;
    protected $subject;
    protected $message;
    protected $headers;
    /**
     * Create a new job instance.
     */
    public function __construct($to, $subject, $message, $headers)
    {
        $this->to = $to;
        $this->subject = $subject;
        $this->message = $message;
        $this->headers = $headers;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        mail($this->to, $this->subject, wordwrap($this->message, 70), $this->headers);

    }
}
