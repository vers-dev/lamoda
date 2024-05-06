# Путь к файлу .env.example
ENV_EXAMPLE_FILE := .env.example
# Путь к файлу .env
ENV_FILE := .env

PHP_CONTAINER := app

# Команда для поднятия контейнеров Docker
up: copy-env
	@docker-compose up -d
	@docker-compose exec $(PHP_CONTAINER) composer install
	@docker-compose exec $(PHP_CONTAINER) php artisan key:generate
	@docker-compose exec $(PHP_CONTAINER) php artisan migrate
	@docker-compose exec $(PHP_CONTAINER) php artisan optimize
	@docker-compose exec $(PHP_CONTAINER) php artisan optimize:clear

copy-env:
	@cp -n $(ENV_EXAMPLE_FILE) $(ENV_FILE)

down:
	@docker-compose down

test:
	@docker-compose exec $(PHP_CONTAINER) php artisan test
