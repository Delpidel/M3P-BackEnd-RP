<?php

namespace App\Http\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{

    public function getAll($search)
    {
        $search = strtolower($search);

        return User::query()->with("profile")->withTrashed()
            ->where(function ($query) use ($search) {
                $query->where('name', 'like', "%$search%") //O correto é utilizar o ilike, mas o teste unitário falha por causa do banco de dados sqlite
                    ->orWhere('email', 'like', "%$search%");
            })
            ->orderBy('id')
            ->get();
    }
}
