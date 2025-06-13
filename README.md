# Menü modul

Ezzel a modullal meüket hozhatsz létre amikre más modulok fel tudnak iratkozni.

## Telepítés

### Provider regisztrálása
bootstrap/providers.php
```php
return [
    \Molitor\Menu\Providers\MenuServiceProvider::class,
];
```

### Config file létrehozása

```shell
php artisan vendor:publish
```
Válaszd a következőt: Molitor\Menu\Providers\MenuServiceProvider

Az így publikált config/menu.php fileban felsorolhatod a menu builder osztályokat amik felépítik a menüket.
