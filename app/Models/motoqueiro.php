<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class motoqueiro extends Model
{
    protected $table = 'motoqueiros';

    protected $fillable = [
        'nome',
        'data_nascimento',
        'endereco',
        'telefone',
        'documento_id',
        'foto',
        'cor_uniforme',
        'associacao_id',
        'paragem_id',
        'estado',
    ];

    public $timestamps = true; // habilita timestamps

    const CREATED_AT = 'criado_em'; // Laravel usa criado_em em vez de created_at
    const UPDATED_AT = null; // Não existe updated_at, então desativa

    public function associacao()
    {
        return $this->belongsTo(associacao::class);
    }

    public function paragem()
    {
        return $this->belongsTo(paragem::class);
    }

    public function motos()
    {
        return $this->hasMany(moto::class);
    }

    public function ocorrencias()
    {
        return $this->hasMany(ocorrencias::class);
    }
}
