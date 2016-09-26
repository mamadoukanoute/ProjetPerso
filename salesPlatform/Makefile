.PHONY: start
init:
	composer update
	php bin/console doctrine:schema:update --dump-sql
	php bin/console doctrine:schema:update --force
	chmod 777 -R var/cache
	chmod 777 -R var/logs
	chmod 777 -R var/sessions
	rm -rf var/cache/*
	rm -rf var/log/*
	rm -rf var/sessions/*
start: 
	php bin/console server:start
	cd client && grunt serve

	