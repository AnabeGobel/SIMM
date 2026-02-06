<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('motos', function (Blueprint $table) {
            $table->id(); $table->unsignedBigInteger('motoqueiro_id'); 
            $table->foreign('motoqueiro_id')->references('id')->on('motoqueiros')->onDelete('cascade'); 
            $table->string('marca', 50); $table->string('modelo', 50); 
            $table->string('cor', 30); 
            $table->string('placa', 20); $table->string('numero_mota', 50); 
            $table->integer('ano'); 
            $table->string('estado_legal', 20); 
            $table->timestamp('criado_em')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('motos');
    }
};
