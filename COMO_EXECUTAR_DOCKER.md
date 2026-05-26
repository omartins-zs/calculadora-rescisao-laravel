# 📘 COMO_EXECUTAR_DOCKER.md

## 1) Preparar ambiente

- Copiar o arquivo `.env.example` para `.env`
- Ativar o bloco **Docker** no arquivo `.env` (certifique-se de configurar `DB_HOST=db_calculadora` e `REDIS_HOST=redis_calculadora`).

## 2) Subir containers

Baixe as imagens e inicie a aplicação em background:
```bash
docker compose up -d --build
```

## 3) Inicialização

Após os containers subirem com sucesso, execute os comandos de setup do backend e frontend:

**Laravel:**
```bash
docker compose exec app composer install
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate
```

**Node / Vite:**
```bash
docker compose exec app npm install
docker compose exec app npm run build
```

## 4) Acessos

- **URL da aplicação:** http://localhost:8000
- **Banco de Dados (PostgreSQL):** localhost:5432
- **Redis:** localhost:6379

## 5) Logs

Para monitorar os logs da aplicação e dos serviços:
```bash
docker compose logs -f
```
