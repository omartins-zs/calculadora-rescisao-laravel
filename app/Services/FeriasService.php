<?php

namespace App\Services;

use DateTime;

class FeriasService
{
    /**
     * Calcula o número de avos de férias proporcionais no ano de saída.
     * Regra: fração igual ou superior a 15 dias no mês conta como 1/12.
     */
    public function calcularAvosProporcionais(string $dataInicioPeriodoAquisitivo, string $dataDesligamentoProjetada): int
    {
        $inicio = new DateTime($dataInicioPeriodoAquisitivo);
        $fim = new DateTime($dataDesligamentoProjetada);
        
        $meses = 0;
        $atual = clone $inicio;
        
        while ($atual <= $fim) {
            $proxMes = clone $atual;
            $proxMes->modify('+1 month');
            
            if ($proxMes <= $fim) {
                $meses++;
            } else {
                $diasRestantes = $atual->diff($fim)->days + 1; // +1 to include the last day
                if ($diasRestantes >= 15) {
                    $meses++;
                }
            }
            $atual = $proxMes;
        }

        return min($meses, 12);
    }
}
