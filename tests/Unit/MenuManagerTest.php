<?php

declare(strict_types=1);

namespace Molitor\Menu\Tests\Unit;

use Illuminate\Support\Facades\Config;
use Molitor\Menu\Services\Menu;
use Molitor\Menu\Services\MenuBuilder;
use Molitor\Menu\Services\MenuManager;
use Tests\TestCase;

class TestMenuBuilder extends MenuBuilder
{
    public function testMenu(Menu $menu): void
    {
        $menu->addItem('Test Item 1', '/test1');
        $menu->addItem('Test Item 2', '/test2');
    }

    public function anotherMenu(Menu $menu, string $param): void
    {
        $menu->addItem('Another Item', '/another/' . $param);
    }

    public function init(Menu $menu, string $name, array $params = []): void
    {
        $menu->addItem('Init Item', '/init');
    }
}

class MenuManagerTest extends TestCase
{
    private MenuManager $menuManager;

    protected function setUp(): void
    {
        parent::setUp();
        Config::set('menu', []);
        $this->menuManager = new MenuManager();
    }

    public function test_can_add_menu_builder(): void
    {
        $builder = new TestMenuBuilder();
        $this->menuManager->addMenuBuilder($builder);

        $this->assertInstanceOf(MenuManager::class, $this->menuManager);
    }

    public function test_build_creates_menu(): void
    {
        $builder = new TestMenuBuilder();
        $this->menuManager->addMenuBuilder($builder);

        $menu = $this->menuManager->build('testMenu');

        $this->assertInstanceOf(Menu::class, $menu);
    }

    public function test_build_calls_init_method(): void
    {
        $builder = new TestMenuBuilder();
        $this->menuManager->addMenuBuilder($builder);

        $menu = $this->menuManager->build('someMenu');

        // Init method should add 'Init Item'
        $items = $menu->getMenuItems();
        $this->assertCount(1, $items);
        $this->assertEquals('Init Item', $items[0]->getLabel());
    }

    public function test_build_calls_named_method_if_exists(): void
    {
        $builder = new TestMenuBuilder();
        $this->menuManager->addMenuBuilder($builder);

        $menu = $this->menuManager->build('testMenu');

        $items = $menu->getMenuItems();
        // Init + testMenu method
        $this->assertCount(3, $items);
        $this->assertEquals('Init Item', $items[0]->getLabel());
        $this->assertEquals('Test Item 1', $items[1]->getLabel());
        $this->assertEquals('Test Item 2', $items[2]->getLabel());
    }

    public function test_build_does_not_fail_if_method_does_not_exist(): void
    {
        $builder = new TestMenuBuilder();
        $this->menuManager->addMenuBuilder($builder);

        $menu = $this->menuManager->build('nonExistentMenu');

        // Should only have init item
        $this->assertEquals(1, $menu->count());
    }

    public function test_build_passes_parameters_to_method(): void
    {
        $builder = new TestMenuBuilder();
        $this->menuManager->addMenuBuilder($builder);

        $menu = $this->menuManager->build('anotherMenu', ['test-param']);

        $items = $menu->getMenuItems();
        $this->assertCount(2, $items);
        $this->assertEquals('Another Item', $items[1]->getLabel());
        $this->assertEquals('/another/test-param', $items[1]->getUrl());
    }

    public function test_magic_call_method_builds_menu(): void
    {
        $builder = new TestMenuBuilder();
        $this->menuManager->addMenuBuilder($builder);

        $menu = $this->menuManager->testMenu();

        $this->assertInstanceOf(Menu::class, $menu);
        $this->assertEquals(3, $menu->count());
    }

    public function test_magic_call_method_passes_arguments(): void
    {
        $builder = new TestMenuBuilder();
        $this->menuManager->addMenuBuilder($builder);

        $menu = $this->menuManager->anotherMenu('magic-param');

        $items = $menu->getMenuItems();
        $this->assertEquals('/another/magic-param', $items[1]->getUrl());
    }

    public function test_multiple_builders_are_called(): void
    {
        $builder1 = new TestMenuBuilder();
        $builder2 = new class extends MenuBuilder {
            public function testMenu(Menu $menu): void
            {
                $menu->addItem('Builder 2 Item', '/builder2');
            }
        };

        $this->menuManager->addMenuBuilder($builder1);
        $this->menuManager->addMenuBuilder($builder2);

        $menu = $this->menuManager->build('testMenu');

        // Init from builder1, testMenu from builder1, init from builder2, testMenu from builder2
        $this->assertEquals(4, $menu->count());
    }
}

