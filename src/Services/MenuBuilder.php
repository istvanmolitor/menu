<?php

declare(strict_types=1);

namespace Molitor\Menu\Services;

abstract class MenuBuilder
{
    public function init(Menu $menu, string $name, array $params = []): void {}
}
