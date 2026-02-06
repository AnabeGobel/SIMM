<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


    class Ocorrencias extends Model
{
    protected $table = 'ocorrencias';
    public $timestamps = false;

   protected $fillable = [
                'motoqueiro_id',
                'operador_id',
                'tipo',
                'descricao',
                'local',
                'data_ocorrencia',
                'estado',
];
protected $dates = ['criado_em'];

    public function motoqueiro()
    {
        return $this->belongsTo(Motoqueiro::class);
    }

    public function operador()
    {
        return $this->belongsTo(Usuarios::class, 'operador_id');
    }
}
