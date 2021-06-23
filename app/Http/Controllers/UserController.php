<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
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
}
