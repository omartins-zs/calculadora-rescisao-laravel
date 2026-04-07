<?php

namespace Tests\Feature;

use App\Services\RescisaoCalculatorService;
use App\Services\AvisoPrevioService;
use App\Services\FeriasService;
use App\Services\DecimoTerceiroService;
use App\Services\FgtsService;
use App\Services\DescontosService;
use Tests\TestCase;

class RescisaoMotorTest extends TestCase
{
    protected RescisaoCalculatorService $service;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->service = new RescisaoCalculatorService(
            new AvisoPrevioService(),
            new FeriasService(),
            new DecimoTerceiroService(),
            new FgtsService(),
            new DescontosService()
        );
    }

    public function test_demissao_sem_justa_causa()
    {
        $input = [
            'salario_base_mensal' => 3000,
            'data_admissao' => '2023-01-01',
            'data_desligamento' => '2025-01-01', // 2 anos completos
            'motivo_rescisao' => 'dispensa_sem_justa_causa',
            'tipo_aviso_previo' => 'indenizado',
            'possui_ferias_vencidas' => 'sim',
            'qtd_periodos_ferias_vencidas' => 1,
            'dias_trabalhados_no_mes' => 10,
        ];

        $resultado = $this->service->calcular($input);

        $this->assertArrayHasKey('items', $resultado);
        $this->assertArrayHasKey('totals', $resultado);
        $this->assertArrayHasKey('fgts', $resultado);
        
        // Verifica Saldo de Salário: (3000 / 30) * 10 = 1000
        $saldoSalario = collect($resultado['items'])->firstWhere('nome', 'Saldo de Salário');
        $this->assertNotNull($saldoSalario);
        $this->assertEquals(1000, $saldoSalario['valor']);

        // Verifica Aviso: 2 anos geram 30 + (2*3) = 36 dias. (3000 / 30) * 36 = 3600
        $aviso = collect($resultado['items'])->firstWhere('nome', 'Aviso Prévio Indenizado');
        $this->assertNotNull($aviso);
        $this->assertEquals(3600, $aviso['valor']);

        // Verifica Férias Vencidas + 1/3: 3000 + 1000 = 4000
        $feriasVencidas = collect($resultado['items'])->firstWhere('nome', 'Férias Vencidas + 1/3');
        $this->assertNotNull($feriasVencidas);
        $this->assertEquals(4000, $feriasVencidas['valor']);
        
        $this->assertEquals(0.40, $resultado['fgts']['percentual_multa']);
        $this->assertTrue($resultado['totals']['liquido'] > 0);
    }

    public function test_pedido_de_demissao()
    {
        $input = [
            'salario_base_mensal' => 2000,
            'data_admissao' => '2023-01-01',
            'data_desligamento' => '2024-06-15',
            'motivo_rescisao' => 'pedido_de_demissao',
            'tipo_aviso_previo' => 'indenizado', // Ele não cumpriu
            'dias_trabalhados_no_mes' => 15,
        ];

        $resultado = $this->service->calcular($input);

        // Desconto do aviso não cumprido (30 dias = 2000)
        $descontoAviso = collect($resultado['items'])->firstWhere('nome', 'Desconto Aviso Prévio não cumprido');
        $this->assertNotNull($descontoAviso);
        $this->assertEquals(2000, $descontoAviso['valor']);

        // Sem multa de FGTS
        $this->assertEquals(0, $resultado['fgts']['percentual_multa']);
        $this->assertEquals(0, $resultado['fgts']['multa']);
    }
}
