<?php

use Illuminate\Support\Facades\Route;
use Molitor\Menu\Http\Controllers\MenuController;

Route::prefix('api')->group(function () {
    Route::get('menu/{name}', [MenuController::class, 'show']);
});
