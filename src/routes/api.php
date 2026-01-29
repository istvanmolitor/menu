<?php

use Illuminate\Support\Facades\Route;
use Molitor\Menu\Http\Controllers\MenuController;

Route::get('api/menu/{name}', [MenuController::class, 'show']);
