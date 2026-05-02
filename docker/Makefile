MAKEFILE_DIR := $(dir $(abspath $(lastword $(MAKEFILE_LIST))))
PROJECT_NAME := $(notdir $(patsubst %/,%,$(abspath $(MAKEFILE_DIR)/..)))
COMPOSE := COMPOSE_PROJECT_NAME=$(PROJECT_NAME) docker compose -f $(MAKEFILE_DIR)docker-compose.yml
APP := $(COMPOSE) exec app

# Containers
up:
	$(COMPOSE) up -d

down:
	$(COMPOSE) down

destroy:
	$(COMPOSE) down --rmi all --remove-orphans

restart:
	$(COMPOSE) restart

build:
	$(COMPOSE) build

# Shell
bash:
	$(APP) bash

# Laravel
artisan:
	$(APP) php artisan $(args)

migrate:
	$(APP) php artisan migrate

migrate-fresh:
	$(APP) php artisan migrate:fresh --seed

# Composer
composer:
	$(APP) composer $(args)

# NPM
npm:
	$(APP) npm $(args)

npm-build:
	$(APP) npm run build

npm-dev:
	$(APP) npm run dev

# Setup
setup:
	$(APP) composer install
	$(APP) php -r "file_exists('.env') || copy('.env.example', '.env');"
	$(APP) php artisan key:generate
	$(APP) php artisan migrate
	$(APP) npm install
	$(APP) npm run build

.PHONY: up down destroy restart build bash artisan migrate migrate-fresh composer npm npm-build npm-dev setup
