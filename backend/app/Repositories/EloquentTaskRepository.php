<?php

namespace App\Repositories;

use App\Models\Task;

class EloquentTaskRepository implements TaskRepositoryInterface
{
    public function allByUser(int $userId)
    {
        // Retourne toutes les tâches d’un utilisateur, les plus récentes en premier
        return Task::where('user_id', $userId)->latest()->get();
    }

    public function findByUser(int $userId, int $id): Task
    {
        // Retourne une tâche spécifique d’un utilisateur ou lève une erreur si non trouvée
        return Task::where('user_id', $userId)->findOrFail($id);
    }

    public function create(array $data): Task
    {
        // Crée une nouvelle tâche en base
        return Task::create($data);
    }

    public function updateByUser(int $userId, int $id, array $data): Task
    {
        // Met à jour une tâche existante
        $task = $this->findByUser($userId, $id);
        $task->update($data);
        return $task;
    }

    public function deleteByUser(int $userId, int $id): bool
    {
        // Supprime une tâche existante
        $task = $this->findByUser($userId, $id);
        return (bool) $task->delete();
    }
}
