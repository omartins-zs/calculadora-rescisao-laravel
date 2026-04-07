<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('short_links', function (Blueprint $table) {
            $table->id();
            $table->string('hash')->index();
            $table->unsignedBigInteger('run_id')->nullable();
            $table->longText('payload_json')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
            
            $table->foreign('run_id')->references('id')->on('calculator_runs')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('short_links');
    }
};
