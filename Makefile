build:
	docker-compose build

up:
	docker-compose up -d

halt:
	docker-compose stop

ssh:
	docker exec -ti events-api_php_1 sh

database:
	docker exec -it events-api_mysql_1 bash