# 📘 Como Executar (Docker)

Este guia descreve os passos para rodar a aplicação em um ambiente Dockerizado. 
O projeto utiliza a stack **Laravel + PostgreSQL + Redis + Vite (Node.js)**.

## 1) Preparar ambiente

Antes de iniciar os containers, configure as variáveis de ambiente:

1. Faça uma cópia do arquivo de configuração de exemplo:
   ```bash
   cp .env.example .env
   ```
2. Abra o arquivo `.env` gerado e ative o **bloco Docker** (certifique-se de que variáveis como `DB_HOST` e `REDIS_HOST` estejam apontando para os serviços corretos do docker-compose: `db` e `redis`, respectivamente).

## 2) Subir containers

Baixe as imagens, construa os serviços e rode-os em segundo plano:

```bash
docker compose up -d --build
```

## 3) Inicialização

Com os containers em execução, acesse o container principal (`app`) ou envie os comandos diretamente para ele a fim de instalar as dependências e preparar a aplicação:

**Backend (Laravel):**
```bash
docker compose exec app composer install
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate
```

**Frontend (Node / Vite):**
```bash
docker compose exec app npm install
docker compose exec app npm run build
```

## 4) Acessos

Os serviços estarão disponíveis nos seguintes endereços/portas:

- **URL da aplicação:** [http://localhost:8000](http://localhost:8000)
- **Banco de Dados (PostgreSQL):** `localhost:5432` 
- **Redis:** `localhost:6379`

## 5) Logs

Para acompanhar em tempo real os registros de todos os containers (útil para debugar erros no servidor ou no banco de dados):

```bash
docker compose logs -f
```
