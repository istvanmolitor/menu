<?php

namespace Molitor\Menu\Tests\Feature;

use Molitor\Menu\Providers\MenuServiceProvider;
use Tests\TestCase;

class PackageSmokeTest extends TestCase
{
    public function test_service_provider_is_loaded(): void
    {
        $this->assertTrue(class_exists(MenuServiceProvider::class));
        $this->assertTrue($this->app->providerIsLoaded(MenuServiceProvider::class));
    }
}

