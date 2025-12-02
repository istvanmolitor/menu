<?php

namespace Molitor\Menu\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Molitor\Menu\Services\MenuManager;
use Molitor\Menu\View\Components\Menu;

class MenuServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'menu');

        Blade::component('menu', Menu::class);

        $this->publishes([
            __DIR__ . '/../config/menu.php' => config_path('menu.php'),
        ], 'menu');
    }

    public function register()
    {
        $this->app->singleton(MenuManager::class, function ($app) {
            return new MenuManager();
        });
    }
}
