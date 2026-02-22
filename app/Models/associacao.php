<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class associacao extends Model
{
    // 🔹 Nome da tabela
    protected $table = 'associacoes';

    // 🔹 Campos permitidos para insert/update
    protected $fillable = [
        'nome',
        'responsavel',
        'zona',
        'cor_uniforme',
        'estado'
    ];

    // 🔹 Você usa 'criado_em' em vez de created_at
    public $timestamps = false;
}
