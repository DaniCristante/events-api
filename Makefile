CERTS_DIR = .certs
MKCERT = mkcert
docker-ssh =  docker exec -it events-api_php_1 sh -c "$1"
CONSOLE = bin/console

build:
	docker-compose build

up:
	mkdir -p $(CERTS_DIR)
	$(MKCERT) -install
	$(MKCERT) -cert-file $(CERTS_DIR)/certificate.pem -key-file $(CERTS_DIR)/certificate-key.pem localhost
	docker-compose up -d

halt:
	docker-compose stop

ssh-app:
	docker exec -ti events-api_php_1 sh

ssh-database:
	docker exec -it events-api_mysql_1 bash

database-recreate:
	$(call docker-ssh,$(CONSOLE) doctrine:database:drop --force)
	$(call docker-ssh,$(CONSOLE) doctrine:database:create)
	$(call docker-ssh,$(CONSOLE) doctrine:migrations:migrate)
	$(call docker-ssh,$(CONSOLE) doctrine:fixtures:load)

database-diff:
	$(call docker-ssh,$(CONSOLE) doctrine:migrations:diff)

database-migrate:
	$(call docker-ssh,$(CONSOLE) doctrine:migrations:migrate)

database-schema-update:
	$(call docker-ssh,$(CONSOLE) doctrine:schema:update --force)