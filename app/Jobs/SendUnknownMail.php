<?php

namespace App\Jobs;

use App\Mail\UnknownMail;
use App\Models\emailHistory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendUnknownMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $emilHistory = emailHistory::where('is_sent_email',0)->get();
        Log::info("worr");
        foreach( $emilHistory as $value){
            try {
                $emildata = ['message' => 'This serves as a gentle reminder regarding the previously attached document for your review and consideration'];
                Mail::to($value->suppliear_email)->cc($value->company_email)
                    ->send(new UnknownMail($emildata));

                // Update the email status after successful sending
                $value->update(['is_sent_email' => 1]);

                Log::info("Email sent to: " . $value->suppliear_email);
            } catch (\Exception $e) {
                Log::error("Failed to send email: " . $e->getMessage());
            }
        }
    }
}
