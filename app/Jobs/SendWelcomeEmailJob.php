<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Mail\SendWelcomeEmailMailable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendWelcomeEmailJob implements ShouldQueue
{
    use Queueable;

    /**
     * @param User $user
     */
    public function __construct(private readonly User $user) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {        
        Mail::to($this->user->email)
        ->send(new SendWelcomeEmailMailable($this->user));
    }
}
