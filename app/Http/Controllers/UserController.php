<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserUpdateRequest;
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
        $users = User::latest()->get();

        return new UserCollection($users);
    }

    public function show(Request $request, User $user)
    {
        return new UserResource($user);
    }

    public function update(UserUpdateRequest $request, User $user)
    {
        $user->update($request->validated());

        $user->password = bcrypt($request->password);
        $user->save();

        return new UserResource($user);
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

    public function destroy(Request $request, User $user)
    {
        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }
}
