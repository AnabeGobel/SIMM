<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class usuario extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuarios';

    protected $fillable = [
        'name',
        'email',
        'telefone',
        'foto',
        'password',
        'role',
        'ativo'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Laravel espera que isso retorne a senha
    public function getAuthPassword()
    {
        return $this->password; // aqui deve ser 'password', não 'senha'
    }

}


