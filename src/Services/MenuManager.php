<?php

declare(strict_types=1);

namespace Molitor\Menu\Services;

class MenuManager
{
    private array $menuBuilders = [];

    public function __construct()
    {
        foreach (config('menu', []) as $menuBuilderClass) {
            $this->addMenuBuilder(new $menuBuilderClass());
        }
    }

    public function addMenuBuilder(MenuBuilder $menuBuilder): void
    {
        $this->menuBuilders[] = $menuBuilder;
    }

    public function build(string $name, array $params = []): Menu
    {
        $menu = new Menu();
        /** @var MenuBuilder $menuBuilder */
        foreach ($this->menuBuilders as $menuBuilder) {
            $menuBuilder->init($menu, $name, $params);

            if (method_exists($menuBuilder, $name)) {
                call_user_func_array([$menuBuilder, $name], array_merge([$menu], $params));
            }
        }
        return $menu;
    }

    public function __call($name, $arguments)
    {
        return $this->build($name, $arguments);
    }
}
