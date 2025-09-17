<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * Service responsable de l'authentification des utilisateurs.
 * Il gère l'inscription, la connexion et la récupération de l'utilisateur connecté.
 */
class AuthService implements AuthServiceInterface
{
    public function register(array $data): array  // Crée un utilisateur et retourne [user, token]
    {
        $user = User::create([
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'address' => $data['address'] ?? null,
            'password' => Hash::make($data['password']),
            'image' => $data['image'] ?? null,
        ]);

        $token = JWTAuth::fromUser($user);

        return [$user, $token];
    }

    public function login(array $credentials): array // Connecte un utilisateur et retourne [user, token]
    {
        if (!$token = JWTAuth::attempt($credentials)) {
            throw new \Exception('Invalid credentials');
        }
        $user = JWTAuth::user();
        return [$user, $token];
    }

    public function me(): User // Retourne l'utilisateur connecté
    {
        return JWTAuth::user();
    }
}
