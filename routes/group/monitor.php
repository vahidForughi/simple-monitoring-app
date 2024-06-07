<?php

Route::get('/', [\App\Http\Controllers\MonitorController::class, 'index']);

Route::post('/', [\App\Http\Controllers\MonitorController::class, 'store']);

Route::prefix('/{monitor_id}')->group(function () {

    Route::get('/', [\App\Http\Controllers\MonitorController::class, 'show']);

});

