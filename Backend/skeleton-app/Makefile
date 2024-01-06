APP_CONTAINER_NAME := app_example
MYSQL_CONTAINER_NAME := db_example
MYSQL_TEST_CONTAINER_NAME := db_test_example
REDIS_CONTAINER_NAME := cache_example

build:
	docker-compose build

start:
	docker-compose -f docker-compose.yml -f docker-compose.local.yml up -d

stop:
	docker-compose -f docker-compose.yml -f docker-compose.local.yml down

restart:
	docker-compose -f docker-compose.yml -f docker-compose.local.yml restart

enter:
	docker exec -ti --user php-app $(APP_CONTAINER_NAME) /bin/bash

enter_db:
	docker exec -ti $(MYSQL_CONTAINER_NAME) bash

enter_db_test:
	docker exec -ti $(MYSQL_TEST_CONTAINER_NAME) bash

enter_redis:
	docker exec -ti $(REDIS_CONTAINER_NAME) redis-cli

logs:
	docker-compose exec -u php-app $(APP_CONTAINER_NAME) tail -n 100 -f storage/logs/laravel.log

ecs:
	docker exec --user php-app $(APP_CONTAINER_NAME) /bin/bash -c "php vendor/bin/ecs check --config=ecs.php"

rector:
	docker exec --user php-app $(APP_CONTAINER_NAME) /bin/bash -c "php vendor/bin/rector process --config=rector.php"

rector-dry-run:
	docker exec --user php-app $(APP_CONTAINER_NAME) /bin/bash -c "php vendor/bin/rector process --dry-run --config=rector.php"

pint:
	docker exec --user php-app $(APP_CONTAINER_NAME) /bin/bash -c "php vendor/bin/pint"

run-tests:
	docker exec --user php-app $(APP_CONTAINER_NAME) /bin/bash -c "php artisan test --parallel"

before-push:
	make pint
	make rector
	make ecs
	make run-tests
