run: build up composer-install migrate generate-keypair load-fixtures

build:
	docker compose build app --no-cache

up:
	docker compose up -d

composer-install:
	docker compose exec app composer install

generate-keypair:
	docker compose exec app php bin/console lexik:jwt:generate-keypair --skip-if-exists

migrate:
	docker compose exec app php bin/console doctrine:migrations:migrate --no-interaction;

load-fixtures:
	docker compose exec app php bin/console doctrine:fixtures:load --no-interaction;

down:
	docker compose down

remove-image:
	docker rmi product-distribution-api --force

clean: down remove-image

logs:
	docker compose logs nginx

pause:
	docker compose pause

unpause:
	docker compose unpause

cleanup:
	rm -rf vendor database && mkdir database && touch database/.gitignore

.PHONY: run build up composer-install generate-keypair migrate load-fixtures down remove-image clean logs pause unpause
