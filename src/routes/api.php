<?php

use Molitor\Menu\Http\Controllers\Api\MenuApiController;

Route::middleware('web')->prefix('/api')->group(
    function () {
        Route::get('menu/{name}', [MenuApiController::class, 'show'])->name('api.menu.show');
    }
);
