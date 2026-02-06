<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuariosSeeder extends Seeder
{
    public function run()
    {
        // Array de usuários para popular
        $usuarios = [
            [
                'name' => 'Administrador',
                'email' => 'admin@exemplo.com',
                'password' => Hash::make('123456'),
                'role' => 'admin',
                'ativo' => 1,
                'telefone' => '+244 912 000 000',
                'foto' => 'default.png', // valor padrão
            ],
            [
                'name' => 'Operador Teste',
                'email' => 'operador@exemplo.com',
                'password' => Hash::make('123456'),
                'role' => 'operador',
                'ativo' => 1,
                'telefone' => '+244 912 111 111',
                'foto' => 'default.png',
            ]
        ];

        foreach ($usuarios as $usuario) {
            // Evita duplicidade usando updateOrInsert
            DB::table('usuarios')->updateOrInsert(
                ['email' => $usuario['email']], // condição de verificação
                array_merge($usuario, [
                    'updated_at' => now(),
                    'created_at' => now(),
                ])
            );
        }
    }
}
