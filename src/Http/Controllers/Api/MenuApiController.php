<?php

namespace Molitor\Menu\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Molitor\Menu\Services\MenuManager;

class MenuApiController extends Controller
{
    public function __construct(
        private MenuManager $menuManager
    )
    {
    }

    public function show(string $name)
    {
        return$this->menuManager->build($name)->toArray();
    }
}