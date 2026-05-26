<?php

namespace App\Services;

class DescontosService
{
    /**
     * Cálculo Progressivo do INSS 2026.
     */
    public function calcularINSS(float $salarioBase, bool $isTetoSugerido = false): array
    {
        // Tabela de INSS hipotética para 2026 segundo instruções
        // Faixa 1: até 1.621,00 (7,5%)
        // Faixa 2: 1.621,01 a 2.902,84 (9%)
        // Faixa 3: 2.902,85 a 4.354,27 (12%)
        // Faixa 4: 4.354,28 a 8.475,55 (14%)

        $teto = 8475.55;
        $baseCalculo = min($salarioBase, $teto);

        $descontoTotal = 0;

        $faixas = [
            ['limite_min' => 0, 'limite_max' => 1621.00, 'aliquota' => 0.075],
            ['limite_min' => 1621.00, 'limite_max' => 2902.84, 'aliquota' => 0.09],
            ['limite_min' => 2902.84, 'limite_max' => 4354.27, 'aliquota' => 0.12],
            ['limite_min' => 4354.27, 'limite_max' => $teto, 'aliquota' => 0.14],
        ];

        foreach ($faixas as $faixa) {
            if ($baseCalculo > $faixa['limite_min']) {
                $valorAtributavel = min($baseCalculo, $faixa['limite_max']) - $faixa['limite_min'];
                $descontoTotal += $valorAtributavel * $faixa['aliquota'];
            }
        }

        return [
            'base' => $baseCalculo,
            'desconto' => $descontoTotal,
            'teto_atingido' => ($salarioBase >= $teto),
        ];
    }

    /**
     * Cálculo de Imposto de Renda pela Tabela 2026.
     */
    public function calcularIRRF(
        float $baseIr,
        int $dependentes = 0,
        bool $aplicarDescontoSimplificado = true,
        bool $incluirRedutor2026 = true
    ): array {
        // Tabela 2026
        // até 2.428,80: isento
        // 2.428,81–2.826,65: 7,5% deduz 182,16
        // 2.826,66–3.751,05: 15% deduz 394,16
        // 3.751,06–4.664,68: 22,5% deduz 675,49
        // acima: 27,5% deduz 908,73

        $deducaoPorDependente = 189.59;
        $descontoSimplificadoMaximo = 607.20; // 25% do menor valor, porém é um teto comum. O prompt diz: "até 607,20" (Assumimos o valor fixo teto como padrão de desconto simplificado em cálculo completo, se melhor). Vamos usar 607.20.

        // Dedução Legal
        $deducaoDependentesReal = $dependentes * $deducaoPorDependente;

        // Verifica o que é mais vantajoso (Simplificado ou Legal)
        $valorDeducaoAplicada = $deducaoDependentesReal;

        if ($aplicarDescontoSimplificado && $descontoSimplificadoMaximo > $deducaoDependentesReal) {
            $valorDeducaoAplicada = $descontoSimplificadoMaximo;
        }

        // Calculo INSS é passado no baseIr (já deduzido do baseIr de fora, antes de chamar aqui)

        $baseCalculoReal = $baseIr - $valorDeducaoAplicada;
        if ($baseCalculoReal < 0) {
            $baseCalculoReal = 0;
        }

        $impostoBruto = 0;

        if ($baseCalculoReal <= 2428.80) {
            $impostoBruto = 0;
        } elseif ($baseCalculoReal <= 2826.65) {
            $impostoBruto = ($baseCalculoReal * 0.075) - 182.16;
        } elseif ($baseCalculoReal <= 3751.05) {
            $impostoBruto = ($baseCalculoReal * 0.15) - 394.16;
        } elseif ($baseCalculoReal <= 4664.68) {
            $impostoBruto = ($baseCalculoReal * 0.225) - 675.49;
        } else {
            $impostoBruto = ($baseCalculoReal * 0.275) - 908.73;
        }

        // Redutor 2026
        // até 5.000,00: reduzir até zerar o imposto (limite 312,89)
        // 5.000,01–7.350,00: redução = 978,62 - (0,133145 * rendimentos tributáveis (baseIr inicial sem dedução))
        // acima: sem redução

        if ($incluirRedutor2026 && $impostoBruto > 0) {
            $redutor = 0;
            if ($baseIr <= 5000) {
                $redutor = min($impostoBruto, 312.89);
            } elseif ($baseIr <= 7350) {
                $redutorPossivel = 978.62 - (0.133145 * $baseIr);
                $redutor = max(0, min($impostoBruto, $redutorPossivel));
            }
            $impostoBruto -= $redutor;
        }

        return [
            'base' => $baseIr,
            'deducao_usada' => $valorDeducaoAplicada,
            'desconto' => max(0, $impostoBruto),
        ];
    }
}
