<?php

declare(strict_types=1);

namespace Molitor\Menu\Services;

class Menu
{
    protected array $menuItems = [];

    public function addMenuItem(MenuItem $menuItem): void
    {
        $this->menuItems[] = $menuItem;
    }

    public function getByName(string $name): MenuItem|null
    {
        /** @var MenuItem $menuItem */
        foreach ($this->menuItems as $menuItem) {
            $foundMenuItem = $menuItem->getByName($name);
            if ($foundMenuItem) {
                return $foundMenuItem;
            }
        }
        return null;
    }

    public function addItem(string $label, ?string $href): MenuItem
    {
        $menuItem = new MenuItem($label);
        $menuItem->setHref($href);
        $this->addMenuItem($menuItem);

        return $menuItem;
    }

    /**
     * @return array
     */
    public function getMenuItems(): array
    {
        return $this->menuItems;
    }

    public function getNumMenuItems(): int
    {
        return count($this->menuItems);
    }

    public function render($view): string
    {
        return view($view, [
            'menu' => $this
        ])->render();
    }

    public function buttons(): string
    {
        return $this->render('menu::buttons');
    }

    public function __toString()
    {
        return $this->render('menu::buttons');
    }

    public function setActiveByName(array|string $name): void
    {
        /** @var Menu $menuItem */
        foreach ($this->menuItems as $menuItem) {
            $menuItem->setActiveByName($name);
        }
    }

    public function toArray(): array
    {
        $items = [];
        /** @var MenuItem $menuItem */
        foreach ($this->menuItems as $menuItem) {
            $items[] = $menuItem->toArray();
        }

        return $items;
    }
}
