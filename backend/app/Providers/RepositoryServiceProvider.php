<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\TaskRepositoryInterface;
use App\Repositories\EloquentTaskRepository;
use App\Services\AuthServiceInterface;
use App\Services\AuthService;
use App\Services\TaskServiceInterface;
use App\Services\TaskService;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Quand on demande TaskRepositoryInterface → Laravel injecte EloquentTaskRepository
        $this->app->bind(TaskRepositoryInterface::class, EloquentTaskRepository::class);

        // Quand on demande AuthServiceInterface → Laravel injecte AuthService
        $this->app->bind(AuthServiceInterface::class, AuthService::class);

        // Quand on demande TaskServiceInterface → Laravel injecte TaskService
        $this->app->bind(TaskServiceInterface::class, TaskService::class);
    }

    public function boot() {}
}
