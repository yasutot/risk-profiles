start:
	php -S localhost:8000 -t public

test:
	vendor/bin/phpunit

test-coverage:
	XDEBUG_MODE=coverage vendor/bin/phpunit --coverage-html reports/

tinker:
	php artisan tinker
