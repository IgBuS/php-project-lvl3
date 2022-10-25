install:
	composer install

start:
	./vendor/bin/sail up

test:
	./vendor/bin/sail test

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