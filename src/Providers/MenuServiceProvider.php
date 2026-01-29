<?php

namespace Molitor\Menu\Providers;

use Illuminate\Support\ServiceProvider;
use Molitor\Menu\Services\MenuManager;

class MenuServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/menu.php' => config_path('menu.php'),
        ], 'menu');

        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
    }

    public function register()
    {
        $this->app->singleton('menu', function ($app) {
            return new MenuManager();
        });

        $this->app->singleton(MenuManager::class, function ($app) {
            return app('menu');
        });
    }
}
