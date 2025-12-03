<?php

namespace Molitor\Menu\View\Components;

use Illuminate\View\Component;
use Molitor\Menu\Services\MenuManager;

class Menu extends Component
{
    public function __construct(
        protected string $name,
        protected string $template = 'menu::buttons',
        protected array $params = [],
        protected array|string|null $active = null
    ) {
    }

    public function render(): string
    {
        /** @var MenuManager $menuManager */
        $menuManager = app(MenuManager::class);

        /** @var \Molitor\Menu\Services\Menu $menu */
        $menu = $menuManager->build($this->name, $this->params);

        if($this->active !== null) {
            $menu->setActiveByName($this->active);
        }

        return view($this->template, [
            'menu' => $menu
        ])->render();
    }
}
