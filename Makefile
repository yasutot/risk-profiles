start:
	php -S localhost:8000 -t public

test:
	vendor/bin/phpunit

tinker:
	php artisan tinker
