<?php

namespace Tests\Unit;

use App\Services\DecimoTerceiroService;
use PHPUnit\Framework\TestCase;

class DecimoTerceiroServiceTest extends TestCase
{
    private DecimoTerceiroService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new DecimoTerceiroService;
    }

    public function test_calcular_avos_no_ano_completo(): void
    {
        // Se desligou em 31/12, recebe 12 avos
        $avos = $this->service->calcularAvosDecimoTerceiro('2023-12-31');
        $this->assertEquals(12, $avos);
    }

    public function test_calcular_avos_fracao_maior_15_dias_no_mes(): void
    {
        // Saiu em 15/03 (Março). Janeiro, Fevereiro e Março contam. (3 avos)
        $avos = $this->service->calcularAvosDecimoTerceiro('2023-03-15');
        $this->assertEquals(3, $avos);
    }

    public function test_calcular_avos_fracao_menor_15_dias_no_mes(): void
    {
        // Saiu em 14/03. Janeiro e Fevereiro contam. Março não conta. (2 avos)
        $avos = $this->service->calcularAvosDecimoTerceiro('2023-03-14');
        $this->assertEquals(2, $avos);
    }
}
