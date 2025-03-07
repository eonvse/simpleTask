<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\WorkerRepositoryInterface;
use App\Repositories\WorkerRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(WorkerRepositoryInterface::class,WorkerRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
