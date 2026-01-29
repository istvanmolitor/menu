<?php

declare(strict_types=1);

namespace Molitor\Menu\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Molitor\Menu\Services\MenuManager;

class MenuController extends Controller
{
    public function __construct(
        private MenuManager $menuManager
    ) {
    }

    public function show(string $name): JsonResponse
    {
        $menu = $this->menuManager->build($name);

        return response()->json($menu->toArray());
    }
}
