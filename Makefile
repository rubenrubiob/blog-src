.DEFAULT_GOAL := help

current-dir := $(dir $(abspath $(lastword $(MAKEFILE_LIST))))

composer-install:
	@docker exec blog-src-php sh -c "composer install"

unit-test: ## Execute phpunit unit test
	@echo "============================"
	@echo "Executing Unit Test"
	@echo "============================"
	@docker exec blog-src-php sh -c "php ./vendor/bin/phpunit -c phpunit.xml.dist --testsuite Unit"

functional-test: ## Execute phpunit unit test
	@echo "============================"
	@echo "Executing Functional Test"
	@echo "============================"
	@docker exec blog-src-php sh -c "php ./vendor/bin/phpunit -c phpunit.xml.dist --testsuite Functional"

test: unit-test functional-test

check-code-style:
	@docker exec blog-src-php sh -c "vendor/bin/phpcs"

phpstan: ## Execute PHPStan
	@docker exec blog-src-php sh -c "vendor/bin/phpstan analyse"

psalm: ## Execute Psalm
	@docker exec blog-src-php sh -c "vendor/bin/psalm --no-cache"

infection: ## Execute infection
	@docker exec blog-src-php sh -c "infection --threads=max --min-msi=100 --test-framework-options=\"--testsuite=Unit\""

quality: phpstan psalm infection

symfony-lint-container:
	@docker exec blog-src sh -c "XDEBUG_MODE=off bin/console lint:container"

symfony-lint-yaml:
	@docker exec blog-src sh -c "XDEBUG_MODE=off bin/console lint:yaml config src"

# Docker Compose
start: CMD=up
startd: CMD=up -d
stop: CMD=stop
destroy: CMD=down

start startd stop destroy:
	@docker-compose $(CMD)

bash: ## jump in an interactive shell inside the running sandbox
	@docker exec -it blog-src-php bash
