<?php

namespace App\Services;

use App\Models\Task;

interface TaskServiceInterface
{
    public function index(int $userId);
    public function show(int $userId, int $id): Task;
    public function create(int $userId, array $data): Task;
    public function update(int $userId, int $id, array $data): Task;
    public function delete(int $userId, int $id): bool;
}
