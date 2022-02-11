<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    /**
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\UserCollection
     */
    public function index(Request $request)
    {
        $users = User::all();

        return new UserCollection($users);
    }

    public function emailCheck(Request $request, string $email)
    {
        $exists = User::where('email', $email)->exists();

        if ($exists) {
            return response()->json(['exists' => true]);
        } else {
            return response()->json(['exists' => false]);
        }
        
    }
}
