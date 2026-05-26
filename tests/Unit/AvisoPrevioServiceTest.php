<?php

namespace Tests\Unit;

use App\Services\AvisoPrevioService;
use PHPUnit\Framework\TestCase;

class AvisoPrevioServiceTest extends TestCase
{
    private AvisoPrevioService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new AvisoPrevioService;
    }

    public function test_calcular_dias_base_menor_de_um_ano(): void
    {
        // 6 meses trabalhados
        $dias = $this->service->calcularDiasAvisoPrevio('2023-01-01', '2023-06-30');
        $this->assertEquals(30, $dias);
    }

    public function test_calcular_dias_com_acrescimo_por_ano(): void
    {
        // Exatamente 1 ano (30 + 3 = 33 dias)
        $dias = $this->service->calcularDiasAvisoPrevio('2022-01-01', '2023-01-01');
        $this->assertEquals(33, $dias);

        // 3 anos completos (30 + 9 = 39 dias)
        $dias2 = $this->service->calcularDiasAvisoPrevio('2020-01-01', '2023-02-15');
        $this->assertEquals(39, $dias2);
    }

    public function test_limite_maximo_90_dias(): void
    {
        // 25 anos trabalhados (deveria dar 30 + 75 = 105), mas o teto é 90.
        $dias = $this->service->calcularDiasAvisoPrevio('1998-01-01', '2023-01-01');
        $this->assertEquals(90, $dias);
    }
}
