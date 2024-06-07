<?php

Route::group([], function () {

    Route::prefix('/monitors')->group(
        base_path('routes/group/monitor.php')
    );

});
