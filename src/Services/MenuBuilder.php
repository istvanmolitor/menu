<?php

declare(strict_types=1);

namespace Molitor\Menu\Services;

use Illuminate\Database\Eloquent\Model;

abstract class MenuBuilder
{
    public function init(Menu $menu, string $name, array $params = []): void
    {
    }
}
