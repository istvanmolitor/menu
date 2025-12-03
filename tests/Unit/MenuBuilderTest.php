<?php

declare(strict_types=1);

namespace Molitor\Menu\Tests\Unit;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;
use Molitor\Menu\Services\Menu;
use Molitor\Menu\Services\MenuBuilder;
use Tests\TestCase;

class ConcreteMenuBuilder extends MenuBuilder
{
    public function customMenu(Menu $menu): void
    {
        $menu->addItem('Custom Item', '/custom');
    }

    public function init(Menu $menu, string $name, array $params = []): void
    {
        if ($name === 'initialized') {
            $menu->addItem('Initialized', '/init');
        }
    }
}

class MenuBuilderTest extends TestCase
{
    private MenuBuilder $menuBuilder;

    protected function setUp(): void
    {
        parent::setUp();
        $this->menuBuilder = new ConcreteMenuBuilder();
    }

    public function test_can_create_menu_builder(): void
    {
        $this->assertInstanceOf(MenuBuilder::class, $this->menuBuilder);
    }

    public function test_init_method_exists_and_is_callable(): void
    {
        $menu = new Menu();

        $this->menuBuilder->init($menu, 'test');

        // Default init does nothing, so menu should be empty
        $this->assertEquals(0, $menu->count());
    }

    public function test_init_can_be_overridden(): void
    {
        $menu = new Menu();

        $this->menuBuilder->init($menu, 'initialized');

        $this->assertEquals(1, $menu->count());
        $this->assertEquals('Initialized', $menu->getMenuItems()[0]->getLabel());
    }

    public function test_init_receives_parameters(): void
    {
        $menu = new Menu();
        $params = ['param1' => 'value1', 'param2' => 'value2'];

        $this->menuBuilder->init($menu, 'test', $params);

        $this->assertInstanceOf(Menu::class, $menu);
    }

    public function test_menu_builder_can_be_extended(): void
    {
        $menu = new Menu();

        // Call custom method defined in ConcreteMenuBuilder
        $this->menuBuilder->customMenu($menu);

        $this->assertEquals(1, $menu->count());
        $this->assertEquals('Custom Item', $menu->getMenuItems()[0]->getLabel());
    }
}

