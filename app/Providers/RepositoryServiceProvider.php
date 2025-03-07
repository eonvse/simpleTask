<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\WorkerRepositoryInterface;
use App\Repositories\WorkerRepository;
use App\Interfaces\TaskRepositoryInterface;
use App\Repositories\TaskRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(WorkerRepositoryInterface::class,WorkerRepository::class);
        $this->app->bind(TaskRepositoryInterface::class,TaskRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
