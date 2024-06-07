<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Response::macro('jsonSuccess', function ($data, $status = 200) {
            return Response::json([
                'success' => true,
                'status' => $status,
                'data' => $data,
            ]);
        });

        Response::macro('jsonError', function ($error, $status = 400, $message = null, $trace = null) {
            return Response::json([
                'success' => false,
                'status' => $status,
                'error' => $error,
                'message' => $message,
                'trace' => $trace,
            ]);
        });
    }
}
