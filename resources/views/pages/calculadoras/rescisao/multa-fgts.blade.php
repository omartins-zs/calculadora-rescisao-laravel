@extends('layouts.app')

@section('title', 'Multa de 40% do FGTS: Entenda Como Funciona e Quando Você Tem Direito')
@section('description', 'Saiba tudo sobre a multa de 40% do FGTS em caso de demissão sem justa causa. Descubra como o valor é calculado sobre o seu saldo histórico.')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <article class="prose prose-slate dark:prose-invert lg:prose-lg max-w-none">
        <h1>Multa de 40% do FGTS: Como Funciona?</h1>
        <p class="lead">A "multa do FGTS" é uma indenização compensatória devida ao trabalhador demitido sem justa causa. Trata-se de uma proteção prevista pela legislação brasileira para amparar quem é mandado embora sem dar motivo.</p>
        
        <h2>Quando tenho direito à multa?</h2>
        <p>A multa compensatória de 40% só é paga pelo empregador no caso de <strong>dispensa sem justa causa</strong>. Caso você mesmo peça demissão ou se for dispensado por justa causa, você não terá direito a receber esse valor.</p>
        
        <ul>
            <li><strong>Dispensa sem Justa Causa:</strong> Multa integral de 40%.</li>
            <li><strong>Acordo (Reforma Trabalhista):</strong> Caso opte por um acordo formal, a multa cai para 20%.</li>
            <li><strong>Culpa Recíproca ou Força Maior:</strong> A multa também é aplicável a 20%, conforme decisão da justiça.</li>
        </ul>

        <h2>Como é calculada?</h2>
        <p>Ao contrário da crença popular, a multa <strong>não</strong> é calculada apenas sobre o saldo que está "rendendo" na sua conta na Caixa paralisado naquele momento se você já tiver feito retiradas. A base de cálculo é feita sobre a <strong>soma de todos os depósitos</strong> efetuados pelo empregador durante a vigência daquele contrato, devidamente atualizados, não importando se houve saques durante o contrato (ex: para casa própria, doenças graves ou saque-aniversário).</p>
        
        <div class="mt-8 bg-slate-100 p-6 rounded-lg dark:bg-slate-800 not-prose">
            <h3 class="text-xl font-bold dark:text-white mb-2">Simule a Multa Junto com a sua Rescisão</h3>
            <p class="text-slate-600 dark:text-slate-400 mb-4">Caso prefira calcular a multa junto a um painel detalhado com Férias e Décimo Terceiro, use o simulador completo clicando no link abaixo:</p>
            <a href="/calculadora-rescisao-trabalhista" class="inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600 shadow-sm transition-colors">
                Abrir Calculadora Completa
            </a>
        </div>
    </article>
</div>
@endsection
