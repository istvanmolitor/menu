<?php

declare(strict_types=1);

namespace Molitor\Menu\Tests\Unit;

use Molitor\Menu\Services\Menu;
use Molitor\Menu\Services\MenuItem;
use Tests\TestCase;

class MenuTest extends TestCase
{
    private Menu $menu;

    protected function setUp(): void
    {
        parent::setUp();
        $this->menu = new Menu();
    }

    public function test_can_add_menu_item(): void
    {
        $menuItem = new MenuItem('Test Item');
        $this->menu->addMenuItem($menuItem);

        $this->assertEquals(1, $this->menu->count());
        $this->assertContains($menuItem, $this->menu->getMenuItems());
    }

    public function test_can_add_item_with_label_and_url(): void
    {
        $menuItem = $this->menu->addItem('Home', '/home');

        $this->assertEquals('Home', $menuItem->getLabel());
        $this->assertEquals('/home', $menuItem->getUrl());
        $this->assertEquals(1, $this->menu->count());
    }

    public function test_can_add_item_with_null_url(): void
    {
        $menuItem = $this->menu->addItem('Label', null);

        $this->assertEquals('Label', $menuItem->getLabel());
        $this->assertNull($menuItem->getUrl());
    }

    public function test_can_get_menu_items(): void
    {
        $item1 = new MenuItem('Item 1');
        $item2 = new MenuItem('Item 2');

        $this->menu->addMenuItem($item1);
        $this->menu->addMenuItem($item2);

        $items = $this->menu->getMenuItems();

        $this->assertCount(2, $items);
        $this->assertEquals($item1, $items[0]);
        $this->assertEquals($item2, $items[1]);
    }

    public function test_can_get_by_name(): void
    {
        $menuItem = new MenuItem('Test');
        $menuItem->setName('test-menu');
        $this->menu->addMenuItem($menuItem);

        $found = $this->menu->getByName('test-menu');

        $this->assertSame($menuItem, $found);
    }

    public function test_get_by_name_returns_null_when_not_found(): void
    {
        $found = $this->menu->getByName('non-existent');

        $this->assertNull($found);
    }

    public function test_can_get_nested_item_by_name(): void
    {
        $parentItem = new MenuItem('Parent');
        $parentItem->setName('parent');

        $childItem = new MenuItem('Child');
        $childItem->setName('child');

        $parentItem->addMenuItem($childItem);
        $this->menu->addMenuItem($parentItem);

        $found = $this->menu->getByName('child');

        $this->assertSame($childItem, $found);
    }

    public function test_set_active_by_name_with_string(): void
    {
        $menuItem = new MenuItem('Test');
        $menuItem->setName('test-menu');
        $this->menu->addMenuItem($menuItem);

        $this->menu->setActiveByName('test-menu');

        $this->assertTrue($menuItem->isActive());
    }

    public function test_set_active_by_name_with_array(): void
    {
        $item1 = new MenuItem('Item 1');
        $item1->setName('item-1');

        $item2 = new MenuItem('Item 2');
        $item2->setName('item-2');

        $this->menu->addMenuItem($item1);
        $this->menu->addMenuItem($item2);

        $this->menu->setActiveByName(['item-1', 'item-2']);

        $this->assertTrue($item1->isActive());
        $this->assertTrue($item2->isActive());
    }

    public function test_to_array_returns_correct_structure(): void
    {
        $menuItem = new MenuItem('Test Item');
        $menuItem->setUrl('/test');
        $menuItem->setIcon('test-icon');
        $this->menu->addMenuItem($menuItem);

        $array = $this->menu->toArray();

        $this->assertIsArray($array);
        $this->assertCount(1, $array);
        $this->assertArrayHasKey('title', $array[0]);
        $this->assertEquals('Test Item', $array[0]['title']);
    }

    public function test_count_returns_correct_number(): void
    {
        $this->assertEquals(0, $this->menu->count());

        $this->menu->addMenuItem(new MenuItem('Item 1'));
        $this->assertEquals(1, $this->menu->count());

        $this->menu->addMenuItem(new MenuItem('Item 2'));
        $this->assertEquals(2, $this->menu->count());
    }

    public function test_to_array_with_nested_items(): void
    {
        $parentItem = new MenuItem('Parent');
        $parentItem->setUrl('/parent');

        $childItem = new MenuItem('Child');
        $childItem->setUrl('/child');

        $parentItem->addMenuItem($childItem);
        $this->menu->addMenuItem($parentItem);

        $array = $this->menu->toArray();

        $this->assertCount(1, $array);
        $this->assertEquals('Parent', $array[0]['title']);
    }
}

