# Laravel MCP - Expense Tracker

Este projeto é uma implementação do **Model Context Protocol (MCP)** utilizando **Laravel 12**. Ele fornece um servidor MCP que expõe ferramentas para gerenciamento de despesas, permitindo que modelos de IA interajam diretamente com o banco de dados da aplicação.

## 🚀 Funcionalidades

O projeto expõe as seguintes ferramentas via MCP:

-   **`AddExpenseTool`**: Adiciona uma nova despesa (descrição e valor).
-   **`ListExpensesTool`**: Lista todas as despesas cadastradas em formato JSON.

## 🛠️ Stack Tecnológica

-   **PHP 8.2+**
-   **Laravel 12**
-   **Model Context Protocol (MCP)**
-   **SQLite** (Banco de dados padrão)
-   **Docker & Sail**
-   **PHPUnit** (Testes unitários)

## 📦 Instalação e Execução

### Usando Docker (Recomendado)

O projeto possui um `Makefile` que simplifica todos os comandos necessários.

1.  **Iniciar os containers:**
    ```bash
    make up
    ```

### Sem Docker

1.  **Instalar dependências:**
    ```bash
    composer install
    ```

2.  **Configurar ambiente:**
    ```bash
    cp .env.example .env
    touch database/database.sqlite
    ```

3.  **Executar migrations:**
    ```bash
    php artisan migrate
    ```

4.  **Iniciar servidor:**
    ```bash
    php artisan serve
    ```

## 🔍 Debugging com MCP Inspector

Para testar as ferramentas e ver como a IA interage com elas, utilize o MCP Inspector:

```bash
make inspector
```
*Acesse o link gerado no terminal (geralmente `http://localhost:6274`).*

## 🧪 Testes

O projeto possui uma suíte de testes unitários robusta para as ferramentas MCP.

```bash
make test          # Roda todos os testes
make test-mcp      # Roda apenas os testes das ferramentas MCP
make test-coverage # Gera relatório de cobertura
```

## ⌨️ Comandos Úteis (Makefile)

-   `make up`: Inicia os containers.
-   `make down`: Para os containers.
-   `make shell`: Acessa o shell do container Laravel.
-   `make logs`: Mostra os logs em tempo real.
-   `make migrate-fresh`: Reinicia o banco de dados e roda os seeders.
-   `make routes`: Lista todas as rotas da aplicação.
-   `make cache-clear`: Limpa todos os caches (config, route, view).

---