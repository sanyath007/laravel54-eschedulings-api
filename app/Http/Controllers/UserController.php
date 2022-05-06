<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\User;

class UserController extends Controller
{
    public function getAll(Request $req)
    {
        $users = User::with('prefix','academic','position')
                    ->with('memberOf','memberOf.depart')
                    ->get();

        return [
            'users' => $users
        ];
    }

    public function getById($id)
    {
        $user = User::where('person_id', $id)
                    ->with('prefix','academic','position')
                    ->with('memberOf','memberOf.depart')
                    ->first();

        return [
            'user' => $user
        ];
    }
}
