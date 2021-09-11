CERTS_DIR = .certs
MKCERT = mkcert

build:
	docker-compose build

up:
	mkdir -p $(CERTS_DIR)
	$(MKCERT) -install
	$(MKCERT) -cert-file $(CERTS_DIR)/certificate.pem -key-file $(CERTS_DIR)/certificate-key.pem localhost
	docker-compose up -d

halt:
	docker-compose stop

ssh:
	docker exec -ti events-api_php_1 sh

database:
	docker exec -it events-api_mysql_1 bash

nginx:
	docker exec -it events-api_web_1 bin/bash	