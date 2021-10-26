start:
	php -S localhost:8000 -t public

test:
	vendor/bin/phpunit

test-coverage:
	XDEBUG_MODE=coverage vendor/bin/phpunit --coverage-html reports/

tinker:
	php artisan tinker

docker-build:
	docker-compose build

docker-composer-install:
	docker-compose exec app composer install

docker-start:
	docker-compose up -d

make docker-test:
	make docker-start
	docker-compose exec app vendor/bin/phpunit

docker-test-coverage:
	make docker-start
	docker-compose exec app env XDEBUG_MODE=coverage vendor/bin/phpunit --coverage-html reports/
