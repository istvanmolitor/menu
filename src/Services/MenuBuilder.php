<?php

declare(strict_types=1);

namespace Molitor\Menu\Services;

use Illuminate\Database\Eloquent\Model;

abstract class MenuBuilder
{
    public function addResource(Menu $menu, string $routeName, ?Model $model)
    {
        $menu->addItem('Lista', route($routeName . '.index'))->setIcon('list');

        if ($model) {
            $menu->addItem('Szerkesztés', route($routeName . '.edit', $model))->setIcon('pencil');
            $menu->addItem('Részletek', route($routeName . '.show', $model))->setIcon('eye');
        } else {
            $menu->addItem('Létrehozás', route($routeName . '.create'))->setIcon('plus');
        }
    }
}
