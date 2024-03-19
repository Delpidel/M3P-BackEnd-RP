<?php

namespace App\Http\Controllers;

use App\Http\Services\User\DeleteOneUserService;
use App\Http\Services\User\GetAllUsersService;

use App\Traits\HttpResponses;

use Illuminate\Http\Request;

class UserController extends Controller
{
    use HttpResponses;

    public function index(Request $request, GetAllUsersService $getAllUsersService)
    {
        $search = $request->input('word');

        $users = $getAllUsersService->handle($search);

        return $users;
    }

    public function destroy($id, DeleteOneUserService $deleteOneUserService)
    {

        return $deleteOneUserService->handle($id);
    }
}
