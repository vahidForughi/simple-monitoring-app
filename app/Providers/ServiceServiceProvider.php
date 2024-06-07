<?php

namespace App\Providers;

use App\Repositories\History\HistoryRepositoryInterface;
use App\Repositories\Monitor\MonitorRepository;
use App\Repositories\Monitor\MonitorRepositoryInterface;
use App\Services\History\HistoryService;
use App\Services\Monitor\MonitorService;
use Illuminate\Support\ServiceProvider;

class ServiceServiceProvider extends ServiceProvider
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
        $this->app->singleton(MonitorService::class, function ($app) {
            return new MonitorService(
                $app->make(MonitorRepositoryInterface::class),
            );
        });

        $this->app->singleton(HistoryService::class, function ($app) {
            return new HistoryService(
                $app->make(HistoryRepositoryInterface::class),
            );
        });
    }
}
