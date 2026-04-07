<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShortLink extends Model
{
    protected $fillable = ['hash', 'run_id', 'payload_json', 'expires_at'];

    protected $casts = [
        'payload_json' => 'array',
        'expires_at' => 'datetime',
    ];

    public function run()
    {
        return $this->belongsTo(CalculatorRun::class, 'run_id');
    }
}
