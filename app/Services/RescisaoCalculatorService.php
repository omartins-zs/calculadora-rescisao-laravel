<?php

namespace App\Services;

use DateTime;
use Exception;

class RescisaoCalculatorService
{
    protected AvisoPrevioService $avisoService;
    protected FeriasService $feriasService;
    protected DecimoTerceiroService $decimoTerceiroService;
    protected FgtsService $fgtsService;
    protected DescontosService $descontosService;

    public function __construct(
        AvisoPrevioService $avisoService,
        FeriasService $feriasService,
        DecimoTerceiroService $decimoTerceiroService,
        FgtsService $fgtsService,
        DescontosService $descontosService
    ) {
        $this->avisoService = $avisoService;
        $this->feriasService = $feriasService;
        $this->decimoTerceiroService = $decimoTerceiroService;
        $this->fgtsService = $fgtsService;
        $this->descontosService = $descontosService;
    }

    public function calcular(array $input): array
    {
        $salarioBase = floatval($input['salario_base_mensal']);
        $variavelMedia = floatval($input['salario_variavel_media_12m'] ?? 0);
        $adicionais = floatval($input['adicionais_mensais'] ?? 0);
        
        $baseRemuneracao = $salarioBase + $variavelMedia + $adicionais;
        
        $dataAdmissao = $input['data_admissao'];
        $dataDesligamentoOriginal = $input['data_desligamento'];
        $motivo = $input['motivo_rescisao'];
        $tipoAviso = $input['tipo_aviso_previo'] ?? 'nao_sei';
        $diasFaltas = intval($input['faltas_injustificadas_no_mes'] ?? 0);
        
        $dependentes = intval($input['dependentes_ir'] ?? 0);

        // Prepara objeto de dados de saída
        $items = [];
        $totalBruto = 0;
        $totalDescontos = 0;

        // 1. AVISO PRÉVIO
        $diasAviso = $this->avisoService->calcularDiasAvisoPrevio($dataAdmissao, $dataDesligamentoOriginal);
        $valorAviso = 0;
        $dataDesligamentoProjetada = $dataDesligamentoOriginal;

        if ($tipoAviso === 'indenizado') {
            if ($motivo === 'dispensa_sem_justa_causa' || in_array($motivo, ['rescisao_antecipada_experiencia_empregador'])) {
                $valorAviso = ($baseRemuneracao / 30) * $diasAviso;
                $items[] = ['categoria' => 'Indenizações', 'nome' => 'Aviso Prévio Indenizado', 'referencia' => "$diasAviso dias", 'valor' => $valorAviso, 'isento' => true];
                $totalBruto += $valorAviso;
                
                // Projeta tempo de aviso para data final
                $d = new DateTime($dataDesligamentoProjetada);
                $d->modify("+$diasAviso days");
                $dataDesligamentoProjetada = $d->format('Y-m-d');
            } elseif ($motivo === 'acordo_entre_as_partes') {
                $valorAviso = (($baseRemuneracao / 30) * $diasAviso) / 2; // Metade do aviso
                $items[] = ['categoria' => 'Indenizações', 'nome' => 'Aviso Prévio Indenizado (Metade)', 'referencia' => "$diasAviso dias", 'valor' => $valorAviso, 'isento' => true];
                $totalBruto += $valorAviso;
                $d = new DateTime($dataDesligamentoProjetada);
                $d->modify("+$diasAviso days");
                $dataDesligamentoProjetada = $d->format('Y-m-d');
            } elseif ($motivo === 'pedido_de_demissao') {
                $avisoDescontoEmpregado = ($baseRemuneracao / 30) * 30; // Desconta 30 dias se não cumpriu
                $items[] = ['categoria' => 'Descontos', 'nome' => 'Desconto Aviso Prévio não cumprido', 'referencia' => '30 dias', 'valor' => $avisoDescontoEmpregado, 'isento' => false];
                $totalDescontos += $avisoDescontoEmpregado;
            }
        }

        // 2. SALDO DE SALÁRIO
        // Assume o dia no mês de saída, menos os dias faltados. Se passado customizado, usamos.
        $diasTrabalhados = $input['dias_trabalhados_no_mes'] ?? null;
        if ($diasTrabalhados === null) {
            $dtSaida = new DateTime($dataDesligamentoOriginal);
            $diasTrabalhados = (int) $dtSaida->format('d');
            $diasTrabalhados = min(30, max(0, $diasTrabalhados - $diasFaltas));
        }

        if ($diasTrabalhados > 0) {
            $valorSaldoSalario = ($baseRemuneracao / 30) * $diasTrabalhados;
            $items[] = ['categoria' => 'Salários', 'nome' => 'Saldo de Salário', 'referencia' => "$diasTrabalhados/30 dias", 'valor' => $valorSaldoSalario, 'isento' => false];
            $totalBruto += $valorSaldoSalario;
        } else {
            $valorSaldoSalario = 0;
        }

        // 3. FÉRIAS
        // Vencidas
        if (($input['possui_ferias_vencidas'] ?? 'nao') === 'sim') {
            $qtd = intval($input['qtd_periodos_ferias_vencidas'] ?? 1);
            $valorFeriasVencidas = ($baseRemuneracao * $qtd) + (($baseRemuneracao * $qtd) / 3);
            $items[] = ['categoria' => 'Férias', 'nome' => 'Férias Vencidas + 1/3', 'referencia' => "$qtd período(s)", 'valor' => $valorFeriasVencidas, 'isento' => true];
            $totalBruto += $valorFeriasVencidas;
        }

        // Proporcionais (Não paga em Justa Causa)
        if ($motivo !== 'dispensa_com_justa_causa') {
            // Conta meses do inicio_aquisitivo_proporcional ou da admissao ate desligamento projetado...
            // Para simplificar, num cenário real com base apenas na data de admissão e demissão:
            $adm = new DateTime($dataAdmissao);
            $desl = new DateTime($dataDesligamentoProjetada);
            
            // Acha o último "aniversário" de contratação
            $ultimoAniverFerias = clone $adm;
            while ($ultimoAniverFerias < clone $desl->modify('-1 year')) {
                $ultimoAniverFerias->modify('+1 year');
            }
            if ($ultimoAniverFerias > new DateTime($dataDesligamentoProjetada)) {
                $ultimoAniverFerias->modify('-1 year');
            }

            $avosFerias = $this->feriasService->calcularAvosProporcionais($ultimoAniverFerias->format('Y-m-d'), $dataDesligamentoProjetada);
            
            if ($avosFerias > 0) {
                $valorFeriasProp = ($baseRemuneracao / 12) * $avosFerias;
                $terco = $valorFeriasProp / 3;
                $totalProp = $valorFeriasProp + $terco;
                $items[] = ['categoria' => 'Férias', 'nome' => 'Férias Proporcionais + 1/3', 'referencia' => "$avosFerias/12 avos", 'valor' => $totalProp, 'isento' => true];
                $totalBruto += $totalProp;
            }
        }

        // 4. 13º SALÁRIO (Não paga em Justa Causa)
        $valor13 = 0;
        if ($motivo !== 'dispensa_com_justa_causa') {
            $avos13 = $this->decimoTerceiroService->calcularAvosDecimoTerceiro($dataDesligamentoProjetada);
            if ($avos13 > 0) {
                $valor13 = ($baseRemuneracao / 12) * $avos13;
                $items[] = ['categoria' => '13º', 'nome' => '13º Salário Proporcional', 'referencia' => "$avos13/12 avos", 'valor' => $valor13, 'isento' => false];
                $totalBruto += $valor13;
            }
        }

        // 5. EXTRAS / ADICIONAIS / OUTROS
        $outrosProventos = floatval($input['outros_proventos'] ?? 0);
        if ($outrosProventos > 0) {
            $items[] = ['categoria' => 'Indenizações', 'nome' => 'Outros Proventos', 'referencia' => "-", 'valor' => $outrosProventos, 'isento' => false];
            $totalBruto += $outrosProventos;
        }
        
        $adiantamentoSalarial = floatval($input['adiantamento_salarial'] ?? 0);
        if ($adiantamentoSalarial > 0) {
            $items[] = ['categoria' => 'Descontos', 'nome' => 'Adiantamento Salarial', 'referencia' => "-", 'valor' => $adiantamentoSalarial, 'isento' => false];
            $totalDescontos += $adiantamentoSalarial;
        }

        // --- IMPOSTOS E DESCONTOS LEGAIS --- //
        $aplicarSimplificado = filter_var($input['aplicar_desconto_simplificado_ir'] ?? true, FILTER_VALIDATE_BOOLEAN);
        $aplicarRedutor2026 = filter_var($input['incluir_redutor_ir_2026'] ?? true, FILTER_VALIDATE_BOOLEAN);

        // INSS e IRRF sobre Saldo Salario
        if ($valorSaldoSalario > 0) {
            $resInssSalario = $this->descontosService->calcularINSS($valorSaldoSalario);
            $inssSalario = $resInssSalario['desconto'];
            if ($inssSalario > 0) {
                $items[] = ['categoria' => 'Descontos', 'nome' => 'INSS (sobre Saldo Salário)', 'referencia' => "Base R$ " . number_format($valorSaldoSalario, 2, ',', '.'), 'valor' => $inssSalario, 'isento' => false];
                $totalDescontos += $inssSalario;
            }

            $baseIrSalario = $valorSaldoSalario - $inssSalario;
            $resIrSalario = $this->descontosService->calcularIRRF($baseIrSalario, $dependentes, $aplicarSimplificado, $aplicarRedutor2026);
            if ($resIrSalario['desconto'] > 0) {
                $items[] = ['categoria' => 'Descontos', 'nome' => 'IRRF (sobre Saldo Salário)', 'referencia' => "-", 'valor' => $resIrSalario['desconto'], 'isento' => false];
                $totalDescontos += $resIrSalario['desconto'];
            }
        }

        // INSS e IRRF sobre 13o
        if ($valor13 > 0) {
            $resInss13 = $this->descontosService->calcularINSS($valor13);
            $inss13 = $resInss13['desconto'];
            if ($inss13 > 0) {
                $items[] = ['categoria' => 'Descontos', 'nome' => 'INSS (sobre 13º Salário)', 'referencia' => "Base R$ " . number_format($valor13, 2, ',', '.'), 'valor' => $inss13, 'isento' => false];
                $totalDescontos += $inss13;
            }

            $baseIr13 = $valor13 - $inss13;
            $resIr13 = $this->descontosService->calcularIRRF($baseIr13, $dependentes, $aplicarSimplificado, $aplicarRedutor2026);
            if ($resIr13['desconto'] > 0) {
                $items[] = ['categoria' => 'Descontos', 'nome' => 'IRRF (sobre 13º Salário)', 'referencia' => "-", 'valor' => $resIr13['desconto'], 'isento' => false];
                $totalDescontos += $resIr13['desconto'];
            }
        }

        // 6. FGTS
        $strAdmissao = new DateTime($dataAdmissao);
        $strDeslig = new DateTime($dataDesligamentoOriginal);
        $mesesTrabalhados = max(1, ($strAdmissao->diff($strDeslig)->y * 12) + $strAdmissao->diff($strDeslig)->m);
        // Regra burra de estimativa global para quem nao preencheu (salarioBase * mesesTrabalhados)
        $estimativaHistorica = $baseRemuneracao * $mesesTrabalhados;
        
        $baseFgtsMes = $valorSaldoSalario; // Simplificado. Aviso indenizado nao entra FGTS aqui
        $saldoInformado = ($input['saldo_fgts_para_fins_rescisorios'] ?? null) !== null && $input['saldo_fgts_para_fins_rescisorios'] !== '' 
                          ? floatval($input['saldo_fgts_para_fins_rescisorios']) 
                          : null;

        $fgtsParams = $this->fgtsService->calcular(
            $baseFgtsMes, 
            $motivo, 
            $saldoInformado, 
            $estimativaHistorica
        );

        // Preenche retorno
        return [
            'items' => $items,
            'totals' => [
                'bruto' => round($totalBruto, 2),
                'descontos' => round($totalDescontos, 2),
                'liquido' => round($totalBruto - $totalDescontos, 2),
            ],
            'fgts' => $fgtsParams,
            'metadata' => [
                'ano_tabela_irrf' => '2026',
                'ano_tabela_inss' => '2026',
                'timestamp' => date('Y-m-d H:i:s'),
                'premissas_ativas' => [
                    'Aviso prévio indenizado isento de IR/INSS (Padrão)',
                    'Férias indenizadas/proporcionais isentas de IR/INSS (Padrão)',
                    'Simplificação IR e Redutor 2026 habilitados'
                ]
            ]
        ];
    }
}
