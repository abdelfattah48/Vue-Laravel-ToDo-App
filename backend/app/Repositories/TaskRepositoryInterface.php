<?php

namespace App\Repositories;

use App\Models\Task;

interface TaskRepositoryInterface
{
    public function allByUser(int $userId);    // Récupérer toutes les tâches d’un utilisateur
    public function findByUser(int $userId, int $id): Task;// Récupérer une tâche spécifique
    public function create(array $data): Task;  // Créer une tâche
    public function updateByUser(int $userId, int $id, array $data): Task; // Mettre à jour une tâche
    public function deleteByUser(int $userId, int $id): bool; // Supprimer une tâche
}
