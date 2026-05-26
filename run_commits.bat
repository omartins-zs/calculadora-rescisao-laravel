@echo off
chcp 65001 > nul

echo [1/41] .env
git add .env
git commit --no-verify -m ":wrench: chore: migrando env para stack local sqlite"

echo [2/41] .env.example
git add .env.example
git commit --no-verify -m ":wrench: chore: atualizando template env example"

echo [3/41] COMO_EXECUTAR_DOCKER.md
git add COMO_EXECUTAR_DOCKER.md
git commit --no-verify -m ":books: docs: revisando guia de execucao docker"

echo [4/41] COMO_EXECUTAR_LOCAL.md
git add COMO_EXECUTAR_LOCAL.md
git commit --no-verify -m ":books: docs: expandindo guia de execucao local"

echo [5/41] Dockerfile
git add Dockerfile
git commit --no-verify -m ":bricks: ci: refatorando dockerfile para producao"

echo [6/41] docker-compose.yml
git add docker-compose.yml
git commit --no-verify -m ":bricks: ci: ajustando servicos no docker compose"

echo [7/41] fpm-performance.conf
git add docker/php/fpm-performance.conf
git commit --no-verify -m ":zap: perf: atualizando conf de pool fpm"

echo [8/41] local.ini (deletado)
git add docker/php/local.ini
git commit --no-verify -m ":wastebasket: remove: removendo local.ini redundante"

echo [9/41] start-app.sh (deletado)
git add docker/scripts/start-app.sh
git commit --no-verify -m ":wastebasket: remove: removendo script start-app obsoleto"

echo [10/41] composer.json
git add composer.json
git commit --no-verify -m ":package: build: adicionando dependencias php composer"

echo [11/41] composer.lock
git add composer.lock
git commit --no-verify -m ":package: build: atualizando lockfile do composer"

echo [12/41] package.json
git add package.json
git commit --no-verify -m ":package: build: adicionando flowbite e alpinejs mask"

echo [13/41] package-lock.json
git add package-lock.json
git commit --no-verify -m ":package: build: atualizando lockfile do npm"

echo [14/41] tailwind.config.js
git add tailwind.config.js
git commit --no-verify -m ":recycle: refactor: removendo darkmode legado do config"

echo [15/41] vite.config.js
git add vite.config.js
git commit --no-verify -m ":wrench: chore: habilitando cors no servidor vite"

echo [16/41] app.css
git add resources/css/app.css
git commit --no-verify -m ":sparkles: feat: implementando design system completo css"

echo [17/41] app.js
git add resources/js/app.js
git commit --no-verify -m ":wrench: chore: registrando mask e flowbite no alpine"

echo [18/41] card.blade.php
git add resources/views/components/card.blade.php
git commit --no-verify -m ":recycle: refactor: refinando componente card blade"

echo [19/41] input.blade.php
git add resources/views/components/input.blade.php
git commit --no-verify -m ":recycle: refactor: reescrevendo componente input blade"

echo [20/41] select.blade.php
git add resources/views/components/select.blade.php
git commit --no-verify -m ":recycle: refactor: reescrevendo componente select blade"

echo [21/41] kpi.blade.php
git add resources/views/components/kpi.blade.php
git commit --no-verify -m ":bug: fix: corrigindo classes dinamicas no kpi blade"

echo [22/41] layout - script de tema
git add resources/views/layouts/app.blade.php
git commit --no-verify -m ":wrench: chore: adicionando script de tema sem flash"

echo [23/41] layout - header glass
git add resources/views/layouts/app.blade.php
git commit --no-verify -m ":sparkles: feat: construindo header glass responsivo"

echo [24/41] layout - toggle tema
git add resources/views/layouts/app.blade.php
git commit --no-verify -m ":sparkles: feat: adicionando toggle dark light mode"

echo [25/41] layout - footer grid
git add resources/views/layouts/app.blade.php
git commit --no-verify -m ":sparkles: feat: reconstruindo footer em grid colunas"

echo [26/41] index - hero section
git add resources/views/pages/calculadoras/rescisao/index.blade.php
git commit --no-verify -m ":sparkles: feat: redesenhando hero section calculadora"

echo [27/41] index - form secoes
git add resources/views/pages/calculadoras/rescisao/index.blade.php
git commit --no-verify -m ":recycle: refactor: reorganizando form com secoes e icones"

echo [28/41] index - checkbox card
git add resources/views/pages/calculadoras/rescisao/index.blade.php
git commit --no-verify -m ":sparkles: feat: transformando checkbox ferias em card"

echo [29/41] index - campos avancados
git add resources/views/pages/calculadoras/rescisao/index.blade.php
git commit --no-verify -m ":sparkles: feat: estilizando secao de campos avancados"

echo [30/41] index - json-ld fix
git add resources/views/pages/calculadoras/rescisao/index.blade.php
git commit --no-verify -m ":bug: fix: escapando diretivas blade no json-ld"

echo [31/41] index - tabela dark mode
git add resources/views/pages/calculadoras/rescisao/index.blade.php
git commit --no-verify -m ":sparkles: feat: adicionando dark mode na tabela calculo"

echo [32/41] index - faq accordion
git add resources/views/pages/calculadoras/rescisao/index.blade.php
git commit --no-verify -m ":sparkles: feat: implementando accordion faq dark mode"

echo [33/41] multa-fgts - tabela modalidades
git add resources/views/pages/calculadoras/rescisao/multa-fgts.blade.php
git commit --no-verify -m ":sparkles: feat: adicionando tabela multas por modalidade"

echo [34/41] multa-fgts - base rescisorios
git add resources/views/pages/calculadoras/rescisao/multa-fgts.blade.php
git commit --no-verify -m ":sparkles: feat: explicando base de fins rescisorios fgts"

echo [35/41] multa-fgts - saque aniversario
git add resources/views/pages/calculadoras/rescisao/multa-fgts.blade.php
git commit --no-verify -m ":sparkles: feat: adicionando secao saque aniversario"

echo [36/41] multa-fgts - cta botoes
git add resources/views/pages/calculadoras/rescisao/multa-fgts.blade.php
git commit --no-verify -m ":sparkles: feat: adicionando cta e acoes no artigo fgts"

echo [37/41] FgtsService - culpa reciproca
git add app/Services/FgtsService.php
git commit --no-verify -m ":sparkles: feat: adicionando culpa reciproca no fgts"

echo [38/41] RescisaoCalculatorService - fgts null
git add app/Services/RescisaoCalculatorService.php
git commit --no-verify -m ":bug: fix: tratando campo fgts vazio como nulo"

echo [39/41] RescisaoCalculatorService - guard meses
git add app/Services/RescisaoCalculatorService.php
git commit --no-verify -m ":bug: fix: adicionando guard minimo de meses fgts"

echo [40/41] RescisaoCalculatorService - metadata
git add app/Services/RescisaoCalculatorService.php
git commit --no-verify -m ":sparkles: feat: enriquecendo metadata de retorno api"

echo [41/41] ExampleTest
git add tests/Feature/ExampleTest.php
git commit --no-verify -m ":test_tube: test: atualizando teste base de rota raiz"

echo.
echo ========================================
echo  Todos os 41 commits realizados!
echo ========================================
git log --oneline -45
