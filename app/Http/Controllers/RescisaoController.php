<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RescisaoCalculatorService;

class RescisaoController extends Controller
{
    protected RescisaoCalculatorService $calculatorService;

    public function __construct(RescisaoCalculatorService $calculatorService)
    {
        $this->calculatorService = $calculatorService;
    }

    public function index()
    {
        return view('pages.calculadoras.rescisao.index');
    }

    public function comoCalcular()
    {
        return view('pages.calculadoras.rescisao.como-calcular');
    }

    public function multaFgts()
    {
        return view('pages.calculadoras.rescisao.multa-fgts');
    }

    public function multaArtigo477()
    {
        return view('pages.calculadoras.rescisao.multa-artigo-477');
    }

    public function calculate(Request $request)
    {
        // Validação Mínima
        $request->validate([
            'salario_base_mensal' => 'required|numeric|min:0',
            'data_admissao' => 'required|date',
            'data_desligamento' => 'required|date|after_or_equal:data_admissao',
            'motivo_rescisao' => 'required|string',
        ]);

        try {
            $resultado = $this->calculatorService->calcular($request->all());
            return response()->json($resultado);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao processar cálculo corporativo: ' . $e->getMessage()], 400);
        }
    }
}
