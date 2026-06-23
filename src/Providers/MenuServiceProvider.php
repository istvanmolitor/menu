<?php

namespace Molitor\Menu\Providers;

use Illuminate\Support\ServiceProvider;
use Molitor\Menu\Services\MenuManager;

class MenuServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/menu.php' => config_path('menu.php'),
        ], 'menu');

        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
    }

    public function register()
    {
        require_once __DIR__.'/../helpers.php';

        $this->mergeConfigFrom(__DIR__.'/../config/menu.php', 'menu');

        $this->app->singleton('menu', function () {
            return new MenuManager;
        });

        $this->app->singleton(MenuManager::class, function () {
            return app('menu');
        });
    }
}
