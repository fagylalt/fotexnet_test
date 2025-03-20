### Fotexnet Teszt feladat

Kedves olvasó! 

A tesztet az alábbi módon tudod elindítani:

1. Klónozd le a repót a saját gépedre.
2. Az .env_example fájl alapján készíts egy sima .env fájlt, majd töltsd ki az általad választott értékekkel, az app key az egyetlen, amelyet artisannal kell generálni:  ```php artisan key:generate```
2. A repó mappájában futtass egy ```bash touch database/database.sqlite``` majd egy ```composer install``` parancsot
3. Ezek után futtasd a ```docker compose build ``` parancsot, ami a docker/Dockerfile alapján elkészíti az image-t
4. Futtasd a ```docker compose up``` parancsot, ami elindítja a konténert
5. A konténerben futtass egy ```php artisan migrate:fresh --seed``` parancsot, ami létrehozza az adatbázist és a táblákat
6. A teszteket a következő paranccsal tudod futtatni: ```php artisan test```


A böngészőben a https://localhost címen fogod tudni elérni az alkalmazást, a swaggeres dokumentáció pedig a https://localhost/api/documentation címen érhető el.

Abban az esetben, ha az api dokumentáció nem generálódna le magától, a következő paranccsal lehet legenerálni azt: ```php artisan l5-swagger:generate ```

Köszönöm a feladat átnézésére fordított idődet, és remélem, elnyeri tetszésed a megoldás!