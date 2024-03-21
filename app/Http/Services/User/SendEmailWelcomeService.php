<?php

namespace App\Http\Services\User;

use App\Mail\SendWelcomeToUser;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class SendEmailWelcomeService
{
    public function handle(User $user, string $password)
    {
        Mail::to($user->email, $user->name)
            ->send(new SendWelcomeToUser($user->name, $user->profile->name, $password));
    }
}
