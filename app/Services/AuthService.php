<?php
namespace App\Services;

use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthService
{
    /**
     */
    public function login(string $email, string $password)
    {
        $credentials = ['email' => $email, 'password' => $password];
        if (!$token = JWTAuth::attempt($credentials)) {
            return null;
        }
        return $token;
    }

    public function register(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        return JWTAuth::fromUser($user);
    }

    


  
}