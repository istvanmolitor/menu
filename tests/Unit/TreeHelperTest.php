<?php

declare(strict_types=1);

namespace Molitor\Menu\Tests\Unit;

use Molitor\Menu\Services\Menu;
use Molitor\Menu\Services\MenuItem;
use Molitor\Menu\Services\TreeHelper;
use PHPUnit\Framework\TestCase;

class TreeHelperTest extends TestCase
{
    private TreeHelper $treeHelper;

    protected function setUp(): void
    {
        parent::setUp();
        $this->treeHelper = new TreeHelper();
    }

    public function test_can_create_tree_helper_without_menu(): void
    {
        $treeHelper = new TreeHelper();

        $this->assertInstanceOf(TreeHelper::class, $treeHelper);
        $this->assertInstanceOf(Menu::class, $treeHelper->getMenu());
    }

    public function test_can_create_tree_helper_with_menu(): void
    {
        $menu = new Menu();
        $treeHelper = new TreeHelper($menu);

        $this->assertSame($menu, $treeHelper->getMenu());
    }

    public function test_can_get_menu(): void
    {
        $menu = $this->treeHelper->getMenu();

        $this->assertInstanceOf(Menu::class, $menu);
    }

    public function test_can_add_root_item(): void
    {
        $menuItem = new MenuItem('Root Item');

        $this->treeHelper->addItem(1, null, $menuItem);

        $menu = $this->treeHelper->getMenu();
        $this->assertEquals(1, $menu->count());
        $this->assertEquals('Root Item', $menu->getMenuItems()[0]->getLabel());
    }

    public function test_can_add_child_item_to_existing_parent(): void
    {
        $parentItem = new MenuItem('Parent');
        $childItem = new MenuItem('Child');

        $this->treeHelper->addItem(1, null, $parentItem);
        $this->treeHelper->addItem(2, 1, $childItem);

        $menu = $this->treeHelper->getMenu();
        $this->assertEquals(1, $menu->count()); // Only parent should be at root

        $parent = $menu->getMenuItems()[0];
        $this->assertEquals(1, $parent->count()); // Parent should have 1 child
        $this->assertEquals('Child', $parent->getMenuItems()[0]->getLabel());
    }

    public function test_can_add_multiple_children_to_parent(): void
    {
        $parentItem = new MenuItem('Parent');
        $child1 = new MenuItem('Child 1');
        $child2 = new MenuItem('Child 2');

        $this->treeHelper->addItem(1, null, $parentItem);
        $this->treeHelper->addItem(2, 1, $child1);
        $this->treeHelper->addItem(3, 1, $child2);

        $parent = $this->treeHelper->getMenu()->getMenuItems()[0];
        $this->assertEquals(2, $parent->count());
    }

    public function test_can_add_nested_children(): void
    {
        $root = new MenuItem('Root');
        $child = new MenuItem('Child');
        $grandChild = new MenuItem('GrandChild');

        $this->treeHelper->addItem(1, null, $root);
        $this->treeHelper->addItem(2, 1, $child);
        $this->treeHelper->addItem(3, 2, $grandChild);

        $menu = $this->treeHelper->getMenu();
        $rootItem = $menu->getMenuItems()[0];
        $childItem = $rootItem->getMenuItems()[0];

        $this->assertEquals(1, $rootItem->count());
        $this->assertEquals('Child', $childItem->getLabel());
        $this->assertEquals(1, $childItem->count());
        $this->assertEquals('GrandChild', $childItem->getMenuItems()[0]->getLabel());
    }

    public function test_handles_child_added_before_parent(): void
    {
        $childItem = new MenuItem('Child');
        $parentItem = new MenuItem('Parent');

        // Add child first, then parent
        $this->treeHelper->addItem(2, 1, $childItem);
        $this->treeHelper->addItem(1, null, $parentItem);

        $menu = $this->treeHelper->getMenu();
        $parent = $menu->getMenuItems()[0];

        $this->assertEquals(1, $menu->count());
        $this->assertEquals('Parent', $parent->getLabel());
        $this->assertEquals(1, $parent->count());
        $this->assertEquals('Child', $parent->getMenuItems()[0]->getLabel());
    }

    public function test_handles_multiple_orphans_added_before_parent(): void
    {
        $child1 = new MenuItem('Child 1');
        $child2 = new MenuItem('Child 2');
        $parent = new MenuItem('Parent');

        // Add children first, then parent
        $this->treeHelper->addItem(2, 1, $child1);
        $this->treeHelper->addItem(3, 1, $child2);
        $this->treeHelper->addItem(1, null, $parent);

        $parentItem = $this->treeHelper->getMenu()->getMenuItems()[0];

        $this->assertEquals(2, $parentItem->count());
    }

    public function test_handles_complex_tree_with_mixed_order(): void
    {
        $root = new MenuItem('Root');
        $child1 = new MenuItem('Child 1');
        $child2 = new MenuItem('Child 2');
        $grandChild = new MenuItem('GrandChild');

        // Add in mixed order: grandchild, root, child1, child2
        $this->treeHelper->addItem(4, 2, $grandChild);
        $this->treeHelper->addItem(1, null, $root);
        $this->treeHelper->addItem(2, 1, $child1);
        $this->treeHelper->addItem(3, 1, $child2);

        $menu = $this->treeHelper->getMenu();
        $rootItem = $menu->getMenuItems()[0];

        $this->assertEquals(1, $menu->count());
        $this->assertEquals(2, $rootItem->count());

        $child1Item = $rootItem->getMenuItems()[0];
        $this->assertEquals('Child 1', $child1Item->getLabel());
        $this->assertEquals(1, $child1Item->count());
        $this->assertEquals('GrandChild', $child1Item->getMenuItems()[0]->getLabel());
    }

    public function test_multiple_root_items(): void
    {
        $root1 = new MenuItem('Root 1');
        $root2 = new MenuItem('Root 2');

        $this->treeHelper->addItem(1, null, $root1);
        $this->treeHelper->addItem(2, null, $root2);

        $menu = $this->treeHelper->getMenu();

        $this->assertEquals(2, $menu->count());
        $this->assertEquals('Root 1', $menu->getMenuItems()[0]->getLabel());
        $this->assertEquals('Root 2', $menu->getMenuItems()[1]->getLabel());
    }

    public function test_can_build_complete_tree_structure(): void
    {
        // Build a tree:
        // Root
        // ├── Category 1
        // │   ├── Item 1.1
        // │   └── Item 1.2
        // └── Category 2
        //     └── Item 2.1

        $root = new MenuItem('Root');
        $cat1 = new MenuItem('Category 1');
        $cat2 = new MenuItem('Category 2');
        $item11 = new MenuItem('Item 1.1');
        $item12 = new MenuItem('Item 1.2');
        $item21 = new MenuItem('Item 2.1');

        $this->treeHelper->addItem(1, null, $root);
        $this->treeHelper->addItem(2, 1, $cat1);
        $this->treeHelper->addItem(3, 1, $cat2);
        $this->treeHelper->addItem(4, 2, $item11);
        $this->treeHelper->addItem(5, 2, $item12);
        $this->treeHelper->addItem(6, 3, $item21);

        $menu = $this->treeHelper->getMenu();
        $rootItem = $menu->getMenuItems()[0];

        $this->assertEquals(1, $menu->count());
        $this->assertEquals(2, $rootItem->count());

        $category1 = $rootItem->getMenuItems()[0];
        $category2 = $rootItem->getMenuItems()[1];

        $this->assertEquals(2, $category1->count());
        $this->assertEquals(1, $category2->count());
    }
}

