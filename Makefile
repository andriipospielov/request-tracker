.PHONY: all run restart rm stop build build_prod ssh ps push

COMPOSE_PROJECT_NAME?=request_tracker
COMPOSE_FILE?=docker/dev/docker-compose.yml
COMPOSE_HTTP_TIMEOUT=86400

all: build run

run:
	docker-compose -p ${COMPOSE_PROJECT_NAME} -f ${COMPOSE_FILE} up -d

restart:
	docker-compose -p ${COMPOSE_PROJECT_NAME} -f ${COMPOSE_FILE} restart -t 0

rm: stop
	docker-compose -p ${COMPOSE_PROJECT_NAME} -f ${COMPOSE_FILE} rm -fv

stop:
	docker-compose -p ${COMPOSE_PROJECT_NAME} -f ${COMPOSE_FILE} stop -t 0

logs:
	docker-compose -p ${COMPOSE_PROJECT_NAME} -f ${COMPOSE_FILE} logs -f ${SERVICE}

build:
	docker-compose -f ${COMPOSE_FILE} build

console:
	docker exec -it ${COMPOSE_PROJECT_NAME}_fpm bash

ps:
	docker-compose -p ${COMPOSE_PROJECT_NAME} -f ${COMPOSE_FILE} ps
