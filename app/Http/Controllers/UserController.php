<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{

    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        $user = User::create($data);

        return response()
            ->json(['token' => $user->createToken('riva')->plainTextToken], 200);
    }

    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        $user = User::where('username', $data['username'])->first();
        if (!$user) {
            throw ValidationException::withMessages(['username' => 'Username not found.']);
        }

        if (!Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages(['password' => 'Incorrect password.']);
        }

        $user->tokens()->delete();

        return response()
            ->json(['token' => $user->createToken($data['device_name'])->plainTextToken], 200);
    }

    public function updateFcmToken(Request $request)
    {
        $request->validate(['token' => 'required|string']);
        Auth::user()->update(['fcm_token' => $request->token]);
        return response()->json(['message' => "Berhasil menyimpan fcm token"]);
    }

    public function forgotPassword(Request $request){
        $request->validate(['email' => 'required|email']);

        $response = Password::sendResetLink(
            $request->only('email')
        );

        $message = $response == Password::RESET_LINK_SENT ? 'Berhasil mengirim link reset password' : 'Terjadi kesalahan';
        return response()->json(['message' => $message]);
    }
}
