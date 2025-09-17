<?php

namespace App\Services;

use App\Models\User;

interface AuthServiceInterface
{
    public function register(array $data): array;// Crée un nouvel utilisateur et retourne un tableau [User, token]
    public function login(array $credentials): array; // Authentifie un utilisateur existant et retourne un tableau [User, token]
    public function me(): User; // Retourne l'utilisateur connecté

}
