studocu:
	make up
	docker exec -it studocu-cli sh -c "php artisan migrate"
	docker exec -it studocu-cli sh -c "php artisan qanda:interactive"

reset-progress:
	make up
	docker exec -it studocu-cli sh -c "php artisan qanda:reset"

run-tests:
	make up-tests
	docker exec -it studocu-cli-test sh -c "./vendor/bin/phpunit --testdox"

clean:
	make stop
	docker rm -f studocu-cli studocu-cli-test studocu-database studocu-database-test || true
	docker image rm studocu:cli || true

dev:
	docker exec -it studocu-cli-test sh

all:
	make run-tests
	make studocu

stop:
	docker-compose  -f docker-compose.test.yaml  -f docker-compose.yaml stop

logs:
	docker-compose  -f docker-compose.test.yaml  -f docker-compose.yaml logs -f

up:
	docker-compose up -d --remove-orphans

up-tests:
	docker-compose -f docker-compose.test.yaml up -d --remove-orphans

