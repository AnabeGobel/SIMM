<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class moto extends Model
{
    protected $table = 'motos';

    protected $fillable = [
        'motoqueiro_id',
        'marca',
        'modelo',
        'cor',
        'placa',
        'numero_mota',
        'ano',
        'estado_legal',
    ];

    public $timestamps = false;

    public function motoqueiro()
    {
        return $this->belongsTo(motoqueiro::class);
    }
}
