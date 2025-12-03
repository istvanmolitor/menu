<?php

declare(strict_types=1);

namespace Molitor\Menu\Tests\Unit;

use Molitor\Menu\Services\MenuItem;
use Tests\TestCase;

class MenuItemTest extends TestCase
{
    public function test_can_create_menu_item_with_label(): void
    {
        $menuItem = new MenuItem('Test Label');

        $this->assertEquals('Test Label', $menuItem->getLabel());
    }

    public function test_can_set_and_get_name(): void
    {
        $menuItem = new MenuItem('Test');
        $menuItem->setName('test-name');

        $this->assertEquals('test-name', $menuItem->getName());
    }

    public function test_name_is_null_by_default(): void
    {
        $menuItem = new MenuItem('Test');

        $this->assertNull($menuItem->getName());
    }

    public function test_can_set_and_get_label(): void
    {
        $menuItem = new MenuItem('Original Label');
        $menuItem->setLabel('New Label');

        $this->assertEquals('New Label', $menuItem->getLabel());
    }

    public function test_can_set_and_get_url(): void
    {
        $menuItem = new MenuItem('Test');
        $menuItem->setUrl('/test-url');

        $this->assertEquals('/test-url', $menuItem->getUrl());
    }

    public function test_url_is_null_by_default(): void
    {
        $menuItem = new MenuItem('Test');

        $this->assertNull($menuItem->getUrl());
    }

    public function test_can_set_and_get_icon(): void
    {
        $menuItem = new MenuItem('Test');
        $menuItem->setIcon('home');

        $this->assertEquals('home', $menuItem->getIcon());
    }

    public function test_icon_is_null_by_default(): void
    {
        $menuItem = new MenuItem('Test');

        $this->assertNull($menuItem->getIcon());
    }

    public function test_can_set_and_get_is_active(): void
    {
        $menuItem = new MenuItem('Test');
        $menuItem->setIsActive(true);

        $this->assertTrue($menuItem->isActive());
    }

    public function test_is_active_is_false_by_default(): void
    {
        $menuItem = new MenuItem('Test');

        $this->assertFalse($menuItem->isActive());
    }

    public function test_can_set_and_get_is_external(): void
    {
        $menuItem = new MenuItem('Test');
        $menuItem->setIsExternal(true);

        $this->assertTrue($menuItem->isExternal());
    }

    public function test_is_external_is_false_by_default(): void
    {
        $menuItem = new MenuItem('Test');

        $this->assertFalse($menuItem->isExternal());
    }

    public function test_get_by_name_returns_self_when_name_matches(): void
    {
        $menuItem = new MenuItem('Test');
        $menuItem->setName('test-name');

        $found = $menuItem->getByName('test-name');

        $this->assertSame($menuItem, $found);
    }

    public function test_get_by_name_returns_null_when_name_does_not_match(): void
    {
        $menuItem = new MenuItem('Test');
        $menuItem->setName('test-name');

        $found = $menuItem->getByName('other-name');

        $this->assertNull($found);
    }

    public function test_get_by_name_searches_in_children(): void
    {
        $parentItem = new MenuItem('Parent');
        $parentItem->setName('parent');

        $childItem = new MenuItem('Child');
        $childItem->setName('child');

        $parentItem->addMenuItem($childItem);

        $found = $parentItem->getByName('child');

        $this->assertSame($childItem, $found);
    }

    public function test_set_active_by_name_with_string(): void
    {
        $menuItem = new MenuItem('Test');
        $menuItem->setName('test-name');

        $menuItem->setActiveByName('test-name');

        $this->assertTrue($menuItem->isActive());
    }

    public function test_set_active_by_name_with_array(): void
    {
        $menuItem = new MenuItem('Test');
        $menuItem->setName('test-name');

        $menuItem->setActiveByName(['test-name', 'other-name']);

        $this->assertTrue($menuItem->isActive());
    }

    public function test_set_active_by_name_does_not_activate_when_name_does_not_match(): void
    {
        $menuItem = new MenuItem('Test');
        $menuItem->setName('test-name');

        $menuItem->setActiveByName('other-name');

        $this->assertFalse($menuItem->isActive());
    }

    public function test_set_active_by_name_activates_children(): void
    {
        $parentItem = new MenuItem('Parent');
        $parentItem->setName('parent');

        $childItem = new MenuItem('Child');
        $childItem->setName('child');

        $parentItem->addMenuItem($childItem);

        $parentItem->setActiveByName('child');

        $this->assertTrue($childItem->isActive());
    }

    public function test_to_array_returns_correct_structure(): void
    {
        $menuItem = new MenuItem('Test Label');
        $menuItem->setUrl('/test-url');
        $menuItem->setIcon('test-icon');

        $array = $menuItem->toArray();

        $this->assertIsArray($array);
        $this->assertArrayHasKey('title', $array);
        $this->assertArrayHasKey('href', $array);
        $this->assertArrayHasKey('icon', $array);
        $this->assertArrayHasKey('isActive', $array);

        $this->assertEquals('Test Label', $array['title']);
        $this->assertEquals('/test-url', $array['href']);
        $this->assertEquals('test-icon', $array['icon']);
        $this->assertFalse($array['isActive']);
    }

    public function test_to_array_includes_active_state(): void
    {
        $menuItem = new MenuItem('Test Label');
        $menuItem->setIsActive(true);

        $array = $menuItem->toArray();

        $this->assertTrue($array['isActive']);
    }

    public function test_method_chaining_works(): void
    {
        $menuItem = new MenuItem('Test');

        $result = $menuItem
            ->setName('test-name')
            ->setLabel('Test Label')
            ->setUrl('/test')
            ->setIcon('home')
            ->setIsActive(true);

        $this->assertSame($menuItem, $result);
        $this->assertEquals('test-name', $menuItem->getName());
        $this->assertEquals('Test Label', $menuItem->getLabel());
        $this->assertEquals('/test', $menuItem->getUrl());
        $this->assertEquals('home', $menuItem->getIcon());
        $this->assertTrue($menuItem->isActive());
    }

    public function test_menu_item_can_have_children(): void
    {
        $parentItem = new MenuItem('Parent');
        $childItem = new MenuItem('Child');

        $parentItem->addMenuItem($childItem);

        $this->assertEquals(1, $parentItem->count());
        $this->assertContains($childItem, $parentItem->getMenuItems());
    }
}

