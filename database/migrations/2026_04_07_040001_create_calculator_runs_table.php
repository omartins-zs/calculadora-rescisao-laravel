<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('calculator_runs', function (Blueprint $table) {
            $table->id();
            $table->string('calculator_slug')->index();
            $table->json('input_json');
            $table->json('output_json');
            $table->string('hash')->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('calculator_runs');
    }
};
