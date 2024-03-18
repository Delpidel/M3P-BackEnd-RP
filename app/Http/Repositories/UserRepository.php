<?php

namespace App\Http\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{

    public function getAll($search)
    {
        return User::query()->with("profile")
            ->where(function ($query) use ($search) {
                $query->where('name', 'ilike', "%$search%")
                    ->orWhere('email', 'ilike', "%$search%");
            })
            ->orderBy('id')
            ->get();
    }
}
