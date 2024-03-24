<?php

namespace App\Http\Services\User;

use App\Mail\SendWelcomeToNewUser;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class SendEmailWelcomeService
{
    public function handle(User $user, string $password)
    {
        Mail::to($user->email, $user->name)
            ->send(new SendWelcomeToNewUser($user->name, $user->profile->name, $password));
    }
}
