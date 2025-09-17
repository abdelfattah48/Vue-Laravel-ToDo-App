<?php
namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Services\TaskServiceInterface;
use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\Facades\JWTAuth;

class TaskController extends Controller
{
    protected $service; // Service pour gérer la logique des tâches

    public function __construct(TaskServiceInterface $service)
    {
        $this->service = $service; // Injection du service Task
    }
    // Afficher toutes les tâches de l’utilisateur connecté
    public function index()
    {
        return TaskResource::collection($this->service->index(JWTAuth::user()->id));
    }
    // Afficher une tâche spécifique
    public function show($id): JsonResponse
    {
        return response()->json(new TaskResource($this->service->show(JWTAuth::user()->id, $id)));
    }
    // Créer une nouvelle tâche
    public function store(StoreTaskRequest $request): JsonResponse
    {
        $task = $this->service->create(JWTAuth::user()->id, $request->validated());
        return (new TaskResource($task))->response()->setStatusCode(201);// Retourne la tâche créée
    }
    // Mettre à jour une tâche existante
    public function update(UpdateTaskRequest $request, $id): JsonResponse
    {
        return response()->json(new TaskResource($this->service->update(JWTAuth::user()->id, $id, $request->validated())));
    }
    // Supprimer une tâche
    public function destroy($id): JsonResponse
    {
        $this->service->delete(JWTAuth::user()->id, $id);
        return response()->json(['message' => 'Deleted']);
    }
}
