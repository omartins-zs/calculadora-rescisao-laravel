<?php

namespace Tests\Feature;

use Tests\TestCase;

class RescisaoControllerTest extends TestCase
{
    public function test_api_calcula_retorna_json_valido()
    {
        $response = $this->postJson('/api/calculo/rescisao', [
            'salario_base_mensal' => 3000.00,
            'data_admissao' => '2023-01-01',
            'data_desligamento' => '2024-01-01',
            'motivo_rescisao' => 'dispensa_sem_justa_causa',
            'tipo_aviso_previo' => 'indenizado',
            'possui_ferias_vencidas' => 'nao',
            'dias_trabalhados_no_mes' => 1,
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'items',
            'totals' => [
                'bruto',
                'descontos',
                'liquido',
            ],
            'fgts' => [
                'deposito_mes',
                'saldo_base_utilizado',
                'is_estimativa',
                'percentual_multa',
                'multa',
                'total_fgts_estimado',
            ],
            'metadata',
        ]);
    }

    public function test_api_calcula_falha_com_dados_invalidos()
    {
        $response = $this->postJson('/api/calculo/rescisao', [
            // faltando campos obrigatorios como salario, datas e motivo
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'salario_base_mensal',
            'data_admissao',
            'data_desligamento',
            'motivo_rescisao'
        ]);
    }
}
