<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paragem extends Model
{
    protected $table = 'paragens';

    // Campos que podem ser preenchidos em massa
    protected $fillable = [
        'nome',
        'bairro',
        'criado_em',
    ];

    // Caso queira desativar os timestamps padrão (created_at, updated_at)
    public $timestamps = false;

    // adicionar relacionamentos futuros aqui
    // Exemplo:
    // public function motoqueiros() {
    //     return $this->hasMany(Motoqueiro::class);
    // }
}
