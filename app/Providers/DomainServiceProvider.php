<?php

namespace App\Providers;

use App\Domain\Task\TaskRepository;
use App\Infrastructure\Persistence\EloquentTaskRepository;
use Illuminate\Support\ServiceProvider;

class DomainServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(TaskRepository::class, EloquentTaskRepository::class);
    }
}
