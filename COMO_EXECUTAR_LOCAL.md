# 📗 COMO_EXECUTAR_LOCAL.md

## 1) Preparar ambiente

- Copiar o arquivo `.env.example` para `.env`
- Ativar o bloco **Local** no arquivo `.env` (certifique-se de configurar banco SQLite padrão ou PostgreSQL/Redis apontando para `127.0.0.1`).

## 2) Instalar dependências

No terminal do seu SO, instale os pacotes necessários:

**Laravel:**
```bash
composer install
```

**Node:**
```bash
npm install
```

## 3) Rodar aplicação

Inicie o backend e o ambiente de assets do frontend em terminais separados:

**Laravel (Terminal 1):**
```bash
php artisan serve
```

**Node (Terminal 2):**
```bash
npm run dev
```

## 4) Filas / Workers (se existir)

Se a aplicação estiver processando tarefas em background (queues), abra um novo terminal:

**Laravel:**
```bash
php artisan queue:work
```

## 5) URLs

- **App local:** http://localhost:8000
