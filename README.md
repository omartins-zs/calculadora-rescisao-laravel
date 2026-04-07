# Calculadora de Rescisão Trabalhista CLT

Bem-vindo ao projeto **Utilitários Git - Calculadora de Rescisão Trabalhista**. Este é um SaaS grátis e público voltado ao SEO, desenhado para tirar dúvidas reais sobre rescisão trabalhista.

## Arquitetura e Decisões Técnicas
- **Laravel 12 / PHP 8.3:** Backend com motor seguro de cálculo para evitar o vazamento de lógica num SPA, utilizando princípios SOLID via injenção de dependências em Serviços puros em `/app/Services`.
- **Frontend Stack:** Blade + Tailwind CSS (via Vite) + Alpine.js. A calculadora atualiza via AJAX com debounce, para propiciar o máximo de performance. O uso de Blade server-rendered confere grande viés em pontuações de SEO/Core Web Vitals.
- **Banco de Dados:** SQLite nativo habilitado. Apenas utilizado para migrar e (futuramente) salvar rodadas com URLs customizadas que superem as limitações do Base64 encodado via query params.

## Estrutura do App

- **Motor de Regras (`app/Services/`)**
  - Orquestra, injeta, e processa dados.
  - Tabelas de Imposto e FGTS estão encapsuladas e modulares (e.g., `DescontosService.php`).
- **Páginas de SEO (`resources/views/pages/calculadoras/rescisao/`)**
  - Interface base, FAQ integrado, views satélites.

## Como Iniciar Para Desenvolvimento

1. Configure o repositório local e instale as dependências.
   ```bash
   composer install
   npm install
   ```

2. Gere a key do Laravel caso falte.
   ```bash
   php artisan key:generate
   ```

3. Crie e Migre o banco:
   ```bash
   touch database/database.sqlite
   php artisan migrate
   ```

4. Compile o frontend:
   ```bash
   npm run build
   # ou
   npm run dev
   ```

5. Inicialize o servidor PHP:
   ```bash
   php artisan serve
   ```

## Checklist de SEO Incluído
- Título/Meta descriptions únicos via templates (`@yield`).
- JSON-LD injetado no HTML de base da calculadora listando-a como "WebApplication" e "BusinessApplication".
- FAQs originais com seções informativas.

## Testes Reais

Basta rodar no Laravel:
```bash
php artisan test
```

> "Um código bom é como uma boa rescisão, tudo certinho e sem surpresas".
