up:
	docker-compose up -d

stop:
	docker-compose stop

logs:
	docker-compose logs -f

studocu:
	docker exec -it studocu-cli sh

clean:
	docker rm studocu-cli studocu-database
	docker image rm studocu:cli
