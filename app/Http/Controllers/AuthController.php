<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\JsonResponse;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    use JsonResponse;

    public function register(Request $request)
    {
        $rules = [
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'name' => 'required|string|max:500',
        ];

        $validated = $request->validate($rules);
        $validated['password'] = bcrypt($request->password);
        $user = User::create($validated);

        return $this->success(['user' => $user], 201);
    }
    
    public function login(Request $request)
    {
        $attr = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|min:6'
        ]);
        

        if(auth()->attempt($request->only('email','password'))) {
            return $this->success([
                'access_token' => auth()->user()->createToken('access_token')->plainTextToken,
                'token_type'=> 'Bearer',
                'user' => auth()->user(),
            ]);
        }
        
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }


    public function profile(Request $request)
    {

        return $this->success(auth()->user());

    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return $this->success(null);
    }
}