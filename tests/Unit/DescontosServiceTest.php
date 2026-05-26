<?php

namespace Tests\Unit;

use App\Services\DescontosService;
use PHPUnit\Framework\TestCase;

class DescontosServiceTest extends TestCase
{
    private DescontosService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new DescontosService;
    }

    public function test_inss_isento_ou_minimo(): void
    {
        $resultado = $this->service->calcularINSS(1000.00); // Faixa 1 (7.5%)
        $this->assertEquals(75.00, $resultado['desconto']);
        $this->assertFalse($resultado['teto_atingido']);
    }

    public function test_inss_faixas_progressivas(): void
    {
        // Salário de 3000 -> Pega as três primeiras faixas
        $resultado = $this->service->calcularINSS(3000.00);
        // Faixa 1 (7.5% de 1621) = 121.575
        // Faixa 2 (9% de 1281.84) = 115.3656
        // Faixa 3 (12% de 97.16) = 11.6592
        // Total esperado ~= 248.60
        $this->assertEqualsWithDelta(248.60, $resultado['desconto'], 0.01);
    }

    public function test_inss_teto(): void
    {
        // Salário de 10.000 (Teto é 8475.55)
        $resultado = $this->service->calcularINSS(10000.00);
        $this->assertTrue($resultado['teto_atingido']);
        // Desconto teto máximo 2024/2025/2026 ~= 962.24
        $this->assertEqualsWithDelta(988.09, $resultado['desconto'], 0.01);
    }

    public function test_irrf_desconto_simplificado(): void
    {
        // Salário base INSS deduzido = 3000
        $resultado = $this->service->calcularIRRF(3000.00, 0, true, true);

        // Base 3000 -> Com desconto simplificado de 607.20 -> Nova base: 2392.80
        // Como 2392.80 <= 2428.80 (Isento na tabela 2026), desconto esperado é 0
        $this->assertEquals(0, $resultado['desconto']);
    }

    public function test_irrf_desconto_legal_dependentes(): void
    {
        // Salário base 6000 com 5 dependentes
        $resultado = $this->service->calcularIRRF(6000.00, 5, false, false);

        // Dedução dependentes: 5 * 189.59 = 947.95
        // Base Real: 6000 - 947.95 = 5052.05
        // Cai na faixa 27.5% com dedução de 908.73
        // Imposto Bruto: (5052.05 * 0.275) - 908.73 = 1389.31375 - 908.73 = 480.58

        $this->assertEqualsWithDelta(480.58, $resultado['desconto'], 0.01);
    }
}
