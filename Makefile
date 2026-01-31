.PHONY: help install test quality docker-up docker-down

help:
	@echo "Event Sourcing Toolkit - Commands"
	@echo "  make install    - Install dependencies"
	@echo "  make test       - Run tests"
	@echo "  make quality    - All quality checks"
	@echo "  make docker-up  - Start Docker"

install:
	composer install

test:
	vendor/bin/phpunit

phpstan:
	vendor/bin/phpstan analyse

quality: phpstan test

docker-up:
	docker-compose up -d

docker-down:
	docker-compose down

clean:
	rm -rf vendor coverage
