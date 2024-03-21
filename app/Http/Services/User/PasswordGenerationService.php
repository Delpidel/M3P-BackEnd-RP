<?php

namespace App\Http\Services\User;

use Illuminate\Support\Str;

class PasswordGenerationService
{
    public function generatePassword($length = 8)
    {
        return Str::password($length);
    }
}
