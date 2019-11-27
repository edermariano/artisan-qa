up:
	docker-compose up -d

studocu:
	docker exec -it studocu-cli sh -c "php artisan migrate"
	docker exec -it studocu-cli sh -c "php artisan qanda:interactive"

up-tests:
	docker-compose -f docker-compose.test.yaml up -d --remove-orphans

stop:
	docker-compose  -f docker-compose.test.yaml  -f docker-compose.yaml stop

logs:
	docker-compose  -f docker-compose.test.yaml  -f docker-compose.yaml logs -f

dev:
	docker exec -it studocu-cli-test sh

run-tests:
	docker exec -it studocu-cli-test sh -c "./vendor/bin/phpunit --testdox"

clean:
	make stop
	docker rm -f studocu-cli studocu-cli-test studocu-database studocu-database-test || true
	docker image rm studocu:cli || true
