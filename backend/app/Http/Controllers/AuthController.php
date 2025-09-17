<?php
namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthServiceInterface;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    protected $authService; // Service d'authentification

    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService; // Injection du service Auth
    }
    // Inscription d’un nouvel utilisateur
    public function register(RegisterRequest $request): JsonResponse
    {
        // On envoie les données validées au service Auth
        [$user, $token] = $this->authService->register($request->validated());
        // On retourne le token et les infos de l’utilisateur
        return response()->json(['token' => $token, 'user' => new UserResource($user)], 201);
    }

    // Connexion d’un utilisateur existant
    public function login(LoginRequest $request): JsonResponse
    {
        [$user, $token] = $this->authService->login($request->validated());
        // On retourne le token et les infos de l’utilisateur
        return response()->json(['token' => $token, 'user' => new UserResource($user)]);
    }
    // Récupération des infos de l’utilisateur connecté
    public function me(): JsonResponse
    {
        // récupération de l’utilisateur via le service Auth
        return response()->json(new UserResource($this->authService->me()));
    }
}
