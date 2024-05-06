# Путь к файлу .env.example
ENV_EXAMPLE_FILE := .env.example
# Путь к файлу .env
ENV_FILE := .env

PHP_CONTAINER := lamoda-php

# Команда для поднятия контейнеров Docker
up: copy-env composer-install
	@docker-compose up -d
	@artisan key:generate
	@artisan migrate
	@artisan oprimize
	@artisan oprimize:clear

copy-env:
	@cp -n $(ENV_EXAMPLE_FILE) $(ENV_FILE)

composer-install:
	@docker-compose run --rm $(PHP_CONTAINER) composer install

down:
	@docker-compose down

artisan:
	@docker-compose exec $(PHP_CONTAINER) php artisan $(filter-out $@,$(MAKECMDGOALS))

# Обрабатываем переданные аргументы для artisan
%:
    @:
