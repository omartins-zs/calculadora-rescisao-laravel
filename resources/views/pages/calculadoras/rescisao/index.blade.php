@extends('layouts.app')

@section('title', 'Calculadora de Rescisão Trabalhista (CLT) - Simulação Online Grátis')
@section('description', 'Calcule sua rescisão trabalhista com precisão. Descubra quanto vai receber na demissão (aviso prévio, férias, décimo terceiro, multa do FGTS).')

@section('content')

<!-- Schema Markup JSON-LD -->
<script type="application/ld+json">
{
  "{{ '@context' }}": "https://schema.org",
  "{{ '@type' }}": "WebApplication",
  "name": "Calculadora de Rescisão Trabalhista CLT",
  "applicationCategory": "BusinessApplication",
  "operatingSystem": "All",
  "offers": {
    "{{ '@type' }}": "Offer",
    "price": "0"
  },
  "description": "Simulador para calcular o valor da rescisão de contrato de trabalho conforme regras CLT.",
  "applicationSubCategory": "Calculadora Trabalhista"
}
</script>

<div class="relative overflow-hidden
              bg-gradient-to-b from-brand-50/80 via-slate-50 to-slate-50
              dark:from-brand-950/30 dark:via-slate-950 dark:to-slate-950
              pb-24 pt-10">

    {{-- Decorative background blobs --}}
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 overflow-hidden">
        <div class="absolute -top-24 left-1/2 -translate-x-1/2 w-[900px] h-[400px]
                    bg-brand-500/5 dark:bg-brand-400/5 rounded-full blur-3xl"></div>
        <div class="absolute top-10 right-0 w-72 h-72
                    bg-indigo-500/5 dark:bg-indigo-400/5 rounded-full blur-2xl"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center max-w-3xl mx-auto mb-12">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full
                        bg-brand-100 dark:bg-brand-950/60
                        border border-brand-200 dark:border-brand-900
                        text-brand-700 dark:text-brand-400 text-xs font-semibold
                        mb-6 animate-fade-in">
                <span class="inline-block w-2 h-2 rounded-full bg-brand-500 animate-pulse"></span>
                Atualizado com tabelas CLT 2026
            </div>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold
                       text-slate-900 dark:text-white tracking-tight mb-5 leading-tight">
                Calculadora de
                <span class="bg-gradient-to-r from-brand-600 to-emerald-500
                             dark:from-brand-400 dark:to-emerald-400
                             bg-clip-text text-transparent">Rescisão</span>
                Trabalhista
            </h1>
            <p class="text-lg md:text-xl text-slate-600 dark:text-slate-400 leading-relaxed">
                Descubra em 2 minutos quanto você deve receber (ou pagar) na sua rescisão de contrato.
                Simulação baseada nas leis atuais da CLT.
            </p>
        </div>

        <div x-data="rescisaoCalculator()" class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- FORMULÁRIO -->
            <div class="lg:col-span-5 space-y-6">
                <x-card>
                    <x-slot name="header">
                        <div class="flex items-center justify-between">
                            <h2 class="text-xl font-bold dark:text-white flex items-center gap-2">
                                <svg class="w-5 h-5 text-brand-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Preencha os Dados
                            </h2>
                            <button @@click="showAdvanced = !showAdvanced" class="text-sm font-medium text-brand-600 dark:text-brand-400 hover:underline">
                                <span x-text="showAdvanced ? 'Modo Simples' : 'Modo Avançado'"></span>
                            </button>
                        </div>
                    </x-slot>

                    <form class="space-y-5" @@input.debounce.500ms="calcular()">

                        <!-- Dados Base -->
                        <div class="space-y-4">
                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-brand-100 dark:bg-brand-950/60 text-brand-600 dark:text-brand-400 text-xs font-bold">1</span>
                                <h3 class="text-sm font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Tempo e Salário</h3>
                            </div>

                            <x-input
                                model="form.salario_base_mensal"
                                type="text"
                                x-mask:dynamic="$money($input, ',', '.', 2)"
                                label="Salário Bruto (R$)"
                                name="salario"
                                placeholder="Ex: 3.500,00"
                                icon="currency"
                                helper="Salário base registrado em carteira."
                            />

                            <div class="grid grid-cols-2 gap-4">
                                <x-input
                                    model="form.data_admissao"
                                    type="date"
                                    label="Data de Entrada"
                                    name="admissao"
                                    icon="calendar"
                                />
                                <x-input
                                    model="form.data_desligamento"
                                    type="date"
                                    label="Data de Saída"
                                    name="saida"
                                    icon="calendar"
                                    helper="Último dia trabalhado."
                                />
                            </div>
                        </div>

                        <hr class="border-slate-200 dark:border-slate-700/60">

                        <!-- Motivo -->
                        <div class="space-y-4">
                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-brand-100 dark:bg-brand-950/60 text-brand-600 dark:text-brand-400 text-xs font-bold">2</span>
                                <h3 class="text-sm font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">A Demissão</h3>
                            </div>

                            <x-select model="form.motivo_rescisao" label="Motivo da Saída" name="motivo" :options="[
                                'dispensa_sem_justa_causa' => 'Demissão sem justa causa (A empresa me demitiu)',
                                'pedido_de_demissao' => 'Pedido de demissão (Eu pedi para sair)',
                                'acordo_entre_as_partes' => 'Acordo (Lei Reforma Trabalhista)',
                                'dispensa_com_justa_causa' => 'Demissão com justa causa',
                                'termino_contrato_experiencia' => 'Término de contrato de experiência'
                            ]" />

                            <x-select model="form.tipo_aviso_previo" label="Sobre o Aviso Prévio" name="aviso" :options="[
                                'indenizado' => 'Aviso Indenizado (A empresa paga e eu não trabalho os 30 dias)',
                                'trabalhado' => 'Aviso Trabalhado (Minha Data de Saída já inclui o aviso)',
                                'nao_sei' => 'Não tenho certeza / Não se aplica'
                            ]" />
                        </div>

                        <hr class="border-slate-200 dark:border-slate-700/60">

                        <!-- Férias -->
                        <div class="space-y-3">
                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-brand-100 dark:bg-brand-950/60 text-brand-600 dark:text-brand-400 text-xs font-bold">3</span>
                                <h3 class="text-sm font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400">Saldos</h3>
                            </div>

                            <label for="ferias_venc"
                                   class="flex items-center gap-3 p-3.5 rounded-xl border border-slate-200 dark:border-slate-700/80
                                          bg-slate-50 dark:bg-slate-800/40 cursor-pointer
                                          hover:border-brand-400 dark:hover:border-brand-500
                                          hover:bg-brand-50 dark:hover:bg-brand-950/20
                                          transition-all duration-150 group">
                                <input
                                    x-model="form.possui_ferias_vencidas"
                                    type="checkbox"
                                    id="ferias_venc"
                                    class="fb-check"
                                >
                                <div>
                                    <span class="text-sm font-medium text-slate-700 dark:text-slate-200 group-hover:text-brand-700 dark:group-hover:text-brand-300">Tenho férias vencidas</span>
                                    <p class="text-xs text-slate-400 dark:text-slate-500 mt-0.5">1 período ou mais atrasado (≥ 12 meses sem tirar férias)</p>
                                </div>
                            </label>
                        </div>

                        <!-- Campos Avançados -->
                        <div x-show="showAdvanced" x-transition.opacity
                             class="space-y-4 pt-4 mt-1 border-t border-dashed border-slate-200 dark:border-slate-700/60
                                    p-4 bg-slate-50/70 dark:bg-slate-800/40 rounded-xl">
                            <div class="flex items-center gap-2 mb-3">
                                <svg class="w-4 h-4 text-brand-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <h3 class="text-sm font-semibold uppercase tracking-wider text-brand-600 dark:text-brand-400">Campos Avançados</h3>
                            </div>

                            <x-input
                                model="form.saldo_fgts_para_fins_rescisorios"
                                type="text"
                                x-mask:dynamic="$money($input, ',', '.', 2)"
                                label="Saldo de FGTS (R$)"
                                name="saldo_fgts"
                                placeholder="Ex: 12.500,00"
                                icon="currency"
                                helper="Se vazio, estimamos com base no histórico."
                            />
                            <x-input
                                model="form.salario_variavel_media_12m"
                                type="text"
                                x-mask:dynamic="$money($input, ',', '.', 2)"
                                label="Média de Horas Extras / Comissões (R$)"
                                name="variavel"
                                placeholder="Ex: 500,00"
                                icon="currency"
                            />
                            <x-input
                                model="form.adiantamento_salarial"
                                type="text"
                                x-mask:dynamic="$money($input, ',', '.', 2)"
                                label="Adiantamentos / Descontos (R$)"
                                name="descontos_extra"
                                placeholder="Ex: 200,00"
                                icon="currency"
                            />
                            <x-input
                                model="form.dependentes_ir"
                                type="number"
                                label="Dependentes no IR"
                                name="dependentes"
                                placeholder="0"
                                icon="number"
                            />
                        </div>

                        <div class="pt-2">
                            <button type="button" @click="limpar()" class="w-full flex justify-center items-center gap-2 py-3 px-4 rounded-xl font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 dark:bg-slate-700/50 dark:text-slate-300 dark:hover:bg-slate-700 transition-colors">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Limpar Dados
                            </button>
                        </div>

                    </form>
                </x-card>
            </div>

            <!-- RESULTADOS -->
            <div class="lg:col-span-7 space-y-6">
                <!-- Resumo -->
                <x-card class="border-t-4 border-t-brand-500">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold dark:text-white">Resumo Estimado</h2>
                        <div x-show="isLoading" class="text-sm text-slate-500 flex items-center animate-pulse">
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-brand-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Calculando...
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6">
                        <x-kpi label="Total Bruto" value="result.totals.bruto_formatado" color="indigo" />
                        <x-kpi label="Descontos" value="result.totals.descontos_formatado" color="red" />
                        <x-kpi label="Líquido na Rescisão" value="result.totals.liquido_formatado" color="brand" description="A receber pela empresa." />
                    </div>
                    
                    <div class="bg-blue-50 dark:bg-blue-900/30 border border-blue-100 dark:border-blue-800 rounded-lg p-4 mb-6">
                        <h4 class="text-sm font-semibold text-blue-800 dark:text-blue-300 mb-1 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Sobre o FGTS
                        </h4>
                        <p class="text-sm text-blue-700 dark:text-blue-400">
                            Multa estimada do FGTS: <strong x-text="result.fgts.multa_formatada"></strong>.<br>
                            <span class="text-xs" x-show="result.fgts.is_estimativa">(Valor da multa calculado sobre uma estimativa da base histórica global. Apenas informativo.)</span>
                        </p>
                    </div>

                    <div class="flex gap-2">
                        <button onclick="window.print()" class="flex-1 bg-white dark:bg-slate-700 border border-slate-300 dark:border-slate-600 hover:bg-slate-50 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 font-semibold py-2 px-4 rounded-lg shadow-sm transition-colors flex justify-center items-center gap-2">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                            </svg>
                            Imprimir PDF
                        </button>
                    </div>
                </x-card>

                <!-- Breakdown / Memória de Cálculo -->
                <x-card>
                    <h3 class="text-lg font-bold dark:text-white mb-4">Memória de Cálculo</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200 dark:divide-slate-700">
                            <thead class="bg-slate-50 dark:bg-slate-800">
                                <tr>
                                    <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Item</th>
                                    <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Referência</th>
                                    <th scope="col" class="px-3 py-3 text-right text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Valor (R$)</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-slate-800 divide-y divide-slate-200 dark:divide-slate-700">
                                <template x-for="item in result.items" :key="item.nome">
                                    <tr :class="item.categoria === 'Descontos' ? 'bg-red-50/50 dark:bg-red-900/10' : ''">
                                        <td class="px-3 py-4 whitespace-nowrap text-sm font-medium text-slate-900 dark:text-white">
                                            <span x-text="item.nome"></span>
                                            <span x-show="item.isento" class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                                Isento
                                            </span>
                                        </td>
                                        <td class="px-3 py-4 whitespace-nowrap text-sm text-slate-500 dark:text-slate-400" x-text="item.referencia"></td>
                                        <td class="px-3 py-4 whitespace-nowrap text-sm font-semibold text-right" 
                                            :class="item.categoria === 'Descontos' ? 'text-red-600 dark:text-red-400' : 'text-slate-900 dark:text-white'" 
                                            x-text="formatMoney(item.valor)">
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                        
                        <div x-show="result.items.length === 0" class="text-center py-8 text-slate-500 dark:text-slate-400">
                            Preencha os dados do contrato para gerar a simulação.
                        </div>
                    </div>
                </x-card>
            </div>
        </div>

        <!-- CONTEÚDO SEO E INFORMAÇÕES -->
        <article class="mt-20 max-w-4xl mx-auto prose prose-slate dark:prose-invert lg:prose-lg">
            <h2>O que é a Rescisão de Contrato de Trabalho?</h2>
            <p>O cálculo da rescisão do contrato de trabalho (ou acerto trabalhista) é o procedimento onde se quantifica os valores devidos pela empresa ao empregado no encerramento da relação de emprego. Os direitos variam drasticamente dependo do <strong>motivo da saída</strong> (quem pediu a demissão).</p>
            
            <h3>Quais as Verbas Rescisórias?</h3>
            <ul>
                <li><strong>Saldo de Salário:</strong> É o pagamento pelos dias trabalhados no mês do desligamento.</li>
                <li><strong>Aviso Prévio Trabalhado ou Indenizado:</strong> Corresponde a 30 dias de salário, acrescido de 3 dias por cada ano completo trabalhado (até o limite de 90 dias).</li>
                <li><strong>Férias Vencidas e Proporcionais (com adicional de 1/3):</strong> Caso você não tenha tirado férias ainda ou possua fração de férias (meses com 15 dias trabalhados ou mais no período).</li>
                <li><strong>13º Salário Proporcional:</strong> Pago em avos (1/12) para cada mês trabalhado ou fração superior a 14 dias no ano da saída.</li>
                <li><strong>Multa de 40% do FGTS:</strong> Aplicável em dispensas sem justa causa. (Cai para 20% no acordo consensual).</li>
            </ul>

            <div class="not-prose mt-10">
                <h3 class="text-2xl font-bold dark:text-white mb-6">Perguntas Frequentes (FAQ)</h3>
                
                <div class="space-y-4">
                    <details class="group border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 rounded-lg p-4 cursor-pointer" open>
                        <summary class="font-semibold text-slate-900 dark:text-white list-none flex justify-between items-center outline-none">
                            Quem pede demissão tem direito ao seguro-desemprego ou FGTS?
                            <span class="transition group-open:rotate-180">
                                <svg fill="none" height="24" shape-rendering="geometricPrecision" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" width="24"><path d="M6 9l6 6 6-6"></path></svg>
                            </span>
                        </summary>
                        <div class="text-slate-600 dark:text-slate-400 mt-3">
                            <p>Não. No caso de <strong>pedido de demissão</strong>, o trabalhador <strong>não</strong> pode sacar o saldo do FGTS, não tem direito à multa de 40% e também não pode dar entrada no seguro-desemprego. Ele recebe "apenas" as férias, 13º e saldo de salário.</p>
                        </div>
                    </details>

                    <details class="group border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 rounded-lg p-4 cursor-pointer">
                        <summary class="font-semibold text-slate-900 dark:text-white list-none flex justify-between items-center outline-none">
                            O que acontece se eu pedir demissão e não cumprir o aviso prévio?
                            <span class="transition group-open:rotate-180">
                                <svg fill="none" height="24" shape-rendering="geometricPrecision" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" width="24"><path d="M6 9l6 6 6-6"></path></svg>
                            </span>
                        </summary>
                        <div class="text-slate-600 dark:text-slate-400 mt-3">
                            <p>O empregador tem o direito de <strong>descontar</strong> o valor equivalente a 30 dias (1 mês de salário) da sua rescisão. Portanto, se você não for trabalhar no aviso prévio sem acordo prévio de dispensa, sua rescisão virá menor.</p>
                        </div>
                    </details>

                    <details class="group border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 rounded-lg p-4 cursor-pointer">
                        <summary class="font-semibold text-slate-900 dark:text-white list-none flex justify-between items-center outline-none">
                            E os descontos do INSS e Imposto de Renda?
                            <span class="transition group-open:rotate-180">
                                <svg fill="none" height="24" shape-rendering="geometricPrecision" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" viewBox="0 0 24 24" width="24"><path d="M6 9l6 6 6-6"></path></svg>
                            </span>
                        </summary>
                        <div class="text-slate-600 dark:text-slate-400 mt-3">
                            <p>Ocorrem normalmente sobre verbas de natureza salarial, com destaque para o Saldo de Salário e o 13º Salário Proporcional. Geralmente, as verbas indenizatórias (Aviso Prévio Indenizado e Férias Indenizadas) são isentas de Imposto de Renda.</p>
                        </div>
                    </details>
                </div>
            </div>
            
        </article>
    </div>
</div>

@endsection

@section('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('rescisaoCalculator', () => ({
            showAdvanced: false,
            isLoading: false,
            
            form: {
                salario_base_mensal: '',
                data_admissao: '',
                data_desligamento: '',
                motivo_rescisao: 'dispensa_sem_justa_causa',
                tipo_aviso_previo: 'nao_sei',
                possui_ferias_vencidas: false,
                qtd_periodos_ferias_vencidas: 1,
                saldo_fgts_para_fins_rescisorios: '',
                salario_variavel_media_12m: '',
                adiantamento_salarial: '',
                dependentes_ir: 0
            },
            
            result: {
                items: [],
                totals: { bruto_formatado: 'R$ 0,00', descontos_formatado: 'R$ 0,00', liquido_formatado: 'R$ 0,00' },
                fgts: { multa_formatada: 'R$ 0,00', is_estimativa: false }
            },

            init() {
                // Previne submit do form (enter pressionado)
                this.$el.querySelector('form').addEventListener('submit', e => e.preventDefault());
            },

            formatMoney(value) {
                return new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(value);
            },

            cleanFormattedNumber(val) {
                if (!val) return 0;
                if (typeof val === 'number') return val;
                const cleaned = val.replace(/\./g, '').replace(',', '.');
                return parseFloat(cleaned) || 0;
            },

            async calcular() {
                if (!this.form.salario_base_mensal || !this.form.data_admissao || !this.form.data_desligamento) return;
                
                this.isLoading = true;

                try {
                    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    
                    const payload = {
                        ...this.form,
                        salario_base_mensal: this.cleanFormattedNumber(this.form.salario_base_mensal),
                        saldo_fgts_para_fins_rescisorios: this.cleanFormattedNumber(this.form.saldo_fgts_para_fins_rescisorios),
                        salario_variavel_media_12m: this.cleanFormattedNumber(this.form.salario_variavel_media_12m),
                        adiantamento_salarial: this.cleanFormattedNumber(this.form.adiantamento_salarial),
                        possui_ferias_vencidas: this.form.possui_ferias_vencidas ? 'sim' : 'nao'
                    };

                    const response = await fetch('/api/calculo/rescisao', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': token,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(payload)
                    });

                    if (!response.ok) throw new Error('Erro na API');
                    const data = await response.json();
                    
                    this.result = data;
                    
                    // Formata retorno pra exibição direta
                    this.result.totals.bruto_formatado = this.formatMoney(data.totals.bruto);
                    this.result.totals.descontos_formatado = this.formatMoney(data.totals.descontos);
                    this.result.totals.liquido_formatado = this.formatMoney(data.totals.liquido);
                    this.result.fgts.multa_formatada = this.formatMoney(data.fgts.multa);

                } catch (error) {
                    console.error('Falha no cálculo', error);
                } finally {
                    this.isLoading = false;
                }
            },

            limpar() {
                this.form = {
                    salario_base_mensal: '',
                    data_admissao: '',
                    data_desligamento: '',
                    motivo_rescisao: 'dispensa_sem_justa_causa',
                    tipo_aviso_previo: 'nao_sei',
                    possui_ferias_vencidas: false,
                    qtd_periodos_ferias_vencidas: 1,
                    saldo_fgts_para_fins_rescisorios: '',
                    salario_variavel_media_12m: '',
                    adiantamento_salarial: '',
                    dependentes_ir: 0
                };
                
                this.result = {
                    items: [],
                    totals: { bruto_formatado: 'R$ 0,00', descontos_formatado: 'R$ 0,00', liquido_formatado: 'R$ 0,00' },
                    fgts: { multa_formatada: 'R$ 0,00', is_estimativa: false }
                };
            }
        }))
    })
</script>
@endsection
