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

/**
 * @property User $user
 */
class UserResetPasswordJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $user;



    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function handle()
    {
        $user = $this->user;
        $token = $this->user->passwordReset->token;
        $url_back = $this->user->passwordReset['url-back'];
        Mail::send('emails.reset-password', ['token' => $token, 'url_back' => $url_back, 'user' => $user], function ($m) use ($token, $url_back, $user) {
            $m->from(env('MAIL_FROM_ADDRESS'), env('APP_NAME'));
            $m->to($user->email, $user->name)->subject('Reset your password');
        });
    }
}
