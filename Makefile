up:
	docker-compose up -d

stop:
	docker-compose stop

logs:
	docker-compose logs -f

dev:
	docker exec -it studocu-cli sh

studocu:
	docker exec -it studocu-cli sh -c "php artisan qanda:interactive"

tests-studocu:
	docker exec -it studocu-cli sh -c "./vendor/bin/phpunit --testdox"

clean:
	make stop
	docker rm studocu-cli studocu-database
	docker image rm studocu:cli
