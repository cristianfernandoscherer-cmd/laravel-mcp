.PHONY: help up down build rebuild shell logs artisan test inspector clean

up: ## Inicia os containers
	docker compose up -d

down: ## Para os containers
	docker compose down

build: ## Constrói as imagens Docker
	docker compose build

rebuild: ## Reconstrói as imagens e reinicia os containers
	docker compose down
	docker compose build --no-cache
	docker compose up -d

shell: ## Acessa o shell do container Laravel
	docker compose exec laravel bash

logs: ## Mostra os logs do container Laravel
	docker compose logs -f laravel

test: ## Executa os testes
	docker compose exec laravel php artisan test

test-mcp: ## Executa apenas os testes do MCP
	docker compose exec laravel php artisan test --filter=Mcp

test-unit: ## Executa apenas os testes unitários
	docker compose exec laravel php artisan test --testsuite=Unit

test-coverage: ## Executa os testes com coverage
	docker compose exec laravel vendor/bin/phpunit --coverage-html coverage

inspector: ## Inicia o MCP Inspector (executa no host)
	@echo "🚀 Iniciando MCP Inspector..."
	@echo "📍 Acesse: http://localhost:6274"
	@echo "⚠️  Mantenha este terminal aberto. Pressione Ctrl+C para parar."
	@npx @modelcontextprotocol/inspector --transport http --server-url http://localhost:8000/mcp/expense

clean: ## Remove containers, volumes e imagens
	docker compose down -v
	docker system prune -f

install: ## Instala dependências do Composer
	docker compose exec laravel composer install

migrate: ## Executa as migrations
	docker compose exec laravel php artisan migrate

migrate-fresh: ## Recria o banco de dados
	docker compose exec laravel php artisan migrate:fresh --seed

routes: ## Lista todas as rotas
	docker compose exec laravel php artisan route:list

cache-clear: ## Limpa todos os caches
	docker compose exec laravel php artisan cache:clear
	docker compose exec laravel php artisan config:clear
	docker compose exec laravel php artisan route:clear
	docker compose exec laravel php artisan view:clear
