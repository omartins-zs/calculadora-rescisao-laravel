# 📗 Como Executar (Local)

Este guia descreve os passos para rodar a aplicação nativamente no seu sistema (sem Docker).
O projeto utiliza a stack **Laravel + PostgreSQL + Redis + Vite (Node.js)**. 

*(Atenção: É necessário você já ter PHP, Composer, Node.js, PostgreSQL e Redis instalados localmente).*

## 1) Preparar ambiente

1. Crie uma cópia do arquivo de configuração de exemplo:
   ```bash
   cp .env.example .env
   ```
2. Abra o arquivo `.env` gerado e ative o **bloco Local** (configure `DB_HOST=127.0.0.1`, `REDIS_HOST=127.0.0.1` e informe suas credenciais locais do seu banco de dados PostgreSQL).

## 2) Instalar dependências

Em seu terminal, instale os pacotes do PHP e Javascript:

**Laravel (Backend):**
```bash
composer install
```

**Node (Frontend / Vite):**
```bash
npm install
```

## 3) Inicialização e Migrações

No primeiro uso, gere a chave de segurança da aplicação e rode as migrações do banco (verifique se já tem um banco de dados criado localmente que corresponda ao `DB_DATABASE` no seu `.env`):

```bash
php artisan key:generate
php artisan migrate
```

## 4) Rodar aplicação

Para que tanto a API/Views do Laravel quanto os assets do frontend funcionem, você precisará de dois terminais abertos simultaneamente.

**Terminal 1 (Backend - Laravel):**
```bash
php artisan serve
```

**Terminal 2 (Frontend - Node/Vite):**
```bash
npm run dev
```

## 5) Filas / Workers (se aplicável)

Caso sua aplicação esteja despachando jobs localmente pelo Laravel, abra um terceiro terminal e rode:

```bash
php artisan queue:work
```

## 6) URLs

- **App Local (Laravel):** [http://localhost:8000](http://localhost:8000) *(ou a porta informada pelo artisan serve)*
- **Assets / Vite:** Normalmente em [http://localhost:5173](http://localhost:5173) (rodam sob o site local em modo de desenvolvimento)
