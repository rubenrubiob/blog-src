.DEFAULT_GOAL := help

current-dir := $(dir $(abspath $(lastword $(MAKEFILE_LIST))))

unit-test: ## Execute phpunit unit test
	@echo "============================"
	@echo "Executing Unit Test"
	@echo "============================"
	@docker exec blog-src-php sh -c "XDEBUG_MODE=off php ./vendor/bin/phpunit -c phpunit.xml.dist --testsuite Unit"

check-code-style: ## verify coding standards are respected
	docker-compose run --rm sandbox vendor/bin/phpcs

phpstan: ## Execute PHPStan
	@docker exec blog-src-php sh -c "XDEBUG_MODE=off vendor/bin/phpstan analyse"

psalm: ## Execute Psalm
	@docker exec blog-src-php sh -c "XDEBUG_MODE=off vendor/bin/psalm"

infection: ## Execute infection
	@docker exec blog-src-php sh -c "XDEBUG_MODE=off infection --threads=max --min-msi=100 --test-framework-options=\"--testsuite=Unit\""

quality: phpstan psalm infection

# Docker Compose
start: CMD=up
startd: CMD=up -d
stop: CMD=stop
destroy: CMD=down

start startd stop destroy:
	@docker-compose $(CMD)

bash: ## jump in an interactive shell inside the running sandbox
	@docker exec -it blog-src-php bash
