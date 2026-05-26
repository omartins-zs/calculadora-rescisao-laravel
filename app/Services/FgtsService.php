<?php

namespace App\Services;

class FgtsService
{
    /**
     * Calcula estimativa de depósito do mês e as possíveis multas.
     */
    public function calcular(
        float $baseFgts,
        string $motivoRescisao,
        ?float $saldoFgtsInformado = null,
        ?float $estimativaTotalBrutoAoLongoDoTempo = null
    ): array {
        $depositoMes = $baseFgts * 0.08;

        $saldoBaseParaMulta = $saldoFgtsInformado;
        $isEstimativa = false;

        if ($saldoBaseParaMulta === null) {
            $saldoBaseParaMulta = ($estimativaTotalBrutoAoLongoDoTempo ?? 0) * 0.08;
            $isEstimativa = true;
        }

        // Adiciona o do mês na base rescisória, conforme lei o saque tem direito a mesma multa
        $baseTotalComMes = $saldoBaseParaMulta + $depositoMes;

        $multaFgts = 0;
        $percentualMulta = 0;

        if ($motivoRescisao === 'dispensa_sem_justa_causa') {
            $percentualMulta = 0.40;
            $multaFgts = $baseTotalComMes * $percentualMulta;
        } elseif (in_array($motivoRescisao, ['acordo_entre_as_partes', 'culpa_reciproca_forca_maior'])) {
            $percentualMulta = 0.20;
            $multaFgts = $baseTotalComMes * $percentualMulta;
        }

        return [
            'deposito_mes' => round($depositoMes, 2),
            'saldo_base_utilizado' => round($saldoBaseParaMulta, 2),
            'is_estimativa' => $isEstimativa,
            'percentual_multa' => $percentualMulta,
            'multa' => round($multaFgts, 2),
            'total_fgts_estimado' => round($saldoBaseParaMulta + $depositoMes + $multaFgts, 2),
        ];
    }
}
