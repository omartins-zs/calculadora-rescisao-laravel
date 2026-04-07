<?php

namespace App\Services;

use DateTime;
use DateInterval;

class AvisoPrevioService
{
    /**
     * Calcula os dias de aviso prévio proporcional ao tempo de serviço (Lei 12.506/2011).
     */
    public function calcularDiasAvisoPrevio(string $dataAdmissao, string $dataDesligamento): int
    {
        $admissao = new DateTime($dataAdmissao);
        $desligamento = new DateTime($dataDesligamento);
        $intervalo = $admissao->diff($desligamento);

        $anosCompletos = $intervalo->y;
        
        $diasBase = 30;
        $diasAdicionais = $anosCompletos * 3;
        
        // Máximo de 90 dias
        return min($diasBase + $diasAdicionais, 90);
    }
}
