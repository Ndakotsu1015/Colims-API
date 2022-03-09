<?php

namespace App\Http\Controllers;

use App\Mail\LoginSuccessful;
use App\Mail\RegistrationSuccessful;
use App\Models\Notification;
use App\Models\User;
use App\Traits\JsonResponse;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
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
            'profile_picture' => 'nullable|string|max:500',
        ];

        $validated = $request->validate($rules);
        $validated['password'] = bcrypt($request->password);
        $user = User::create($validated);

        $notification = new Notification();

        $notification->user_id = $user->id;
        $notification->subject = "Registration Successful";
        $notification->content = "Your account has been successfully created @ " . now() . ". Please login to your account.";
        $notification->action_link = env("CLIENT_URL") . "/auth/login";
        $notification->save();

        $recipientEmail = $user->email;

        try {
            Mail::to($recipientEmail)->queue(new RegistrationSuccessful($notification));
        } catch (Exception $e) {
            Log::debug($e);
        }

        return $this->success(['user' => $user], 201);
    }

    public function login(Request $request)
    {
        $attr = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|min:6'
        ]);


        if (auth()->attempt($request->only('email', 'password'))) {
            $notification = new Notification();

            $notification->user_id = auth()->user()->id;
            $notification->subject = "Successful Login Attempt";
            $notification->content = "You have successfully logged in @ " . now() . ".";
            // $notification->action_link = env("CLIENT_URL") . "/auth/login";
            $notification->save();

            $recipientEmail = auth()->user()->email;

            try {
                Mail::to($recipientEmail)->queue(new LoginSuccessful($notification));
            } catch (Exception $e) {
                Log::debug($e);
            }

            return $this->success([
                'access_token' => auth()->user()->createToken('access_token')->plainTextToken,
                'token_type' => 'Bearer',
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
