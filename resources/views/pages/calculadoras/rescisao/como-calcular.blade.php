@extends('layouts.app')

@section('title', 'Como Calcular Rescisão Trabalhista - Guia Prático')
@section('description', 'Aprenda passo a passo como é feito o cálculo da rescisão de contrato de trabalho. Entenda quais são as verbas rescisórias aplicáveis ao seu caso.')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <article class="prose prose-slate dark:prose-invert lg:prose-lg max-w-none">
        <h1>Como Calcular a Rescisão Trabalhista</h1>
        <p class="lead">Entender como calcular a rescisão do contrato de trabalho é fundamental para assegurar que todos os seus direitos estão sendo pagos corretamente pela empresa.</p>
        
        <h2>Passos Gerais do Cálculo</h2>
        <p>O cálculo rescisório envolve somar os "proventos" (o que você tem a receber) e subtrair os "descontos" (o que você deve, como INSS e IRRF ou adiantamentos). O resultado final é o que chamamos de <strong>Líquido a Receber</strong>.</p>
        
        <div class="bg-brand-50 border-l-4 border-brand-500 p-4 dark:bg-slate-800 dark:border-brand-400 not-prose my-6 rounded-r-lg">
            <h3 class="font-bold text-brand-800 dark:text-brand-300 mt-0">Dica Prática</h3>
            <p class="text-brand-900 dark:text-slate-300 mb-0">Se você não quer fazer o cálculo manualmente folha por folha, criamos um <a href="/calculadora-rescisao-trabalhista" class="font-semibold underline text-brand-700 dark:text-brand-400 hover:text-brand-900">Simulador de Rescisão Online e Gratuito</a> que faz todo o levantamento das alíquotas de 2026 pra você.</p>
        </div>

        <h3>1. Saldo de Salário</h3>
        <p>Você recebe pelos dias trabalhados no mês da saída. A fórmula é: <code>(Salário Base / 30) x Dias Trabalhados no Mês</code>.</p>
        
        <h3>2. Férias Vencidas e Proporcionais</h3>
        <p>Se você trabalhou mais de um ano e não tirou férias, elas estão vencidas. A cada ano trabalhado, você ganha 30 dias de férias pagas mais o adicional de 1/3 (Terço Constitucional). Frações de ano (meses trabalhados a partir de 15 dias no mês) viram férias proporcionais de 1/12 avos.</p>
        
        <h3>3. 13º Salário Proporcional</h3>
        <p>O cálculo é similar ao das férias: <code>(Salário / 12) x Meses Trabalhados no Ano</code>. Frações iguais ou maiores a 15 dias também contam como mês integral para essa regra.</p>
        
        <h3>4. Aviso Prévio</h3>
        <p>Caso a saída tenha sido sem justa causa e você foi dispensado de trabalhar durante o aviso, a empresa deve te indenizar em 30 dias + 3 dias extras por cada ano trabalhado, além de projetar esses dias nos cálculos de Férias e 13º.</p>

        <div class="mt-8 text-center not-prose">
            <a href="/calculadora-rescisao-trabalhista" class="inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-brand-600 hover:bg-brand-700 dark:bg-brand-500 dark:hover:bg-brand-600 shadow-sm transition-colors">
                Ir para a Calculadora Automática
            </a>
        </div>
    </article>
</div>
@endsection
