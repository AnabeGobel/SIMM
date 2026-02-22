<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


    class ocorrencias extends Model
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
        return $this->belongsTo(motoqueiro::class);
    }

    public function operador()
    {
        return $this->belongsTo(usuario::class, 'operador_id');
    }
}
