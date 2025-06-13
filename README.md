# Menü modul

Ezzel a modullal meüket hozhatsz létre a sablonjaidban amikre más modulok fel tudnak iratkozni.

## Telepítés

### Provider regisztrálása
config/app.php
```php
'providers' => ServiceProvider::defaultProviders()->merge([
    /*
    * Package Service Providers...
    */
    \Molitor\Menu\Providers\MenuServiceProvider::class,
])->toArray(),
```

### Menü kezelő alias regisztrálása
config/app.php
```php
'aliases' => Facade::defaultAliases()->merge([
    'Menu' => \Molitor\Menu\Facades\Menu::class,
])->toArray(),
```

### Config file létrehozása

```shell
php artisan vendor:publish
```
Válaszd a következőt: Molitor\Menu\Providers\MenuServiceProvider