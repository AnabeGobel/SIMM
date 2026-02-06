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
        Schema::create('ocorrencias', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedBigInteger('motoqueiro_id'); 
            $table->foreign('motoqueiro_id')->references('id')->on('motoqueiros')->onDelete('cascade'); 
            $table->unsignedBigInteger('operador_id'); 
            $table->foreign('operador_id')->references('id')->on('usuarios')->onDelete('cascade'); 
            $table->string('tipo', 30);
            $table->text('descricao'); 
            $table->string('local', 150);
             $table->timestamp('data_ocorrencia'); 
            $table->string('estado', 20); 
           $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ocorrencias');
    }
};
