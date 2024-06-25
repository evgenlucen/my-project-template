##################
# Variables
##################

DOCKER_COMPOSE = docker compose -f ./docker/docker-compose.yml --env-file ./docker/.env
DOCKER_COMPOSE_PHP_FPM_EXEC = ${DOCKER_COMPOSE} exec -u www-data php-fpm
PROJECT_NAME = project_name


init: init-ci
init-ci: docker-down-clear \
	api-clear \
	build up \
	api-init \
	api-ready \
	queues

docker-down-clear: create-env-file create-docker-compose-file
	${DOCKER_COMPOSE} down -v --remove-orphans

#docker-env:
#	cp -n ./docker/.env.dist ./docker/.env

##################
# Queues
##################
queues:
	${DOCKER_COMPOSE} run --rm php-cli bin/console messenger:setup-transports
##################
# API
##################
api-clear:
	docker run --rm -v ${PWD}/.:/app -w /. alpine sh -c 'rm -rf var/cache/* var/log/* var/test/*'

api-init: api-permissions api-composer-install api-wait-db api-migrations # api-fixtures

api-wait-db:
	${DOCKER_COMPOSE} run --rm php-cli wait-for-it postgres:5432 -t 30

api-ready:
	docker run --rm -v ${PWD}/.:/app -w /. alpine touch .ready

api-migrations:
	${DOCKER_COMPOSE} run --rm php-cli bin/console doctrine:migrations:migrate --no-interaction

api-restart-consumers:
	${DOCKER_COMPOSE} restart api-event-consumer

api-permissions:
	docker run --rm -v ${PWD}/.:/app -w /. alpine mkdir vendor && mkdir -p var/cache var/test && chmod 777 var/cache var/log

api-composer-install:
	${DOCKER_COMPOSE} run --rm php-cli composer install

api-cs-fix:
	${DOCKER_COMPOSE} run --rm php-cli composer php-cs-fixer-fix

api-cs-check:
	${DOCKER_COMPOSE} run --rm php-cli composer php-cs-fixer

api-phpstan:
	${DOCKER_COMPOSE} run --rm php-cli composer phpstan

api-bash:
	${DOCKER_COMPOSE} exec -u www-data php-fpm bash
api-root-bash:
	${DOCKER_COMPOSE} exec -u root php-fpm bash
test:
	${DOCKER_COMPOSE} exec -u www-data php-fpm bin/phpunit
jwt:
	${DOCKER_COMPOSE} exec -u www-data php-fpm bin/console lexik:jwt:generate-keypair
cache-clear:
	docker compose -f ./docker/docker-compose.yml exec -u www-data php-fpm bin/console cache:clear
	docker compose -f ./docker/docker-compose.yml exec -u www-data php-fpm bin/console cache:clear --env=test

##################
# Docker compose
##################
build: create-env-file create-docker-compose-file
	${DOCKER_COMPOSE} build

start:
	${DOCKER_COMPOSE} start

stop:
	${DOCKER_COMPOSE} stop

up: create-env-file create-docker-compose-file
	${DOCKER_COMPOSE} up -d --remove-orphans

ps:
	${DOCKER_COMPOSE} ps

logs:
	${DOCKER_COMPOSE} logs -f

down:
	${DOCKER_COMPOSE} down -v --rmi=all --remove-orphans

restart:
	make dc_stop dc_start

##################
# Database
##################

db_migrate:
	${DOCKER_COMPOSE} exec -u www-data php-cli bin/console doctrine:migrations:migrate --no-interaction
db_diff:
	${DOCKER_COMPOSE} exec -u www-data php-cli bin/console doctrine:migrations:diff --no-interaction
db_drop:
	docker compose -f ./docker/docker-compose.yml exec -u www-data php-clid bin/console doctrine:schema:drop --force


##################
# Static code analysis
##################

phpstan:
	${DOCKER_COMPOSE_PHP_FPM_EXEC} vendor/bin/phpstan analyse src tests -c phpstan.neon

deptrac:
	${DOCKER_COMPOSE_PHP_FPM_EXEC} vendor/bin/deptrac analyze deptrack-modules.yaml
	${DOCKER_COMPOSE_PHP_FPM_EXEC} vendor/bin/deptrac analyze deptrac-modules.yaml

cs_fix:
	${DOCKER_COMPOSE_PHP_FPM_EXEC} vendor/bin/php-cs-fixer fix

cs_fix_diff:
	${DOCKER_COMPOSE_PHP_FPM_EXEC} vendor/bin/php-cs-fixer fix --dry-run --diff

##################
# Service
##################

create-env-file:
	cp -n ./docker/.env.dist ./docker/.env
create-docker-compose-file:
	test -f docker/docker-compose.yml || cp docker/docker-compose.dist.yml docker/docker-compose.yml