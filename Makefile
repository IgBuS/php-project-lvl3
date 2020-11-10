install:
	composer install

start:
	vagrant up

restart:
	vagrant reload --provision 

deploy:
	git push heroku

lint:
	composer exec phpcs -- --standard=PSR12 src bin tests
	
lint-fix:
	composer exec phpcbf -- --standard=PSR12 src bin tests