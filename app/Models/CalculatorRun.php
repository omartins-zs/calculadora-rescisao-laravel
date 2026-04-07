<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CalculatorRun extends Model
{
    protected $fillable = ['calculator_slug', 'input_json', 'output_json', 'hash'];

    protected $casts = [
        'input_json' => 'array',
        'output_json' => 'array',
    ];
}
