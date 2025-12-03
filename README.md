# Menü modul

Ezzel a modullal menüket hozhatsz létre amikre más modulok fel tudnak iratkozni.

## Funkciók

- **Menu**: Menü osztály menüelemek kezelésére
- **MenuItem**: Menüelem osztály tulajdonságokkal (név, címke, URL, ikon, aktív állapot)
- **MenuManager**: Menü builder-ek kezelése és menük építése
- **MenuBuilder**: Absztrakt osztály egyedi menü builder-ek létrehozásához
- **TreeHelper**: Fa struktúrák építése szülő-gyermek kapcsolatokkal

## Használat

### Egyszerű menü létrehozása

```php
use Molitor\Menu\Services\Menu;

$menu = new Menu();
$menu->addItem('Kezdőlap', '/')->setIcon('home');
$menu->addItem('Termékek', '/products')->setIcon('box');
$menu->addItem('Kapcsolat', '/contact')->setIcon('mail');
```

### Menüelem név alapján keresése

```php
$menuItem = new MenuItem('Beállítások');
$menuItem->setName('settings');
$menu->addMenuItem($menuItem);

$found = $menu->getByName('settings');
```

### Aktív elem beállítása

```php
$menu->setActiveByName('settings');
// vagy több elem esetén
$menu->setActiveByName(['products', 'categories']);
```

### Fa struktúra építése

```php
use Molitor\Menu\Services\TreeHelper;

$treeHelper = new TreeHelper();
$treeHelper->addItem(1, null, new MenuItem('Root'));
$treeHelper->addItem(2, 1, new MenuItem('Child 1'));
$treeHelper->addItem(3, 1, new MenuItem('Child 2'));

$menu = $treeHelper->getMenu();
```

### MenuBuilder használata

```php
use Molitor\Menu\Services\MenuBuilder;
use Molitor\Menu\Services\Menu;

class MyMenuBuilder extends MenuBuilder
{
    public function mainMenu(Menu $menu): void
    {
        $menu->addItem('Kezdőlap', '/')->setIcon('home');
        $menu->addItem('Termékek', '/products')->setIcon('box');
    }
}

// config/menu.php
return [
    MyMenuBuilder::class,
];

// Használat
app(MenuManager::class)->mainMenu();
```

## Tesztelés

A modul átfogó unit tesztekkel rendelkezik (65 teszt). A tesztek futtatásához:

```bash
# Összes teszt futtatása
./vendor/bin/sail artisan test

# Csak a menü modul tesztjei
./vendor/bin/sail artisan test --testsuite=Unit

# Csak a menü package tesztjei
./vendor/bin/sail artisan test packages/menu/tests
```

**Megjegyzés:** A tesztek Laravel TestCase-t használnak, ezért Laravel környezetben kell futniuk (sail/artisan test).

További információ: [tests/README.md](tests/README.md)

## Követelmények

- PHP 8.1+
- Laravel 10.x vagy újabb
