install:
	composer install

install-test:
	composer install --no-scripts

start:
	./vendor/bin/sail up

ci-test:
	vendor/bin/phpunit tests/

test:
	./vendor/bin/sail test

setup:
	cp .env.ci .env
	php artisan key:generate

migrate:
	php artisan migrate

restart:
	vagrant reload --provision 

deploy:
	git push heroku

lint:
	composer exec phpcs -- --standard=PSR12 app tests database routes resources
	
lint-fix:
	composer exec phpcbf -- --standard=PSR12 app tests database routes resources

build:
	npm run build
	./vendor/bin/sail artisan optimize
	./vendor/bin/sail artisan migrate

phpstan:
	composer exec phpstan