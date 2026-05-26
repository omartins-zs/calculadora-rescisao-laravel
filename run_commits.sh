#!/bin/bash

# Cores para feedback
GREEN='\033[0;32m'
BLUE='\033[0;34m'
NC='\033[0m'

echo -e "${BLUE}---------------------------------------${NC}"
echo -e "${BLUE}   Assistente de Commits Estruturados  ${NC}"
echo -e "${BLUE}---------------------------------------${NC}"

# Verificar se há arquivos no stage
if [ -z "$(git diff --cached --name-only)" ]; then
    echo "Nenhuma alteração no stage. Use 'git add' primeiro."
    exit 1
fi

# Selecionar o tipo de mudança
echo "Selecione o tipo de mudança:"
echo "1) feat: Nova funcionalidade"
echo "2) fix: Correção de bug"
echo "3) docs: Documentação"
echo "4) style: Formatação/Estilo (não afeta lógica)"
echo "5) refactor: Refatoração que não corrige bug nem adiciona funcionalidade"
echo "6) perf: Melhoria de performance"
echo "7) test: Adição ou correção de testes"
echo "8) chore: Tarefas de build, ferramentas, etc."

read -p "Opção (1-8): " type_opt

case $type_opt in
    1) type="feat" ;;
    2) type="fix" ;;
    3) type="docs" ;;
    4) type="style" ;;
    5) type="refactor" ;;
    6) type="perf" ;;
    7) type="test" ;;
    8) type="chore" ;;
    *) echo "Opção inválida."; exit 1 ;;
esac

read -p "Escopo (opcional, ex: docker, auth, ui): " scope
if [ ! -z "$scope" ]; then
    scope="($scope)"
fi

read -p "Descrição curta e clara: " desc

if [ -z "$desc" ]; then
    echo "Descrição é obrigatória."
    exit 1
fi

COMMIT_MSG="$type$scope: $desc"

echo -e "\nMensagem final: ${GREEN}$COMMIT_MSG${NC}"
read -p "Confirmar commit? (s/n): " confirm

if [ "$confirm" = "s" ]; then
    git commit -m "$COMMIT_MSG"
else
    echo "Cancelado."
fi
