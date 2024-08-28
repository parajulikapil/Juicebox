<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Jobs\SendWelcomeEmailJob;

class SendWelcomeEmailJobCommand extends Command
{
    /**
     * The name and signature of the console command.
     * This needs userId as argument
     *
     * @var string
     */
    protected $signature = 'mail:send-welcome-email {userId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send welcome email to user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userId = $this->argument('userId');
                
        if (!is_numeric($userId) || (int)$userId <= 0) {
            $this->fail("Argument must be positive integer value greater than 0");            
        }

        $user = User::findById($userId);

        if (!$user) {
            $this->fail("User not found to send email");
            return 1;
        }

        SendWelcomeEmailJob::dispatch($user);
    }
}
