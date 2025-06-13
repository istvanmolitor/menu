<?php

namespace Molitor\Menu\Facades;

use Illuminate\Support\Facades\Facade;

class Menu extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'menu';
    }
}
