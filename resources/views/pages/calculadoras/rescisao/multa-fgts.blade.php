@extends('layouts.app')

@section('title', 'Multa de 40% do FGTS: Entenda Como Funciona e Quando Você Tem Direito')
@section('description', 'Saiba tudo sobre a multa de 40% do FGTS em caso de demissão sem justa causa. Descubra como o valor é calculado sobre o seu saldo histórico.')

@section('content')
<div class="bg-gradient-to-b from-slate-50 to-white dark:from-slate-900 dark:to-slate-900 pb-20 pt-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-8">
            <a href="/calculadora-rescisao-trabalhista" class="inline-flex items-center text-sm font-semibold text-brand-600 dark:text-brand-400 hover:underline gap-1 mb-6">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Voltar para a Calculadora
            </a>
            
            <h1 class="text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight mb-4">
                Multa de 40% do FGTS: Guia Completo e Como Funciona
            </h1>
            <p class="text-lg text-slate-600 dark:text-slate-400">
                Entenda a base de cálculo, regras da CLT, o impacto do Saque-Aniversário e faça simulações precisas.
            </p>
        </div>

        <article class="prose prose-slate dark:prose-invert lg:prose-lg max-w-none">
            <p class="lead">
                A multa rescisória do FGTS é uma indenização compensatória que a empresa deve pagar ao trabalhador quando este é desligado <strong>sem justa causa</strong>. Ela funciona como um colchão financeiro e de proteção garantido pela Constituição Federal.
            </p>

            <h2>1. Quem tem direito ao recebimento da Multa?</h2>
            <p>
                O direito e a porcentagem da multa do FGTS variam de acordo com a modalidade de rescisão contratual:
            </p>

            <div class="overflow-x-auto my-6 not-prose">
                <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700 rounded-lg overflow-hidden border border-slate-200 dark:border-slate-700">
                    <thead class="bg-slate-50 dark:bg-slate-800">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Tipo de Rescisão</th>
                            <th class="px-4 py-3 text-center text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Percentual da Multa</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Direito ao Saque do Saldo</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-slate-900 divide-y divide-slate-200 dark:divide-slate-700 text-sm">
                        <tr>
                            <td class="px-4 py-3 font-medium text-slate-900 dark:text-white">Demissão Sem Justa Causa</td>
                            <td class="px-4 py-3 text-center text-emerald-600 dark:text-emerald-400 font-bold">40%</td>
                            <td class="px-4 py-3 text-slate-600 dark:text-slate-400">Sim, saca 100% do saldo acumulado.</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-3 font-medium text-slate-900 dark:text-white">Acordo Comum (Reforma Trabalhista)</td>
                            <td class="px-4 py-3 text-center text-amber-600 dark:text-amber-400 font-bold">20%</td>
                            <td class="px-4 py-3 text-slate-600 dark:text-slate-400">Sim, saca até 80% do saldo acumulado.</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-3 font-medium text-slate-900 dark:text-white">Pedido de Demissão</td>
                            <td class="px-4 py-3 text-center text-red-600 dark:text-red-400 font-semibold">0% (Não tem)</td>
                            <td class="px-4 py-3 text-slate-600 dark:text-slate-400">Não (Saldo fica retido para outras hipóteses legais).</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-3 font-medium text-slate-900 dark:text-white">Demissão Com Justa Causa</td>
                            <td class="px-4 py-3 text-center text-red-600 dark:text-red-400 font-semibold">0% (Não tem)</td>
                            <td class="px-4 py-3 text-slate-600 dark:text-slate-400">Não (Perde o direito de saque da conta).</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <h2>2. Como é calculada a Multa do FGTS? (O Grande Segredo)</h2>
            <p>
                Muitas pessoas acreditam que a multa de 40% é calculada sobre o saldo atual que aparece no aplicativo do FGTS da Caixa Econômica. <strong>Isso é um erro comum!</strong>
            </p>
            <p>
                A multa é calculada sobre a <strong>Base de Fins Rescisórios</strong>. Essa base é a soma de <strong>todos os depósitos mensais de 8%</strong> efetuados pelo empregador ao longo de todo o contrato de trabalho, devidamente corrigidos monetariamente. 
            </p>
            <p>
                Isso significa que, mesmo se você tiver sacado parte do seu FGTS para:
            </p>
            <ul>
                <li>Adquirir ou amortizar casa própria;</li>
                <li>Modalidade Saque-Aniversário;</li>
                <li>Saque extraordinário ou por motivos de doença.</li>
            </ul>
            <p>
                O valor da sua multa de 40% <strong>permanece inalterado</strong>, pois ela incide sobre o saldo histórico acumulado total depositado, e não sobre o saldo atual em conta.
            </p>

            <div class="bg-brand-50 border-l-4 border-brand-500 p-4 dark:bg-slate-800/80 dark:border-brand-400 not-prose my-6 rounded-r-lg">
                <h4 class="font-bold text-brand-900 dark:text-brand-300 mt-0">Exemplo Prático:</h4>
                <p class="text-sm text-slate-700 dark:text-slate-300 mb-0">
                    Se a empresa depositou um total histórico de <strong>R$ 10.000,00</strong> no seu FGTS, mas você sacou R$ 6.000,00 para comprar um apartamento (restando R$ 4.000,00 na conta):<br>
                    - A multa de 40% será calculada sobre os <strong>R$ 10.000,00</strong> (Base de Fins Rescisórios).<br>
                    - Valor da multa a receber: <strong>R$ 4.000,00</strong> (40% de 10.000) e não R$ 1.600,00 (40% de 4.000).
                </p>
            </div>

            <h2>3. O Impacto do Saque-Aniversário na Rescisão</h2>
            <p>
                Se você optou pela modalidade de <strong>Saque-Aniversário</strong> do FGTS, preste muita atenção nas regras de rescisão:
            </p>
            <ul>
                <li><strong>Multa de 40%:</strong> Você **continua tendo direito** de receber a multa de 40% normalmente na sua conta bancária. O empregador é obrigado a depositar esse valor.</li>
                <li><strong>Saque do Saldo:</strong> Você **não poderá sacar o restante do saldo** do FGTS. O saldo fica bloqueado para saque-rescisão por um período de carência (25 meses se decidir voltar para o saque-rescisão). Você só continuará sacando as parcelas anuais no mês do seu aniversário.</li>
            </ul>

            <h2>4. Qual o prazo para o pagamento da Multa do FGTS?</h2>
            <p>
                O prazo para o depósito da multa do FGTS na conta vinculada do trabalhador é o mesmo das verbas rescisórias conforme o Artigo 477 da CLT: <strong>até 10 dias corridos</strong> após o último dia do contrato de trabalho.
            </p>
            <p>
                Caso a empresa atrase esse depósito, ela fica sujeita a pagar uma multa equivalente ao salário do trabalhador em favor dele.
            </p>

            <h2>5. Como consultar o saldo para fins rescisórios?</h2>
            <p>
                Para saber o valor exato que servirá de base para a sua multa, siga o passo a passo:
            </p>
            <ol>
                <li>Baixe e acesse o aplicativo oficial do <strong>FGTS</strong> no celular.</li>
                <li>Selecione a empresa atual na aba de contratos.</li>
                <li>Clique em <strong>"Ver Extrato Completo"</strong>.</li>
                <li>Procure pela linha descrita como <strong>"Valor para Fins Rescisórios"</strong>. Esse é o montante sobre o qual incidirá os 40%.</li>
            </ol>

            <div class="mt-10 bg-slate-100 dark:bg-slate-800 p-6 rounded-2xl not-prose border border-slate-200 dark:border-slate-700">
                <h3 class="text-xl font-bold dark:text-white mb-2">Pronto para fazer a sua simulação?</h3>
                <p class="text-slate-600 dark:text-slate-400 mb-4">Insira o seu salário base e datas na nossa calculadora e obtenha a estimativa completa da sua rescisão com cálculo da multa do FGTS.</p>
                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="/calculadora-rescisao-trabalhista" class="inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-semibold rounded-lg text-white bg-brand-600 hover:bg-brand-700 dark:bg-brand-500 dark:hover:bg-brand-600 shadow-sm transition-colors gap-2">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                        Calcular Rescisão Agora
                    </a>
                    <a href="/como-calcular-rescisao-trabalhista" class="inline-flex justify-center items-center px-6 py-3 border border-slate-300 dark:border-slate-600 text-base font-semibold rounded-lg text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-700 hover:bg-slate-50 dark:hover:bg-slate-600 shadow-sm transition-colors">
                        Ver Guia Prático
                    </a>
                </div>
            </div>
        </article>
    </div>
</div>
@endsection
