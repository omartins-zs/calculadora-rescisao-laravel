@extends('layouts.app')

@section('title', 'Multa do Artigo 477 da CLT - Prazo para Pagamento de Rescisão')
@section('description', 'Meu pagamento da recisão atrasou, e agora? Entenda o que é o Artigo 477 da CLT e como calcular a multa por atraso.')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <article class="prose prose-slate dark:prose-invert lg:prose-lg max-w-none">
        <h1>O que é a Multa do Artigo 477 da CLT?</h1>
        <p class="lead">Quando ocorre a quebra de contrato de trabalho, o empregador tem um prazo legal rigoroso para quitar todas as verbas trabalhistas devidas. Se ele atrasar, está sujeito à chamada "Multa do Artigo 477".</p>
        
        <h2>Qual o prazo para pagamento?</h2>
        <p>Pela redação atual da CLT, a empresa tem o prazo máximo de <strong>10 (dez) dias contados a partir do término do contrato</strong> (o momento efetivo da rescisão). Se o último dia do aviso prévio (trabalhado ou não) ou mesmo havendo a dispensa dele recair hoje, a empresa tem até 10 dias corridos para fazer o valor do acerto chegar à sua conta e entregar os documentos que comprovam que informou aos órgãos competentes da demissão.</p>

        <h2>Qual o valor da Multa?</h2>
        <p>A Lei determina que o valor da multa por atraso — quando for de culpa comprovada do empregador — é o equivalente ao **seu salário base**, sem incluir férias e horas extras (apenas o salário nominal devidamente corrigido). Portanto, se você ganhava R$ 3.000,00 por mês, a multa adicional que a empresa deverá pagar por descumprir o prazo é de R$ 3.000,00.</p>
        
        <div class="mt-8 bg-brand-50 p-6 border-l-4 border-brand-500 dark:bg-slate-800 dark:border-brand-400 not-prose rounded-r-lg">
            <h3 class="text-xl font-bold text-brand-900 dark:text-brand-300 mb-2">Vai receber a rescisão em breve?</h3>
            <p class="text-brand-800 dark:text-slate-300 mb-4">Veja de forma estimada quanto de férias, décimo terceiro, aviso prévio e saldo de salário você deve ter e confirme se os valores recebidos estão no padrão usando nossa ferramenta:</p>
            <a href="/calculadora-rescisao-trabalhista" class="inline-flex justify-center items-center px-4 py-2 border border-transparent font-medium rounded-md text-white bg-brand-600 hover:bg-brand-700 dark:bg-brand-500 shadow-sm transition-colors">
                Ir para o Simulador
            </a>
        </div>
    </article>
</div>
@endsection
