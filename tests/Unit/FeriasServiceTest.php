<?php

namespace Tests\Unit;

use App\Services\FeriasService;
use PHPUnit\Framework\TestCase;

class FeriasServiceTest extends TestCase
{
    private FeriasService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new FeriasService;
    }

    public function test_avos_ferias_fracao_maior_15_dias(): void
    {
        // 1 mês e 16 dias => deve contar como 2 avos
        $avos = $this->service->calcularAvosProporcionais('2023-01-01', '2023-02-16');
        $this->assertEquals(2, $avos);
    }

    public function test_avos_ferias_fracao_menor_15_dias(): void
    {
        // 1 mês e 14 dias => deve contar como 1 avo
        $avos = $this->service->calcularAvosProporcionais('2023-01-01', '2023-02-14');
        $this->assertEquals(1, $avos);
    }

    public function test_avos_ferias_exatamente_um_ano(): void
    {
        $avos = $this->service->calcularAvosProporcionais('2022-01-01', '2022-12-31');
        // Deve dar 12 avos
        $this->assertEquals(12, $avos);
    }
}
