<?php

namespace App\Services;

use DateTime;

class DecimoTerceiroService
{
    /**
     * Calcula o número de avos de 13º no ano do desligamento.
     * Regra: fração igual ou superior a 15 dias no mês vigente conta como 1/12.
     */
    public function calcularAvosDecimoTerceiro(string $dataDesligamentoProjetada): int
    {
        $data = new DateTime($dataDesligamentoProjetada);
        $ano = $data->format('Y');

        $meses = 0;
        for ($mes = 1; $mes <= (int) $data->format('m'); $mes++) {
            if ($mes < (int) $data->format('m')) {
                $meses++;
            } else {
                // Mês da rescisão
                $diasNoMes = (int) $data->format('d');
                if ($diasNoMes >= 15) {
                    $meses++;
                }
            }
        }

        return min($meses, 12);
    }
}
