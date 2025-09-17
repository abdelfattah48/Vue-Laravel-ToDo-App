<?php

namespace App\Providers;

use App\Repositories\EloquentTaskRepository;
use App\Repositories\TaskRepositoryInterface;
use App\Services\AuthService;
use App\Services\AuthServiceInterface;
use App\Services\TaskService;
use App\Services\TaskServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Pour les tâches
        $this->app->bind(TaskRepositoryInterface::class, EloquentTaskRepository::class);
        $this->app->bind(TaskServiceInterface::class, TaskService::class);

        // Pour l’authentification
        $this->app->bind(AuthServiceInterface::class, AuthService::class);
    }

    public function boot(): void
    {
        //
    }
}
