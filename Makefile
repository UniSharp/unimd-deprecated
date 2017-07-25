project=$(shell basename `pwd`)

include .env

init: .env
	composer install
	php artisan key:generate
	make initdb
	yarn install

initdb: .env
	@if [ ${DB_PASSWORD} ]; then\
		echo 'CREATE DATABASE IF NOT EXISTS `${DB_DATABASE}`' | mysql -u${DB_USERNAME} -h${DB_HOST} -p${DB_PASSWORD};\
	else\
		echo 'CREATE DATABASE IF NOT EXISTS `${DB_DATABASE}`' | mysql -u${DB_USERNAME} -h${DB_HOST};\
	fi
	php artisan migrate:refresh --seed

.env:
	@if [ ! -f .env ]; then\
		echo -n 'copy .env.example to .env ...';\
		cp .env.example .env;\
		sed -i -e 's/\(DB_DATABASE=\)homestead/\1${project}/g' .env;\
		echo 'OK';\
	fi

socket:
	php artisan socket:serve

serve:
	php artisan serve --host=0.0.0.0

test:
	vendor/bin/phpunit --coverage-text
	vendor/bin/phpcs --version && echo && vendor/bin/phpcs -p --standard=PSR2 app tests

build:
	./node_modules/.bin/gulp

build-prod:
	./node_modules/.bin/gulp --production

watch: build
	./node_modules/.bin/gulp watch

clean:
	./node_modules/.bin/gulp clean
	rm -rf bower_components node_modules
