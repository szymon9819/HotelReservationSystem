
# Docker Linkasoarus

### Kontenery
- php [ php7.4.19:alpine ]
- nginx [ nginx:lastest ]
- mysql [ mysql:5.7 ]
- redis [ redis:alpine:alpine ]
- phpmyadmin [ phpmyadmin:5.0.1 ]
- mailhog [ mailhog:lastest ]
- npm [ node:14.16.1 ]


### Setup
- `git clone git@github.com:AKRAPolska/social-automation.git`
- `cd [folder z projektem]`
- `make build`
- `make start_local`
- `make enter`
- `composer install`
- `php artisan migrate`
- `php artisan db:seed`

Różnica między `make start` a `make start_local`polega na tym, że `make start_local`
posiada podpięte volumy do poszczególnych kontenerów. Np dzięki temu dane w bazie mysql nie zostaną
utracone po usunięciu kontenera, ponieważ zapiszą się lokalnie. Dodatkowo kontener npm uruchamia się z opcją
`npm install && npm run watch`.

### Opis

#### kontener php
Obraz php został stworzony przy pomocy multi stage, aby zmniejszyć jego rozmiar.
Zmienna środowiskowa obrazu php `$VERSION_TYPE` użyta jest w skrypcie uruchamianym
podczas startu kontenera. Skrypt odpowiedzialny jest za ustanowienie odpowiedniego
pliki php.ini (production lub development).
Volume odpowiada za przekopiowanie zawartości katalogu projektu do kontenera.

Obraz php zawiera rozszerzenia:
- redis
- pcntl
- pdo
- pdo_mysql
- gd
- zip

#### kontener nginx
jest zależny od kontenera php i mysql. To znaczy, że uruchomi się po tym
jak powstanie kontener php oraz mysql. Działa na porcie 80. Podpięto do niego dwa volumes:
1. odpowiada za przekopiowanie zawartości katalogu projektu do konetera
1. nadpisuje domyślną konfigurację


#### kontener mysql
działa na porcie 3306. Podpięto do niego dwa volumes:
1. zapobiega utracie danych po wyłączeniu kontenera, ponieważ zapisują się w pamięci komputera
1. nadpisuje  config


#### kontener redis
działa na porcie 6379.


#### kontener phpmyadmin
działa na porcie 8081


#### kontener mailhog
działa na portach: 1025, 8025.


#### kontener npm
działa na portach: 1025, 8025. Podczas uruchamiania kontenera wykonywane są dwie komendy:
1. `npm install`
1. `npm run watch`
Podpięto do niego jeden volume dzięki, któremu zainstalowane paczki pojawią się w projekcie


### Makefile
Jest to plik ułatwiający pracę z kompilacją i budowaniem projektu.  
W tym przypadku ułatwia uruchamianie środowiska przygotowanego do aplikacji.

| Polecenie  |                                                                                                                                                                                               Uruchomienie polecenia                                                                                                                                                                                               |                                          Działanie                                                  |
|---------------------|:-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------:|:-------------------------------------------------------------------------------------------:|
| `make build`        |                                                                                                                                                                                               `docker-compose build`                                                                                                                                                                                              | buduje obrazy                                                                               |
| `make start`        |                                                                                                                                                                                               `docker-compose up -d`                                                                                                                                                                                              | uruchamia kontenery z pliku docker-compose.yml                                              |
| `make start_local`  |                                                                                                                                                                  `docker-compose -f docker-compose.yml -f`<br />`docker-compose.local.yml up -d`                                                                                                                                                                  | uruchamia kontenery z połączonych plików docker-compose.yml i docker-compose.local.yml      |
| `make stop`         |                                                                                                                                                                  `docker-compose -f docker-compose.yml -f`<br />`docker-compose.local.yml up -d`                                                                                                                                                                  | zatrzymuje i usuwa kontenery                                                                |
| `make restart`      |                                                                                                                                                                  `docker-compose -f docker-compose.yml -f`<br />`docker-compose.local.yml up -d`                                                                                                                                                                  | restartuje kontenery                                                                        |
| `make enter`        |                                                                                                                                                                                          `docker exec -ti php /bin/bash`                                                                                                                                                                                          | pozwala wejść do konsoli kontenera o nazwie php                                             |
| `make enter_db`     |                                                                                                                                                                                     `docker exec -ti linkasoarus_mysql bash`                                                                                                                                                                                      | pozwala wejść do konsoli kontenera o nazwie linkasoarus_mysql, w którym jest baza danych    |
| `make enter_npm`    |                                                                                                                                                                                     `docker exec -ti linkasoarus_npm bash`                                                                                                                                                                                        | pozwala wejść do konsoli kontenera o nazwie linkasoarus_npm, w którym jest npm              |
| `make enter_redis`  |                                                                                                                                                                                  `docker exec -ti application_redis_1 redis-cli`                                                                                                                                                                                  | pozwala wejść do konsoli kontenera o nazwie linkasoarus_redis, w którym jest redis          | 
| `make logs`         |                                                                                                                                                                    `docker-compose exec -u php-app php tail -n 100 -f storage/logs/laravel.log`                                                                                                                                                                   | wyświetla logi z kontenera linkasoarus_php                                                  |

