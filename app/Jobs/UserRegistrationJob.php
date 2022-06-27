<?php

namespace App\Jobs;
use App\Models\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class UserRegistrationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $user;

    /**
     * Create a new job instance.
     *
     * @param User $user
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function handle()
    {
        $user = $this->user;
        Mail::send('emails.user_registration', ['user' => $user], function ($m) use ($user) {
            $m->from(env('MAIL_FROM_ADDRESS'), env('APP_NAME'));
            $m->to($user->email, $user->name)->subject('Reset your password');
        });
    }
}
