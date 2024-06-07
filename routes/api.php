<?php

use App\Models\Monitor;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware(
    \App\Http\Middleware\JsonApiMiddleware::class,
)->group(function () {

    Route::prefix('/')->group(
        base_path('routes/group/handler.php')
    );

});
