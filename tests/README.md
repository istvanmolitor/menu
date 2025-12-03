# Menu Package Tests

Ez a könyvtár tartalmazza a menü modul unit tesztjeit.

## Tesztek futtatása

A menü modul tesztjeinek futtatásához használd a következő parancsokat a projekt gyökérkönyvtárából:

```bash
# Összes teszt futtatása (beleértve a menü modul tesztjeit)
./vendor/bin/sail artisan test

# Csak Unit tesztek (beleértve a menü modul tesztjeit)
./vendor/bin/sail artisan test --testsuite=Unit

# Specifikusan a menü modul tesztjei
./vendor/bin/sail artisan test packages/menu/tests
```

**Fontos:** A tesztek Laravel TestCase-t használnak, ezért sail/artisan test paranccsal kell futtatni őket, nem pedig közvetlenül phpunit-tal.

## Teszt lefedettség

A tesztek lefedik a következő osztályokat:

### MenuTest (13 teszt)
- Menü létrehozás és alapműveletek
- Menüelemek hozzáadása
- Elemek keresése név alapján
- Aktív elem beállítása
- Tömb reprezentáció

### MenuItemTest (22 teszt)
- Menüelem létrehozás
- Tulajdonságok (név, címke, URL, ikon, stb.) beállítása és lekérdezése
- Aktív állapot kezelése
- Név alapú keresés és aktiválás
- Gyermek elemek kezelése
- Method chaining
- Tömb reprezentáció

### MenuManagerTest (10 teszt)
- MenuBuilder-ek hozzáadása
- Menü építés különböző névvel
- Init metódus hívása
- Dinamikus metódus hívás
- Paraméterek átadása
- Magic call metódus
- Több builder egyidejű használata

### TreeHelperTest (12 teszt)
- Fa struktúra építése
- Gyökér elemek hozzáadása
- Gyermek elemek hozzáadása meglévő szülőhöz
- Több szintű fa struktúra
- Elemek hozzáadása vegyes sorrendben (gyermek a szülő előtt)
- Orphan elemek kezelése
- Komplex fa struktúrák

### MenuBuilderTest (8 teszt)
- MenuBuilder absztrakt osztály használata
- Init metódus működése
- Egyedi builder metódusok

## Teszt struktúra

```
tests/
└── Unit/
    ├── MenuTest.php
    ├── MenuItemTest.php
    ├── MenuManagerTest.php
    ├── TreeHelperTest.php
    └── MenuBuilderTest.php
```

## Követelmények

- PHP 8.1 vagy újabb
- PHPUnit 10.0 vagy újabb
- Laravel komponensek
- Docker (sail környezet)

## Hibaelhárítás

Ha a tesztek nem futnak le:

1. Ellenőrizd, hogy a Docker konténerek futnak: `./vendor/bin/sail ps`
2. Ha nem futnak, indítsd el őket: `./vendor/bin/sail up -d`
3. Próbáld meg újra: `./vendor/bin/sail artisan test`

További részletek a hibajavításokról: [FIX_SUMMARY.md](FIX_SUMMARY.md)

