<?php

namespace App\Services;

use App\Repositories\TaskRepositoryInterface;
use App\Models\Task;
use App\Events\TaskCreated;

class TaskService implements TaskServiceInterface
{
    protected $repo;

    public function __construct(TaskRepositoryInterface $repo)
    {
        $this->repo = $repo; // Injection du repository pour gérer les tâches
    }

    public function index(int $userId)
    {
        return $this->repo->allByUser($userId);
         // Récupère toutes les tâches de l'utilisateur
    }

    public function show(int $userId, int $id): Task
    {
        return $this->repo->findByUser($userId, $id);
        // Récupère une tâche spécifique de l'utilisateur
    }

    public function create(int $userId, array $data): Task
    {
        $data['user_id'] = $userId;
        $task = $this->repo->create($data);
        // Crée une nouvelle tâche pour l'utilisateur
        event(new TaskCreated($task)); 
        // Déclenche l'événement TaskCreated pour les notifications en temps réel
        return $task;
    }

    public function update(int $userId, int $id, array $data): Task
    {
        return $this->repo->updateByUser($userId, $id, $data);
        // Met à jour une tâche spécifique

    }

    public function delete(int $userId, int $id): bool
    {
        return $this->repo->deleteByUser($userId, $id);
        // Supprime une tâche spécifique
    }
}
