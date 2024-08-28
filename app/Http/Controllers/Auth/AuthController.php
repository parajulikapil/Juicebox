<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\AbstractRestController;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Jobs\SendWelcomeEmailJob;
use Auth;

class AuthController extends AbstractRestController
{

    /**
     * Login
     */
    public function login(): JsonResponse
    {
        // Validate email and password
        $data = $this->request->validate([
            "email" => ['required', 'email', 'string'],
            "password" => ['required', 'string'],
        ]);
    
        if (!Auth::attempt($data)) {
            return $this->unauthorize();
        }

        $user = User::fetch(['email' => $data['email']], true);

        // Genereate token
        $token = $user->createToken(
                'personall-access-token', ['*']
            )->plainTextToken;
        
        return $this->success([
            'name' => $user->name,
            'email' => $user->email,
            'token' => $token,
            'expiration_at' => (int) config('sanctum.expiration') * 60 // converting minutes into seconds
        ]);
    }

    /**
     * Logout or revoke current user token
     */
    public function logout(): JsonResponse
    {
        // Revoke all the tokens of requested user
        $this->request->user()->tokens()->delete();

        return $this->success("Successfuly, logout");
    }

    /**
     * Register new user
     */
    public function register(): JsonResponse
    {        
        // Validate payload
        $data = $this->request->validate([
            "name" => ['required', 'string'],
            "email" => ['required', 'email', 'string', 'unique:users,email'],
            "password" => ['required', 'string', 'confirmed', 'min:6'],
        ]);

        unset($data['password_confirmation']);

        $user = User::create($data);
        
        // Genereate token        
        $token = $user->createToken(
                'personall-access-token', ['*']
            )->plainTextToken;
        
        SendWelcomeEmailJob::dispatch($user);
        
        return $this->success([
            'name' => $user->name,
            'email' => $user->email,
            'token' => $token,
            'expiration_at' => (int) config('sanctum.expiration') * 60 // converting minutes into seconds
        ]);
    }
}