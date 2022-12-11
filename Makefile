up: docker-up
down: docker-down
restart: docker-down docker-up
build: docker-build
init: docker-down docker-pull docker-build docker-up

logs: docker-logs
log-project: docker-logs-project

docker-up:
	docker-compose up -d

docker-down:
	docker-compose down --remove-orphans

docker-down-clear:
	docker-compose down -v --remove-orphans

docker-pull:
	docker-compose pull

docker-build:
	docker-compose build

docker-logs:
	docker-compose logs

docker-logs-project:
	docker-compose logs -f php

composer-install:
	docker-compose run --rm php composer install

composer-dump-autoload:
	docker-compose run --rm php composer dump-autoload

set-permissions:
	sudo chmod 777 storage

node-install:
	docker-compose run --rm node npm install

node-dev:
	docker-compose run --rm node npm run dev

node-watch:
	docker-compose run --rm node npm run watch

test:
	docker-compose exec php php artisan test

clear-all-cache:
	docker-compose exec php php artisan optimize:clear