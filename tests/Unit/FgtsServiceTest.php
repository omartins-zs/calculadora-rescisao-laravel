<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\FgtsService;

class FgtsServiceTest extends TestCase
{
    private FgtsService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new FgtsService();
    }

    public function test_multa_40_por_cento_sem_justa_causa(): void
    {
        // Saldo Fgts base 1000, deposito do mes 80 (Base Salario 1000)
        // Base Total Multa: 1000 + 80 = 1080
        // Multa 40% de 1080 = 432
        $resultado = $this->service->calcular(1000.00, 'dispensa_sem_justa_causa', 1000.00);
        
        $this->assertEquals(80.00, $resultado['deposito_mes']);
        $this->assertEquals(0.40, $resultado['percentual_multa']);
        $this->assertEquals(432.00, $resultado['multa']);
        $this->assertFalse($resultado['is_estimativa']);
    }

    public function test_multa_20_por_cento_acordo(): void
    {
        $resultado = $this->service->calcular(1000.00, 'acordo_entre_as_partes', 1000.00);
        
        $this->assertEquals(0.20, $resultado['percentual_multa']);
        $this->assertEquals(216.00, $resultado['multa']);
    }

    public function test_sem_multa_justa_causa_ou_pedido(): void
    {
        $resultado = $this->service->calcular(1000.00, 'pedido_de_demissao', 1000.00);
        
        $this->assertEquals(0, $resultado['percentual_multa']);
        $this->assertEquals(0, $resultado['multa']);
        // FGTS Total Estimado na rescisao deve ser apenas Saldo + Deposito do Mes (apesar do empregado nao sacar)
        $this->assertEquals(1080.00, $resultado['total_fgts_estimado']);
    }

    public function test_calculo_por_estimativa_quando_saldo_nulo(): void
    {
        // Se a pessoa trabalhou 12 meses e ganhava 2000, estimativa_bruto = 24000
        // Saldo FGTS estimado = 8% de 24000 = 1920
        $resultado = $this->service->calcular(2000.00, 'dispensa_sem_justa_causa', null, 24000.00);
        
        $this->assertTrue($resultado['is_estimativa']);
        $this->assertEquals(1920.00, $resultado['saldo_base_utilizado']);
        
        // Base Multa: 1920 + 160 (deposito mes) = 2080
        // Multa: 40% de 2080 = 832
        $this->assertEquals(832.00, $resultado['multa']);
    }
}
