<?php

namespace App\Providers;

use App\Repositories\History\HistoryRepository;
use App\Repositories\History\HistoryRepositoryInterface;
use App\Repositories\Monitor\MonitorRepository;
use App\Repositories\Monitor\MonitorRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->bind(MonitorRepositoryInterface::class, MonitorRepository::class);

        $this->app->bind(HistoryRepositoryInterface::class, HistoryRepository::class);
    }
}
