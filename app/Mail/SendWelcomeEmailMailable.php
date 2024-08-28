<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;


class SendWelcomeEmailMailable extends Mailable
{
    use Queueable, SerializesModels;

    protected string $template = 'email.welcome';
    public $subject = 'Welcome Email';

    /**
     * Create a new message instance.
     */
    public function __construct(private readonly User $user) {}
    
    /**
     * Setup all data to send email
     */
    public function build(): static
    {        
        return $this->subject($this->subject)
                ->view($this->template)
                ->with([
                    'user' => $this->user
                ]);
    }
}
