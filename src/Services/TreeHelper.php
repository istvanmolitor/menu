<?php

namespace Molitor\Menu\Services;

class TreeHelper
{
    protected Menu $menu;

    private array $items = [];

    private array $noParents = [];

    public function __construct(Menu|null $menu = null)
    {
        $this->menu = $menu ?? new Menu();
    }

    public function getMenu(): Menu
    {
        return $this->menu;
    }

    public function addItem(int $id, int|null $parentId, MenuItem $item): void
    {
        if(count($this->noParents) and in_array($id, $this->noParents)) {
            foreach ($this->noParents as $errorId => $errorParentId) {
                if($id === $errorParentId) {
                    $item->addMenuItem($this->items[$errorId]);
                    unset($this->noParents[$errorId]);
                }
            }
        }

        if($parentId === null) {
            $this->menu->addMenuItem($item);
        }
        else  {
            if(array_key_exists($parentId, $this->items)) {
                $this->items[$parentId]->addMenuItem($item);
            }
            else {
                $this->noParents[$id] = $parentId;
            }
        }
        $this->items[$id] = $item;
    }
}
