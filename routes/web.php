<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RescisaoController;

Route::get('/', function () {
    return redirect('/calculadora-rescisao-trabalhista');
});

Route::get('/calculadora-rescisao-trabalhista', [RescisaoController::class, 'index']);
Route::redirect('/calculadora-rescisao-clt', '/calculadora-rescisao-trabalhista', 301);

Route::get('/como-calcular-rescisao-trabalhista', [RescisaoController::class, 'comoCalcular']);
Route::get('/multa-fgts-40-por-cento', [RescisaoController::class, 'multaFgts']);
Route::get('/multa-artigo-477-clt', [RescisaoController::class, 'multaArtigo477']);

Route::post('/api/calculo/rescisao', [RescisaoController::class, 'calculate']);
