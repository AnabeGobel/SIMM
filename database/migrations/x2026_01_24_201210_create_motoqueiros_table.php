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
        Schema::create('motoqueiros', function (Blueprint $table) {
            $table->id(); 
            $table->string('nome', 100); 
            $table->date('data_nascimento');
            $table->string('endereco', 150); 
            $table->string('telefone', 20); 
            $table->string('documento_id', 50);
            $table->string('foto', 255); 
            $table->string('cor_uniforme', 50); 
            $table->unsignedBigInteger('associacao_id');
            $table->unsignedBigInteger('paragem_id'); 
            $table->foreign('associacao_id')->references('id')->on('associacoes'); 
            $table->foreign('paragem_id')->references('id')->on('paragens');
            $table->string('estado', 20); 
            $table->timestamp('criado_em')->useCurrent(); // usado como created_at
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('motoqueiros');
    }
};
