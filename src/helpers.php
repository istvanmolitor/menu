<?php

use Molitor\Menu\Services\MenuItem;

if (! function_exists('menu')) {
    /**
     * @return MenuItem[]
     */
    function menu(string $name): array
    {
        return app('menu')->build($name)->getMenuItems();
    }
}
