<?php

declare(strict_types=1);

namespace Molitor\Menu\Tests\Feature;

use Illuminate\Support\Facades\Config;
use Molitor\Menu\Services\Menu;
use Molitor\Menu\Services\MenuBuilder;
use Molitor\Menu\Services\MenuManager;
use Tests\TestCase;

class TestMenuBuilder extends MenuBuilder
{
    public function main(Menu $menu): void
    {
        $menu->addItem('Home', '/');
        $menu->addItem('About', '/about');
    }

    public function init(Menu $menu, string $name, array $params = []): void
    {
    }
}

class MenuControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Regisztráljuk a teszt builder-t
        Config::set('menu', [TestMenuBuilder::class]);

        // Frissítsük a MenuManager-t a konténerben, hogy az új config-ot használja
        $this->app->singleton('menu', function ($app) {
            return new MenuManager();
        });
    }

    public function test_it_returns_menu_as_json(): void
    {
        $response = $this->getJson('/api/menu/main');

        $response->assertStatus(200)
            ->assertJson([
                [
                    'title' => 'Home',
                    'href' => '/',
                ],
                [
                    'title' => 'About',
                    'href' => '/about',
                ],
            ]);
    }

    public function test_it_returns_empty_array_for_non_existent_menu(): void
    {
        $response = $this->getJson('/api/menu/non-existent');

        $response->assertStatus(200)
            ->assertJson([]);
    }
}
