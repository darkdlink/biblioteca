<?php
// database/seeders/UsuarioSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usuarios = [
            [
                'nome' => 'João Silva',
                'email' => 'joao.silva@email.com'
            ],
            [
                'nome' => 'Maria Oliveira',
                'email' => 'maria.oliveira@email.com'
            ],
            [
                'nome' => 'Pedro Santos',
                'email' => 'pedro.santos@email.com'
            ],
            [
                'nome' => 'Ana Souza',
                'email' => 'ana.souza@email.com'
            ],
            [
                'nome' => 'Carlos Ferreira',
                'email' => 'carlos.ferreira@email.com'
            ],
            [
                'nome' => 'Juliana Costa',
                'email' => 'juliana.costa@email.com'
            ],
            [
                'nome' => 'Roberto Almeida',
                'email' => 'roberto.almeida@email.com'
            ],
            [
                'nome' => 'Fernanda Lima',
                'email' => 'fernanda.lima@email.com'
            ],
            [
                'nome' => 'Lucas Ribeiro',
                'email' => 'lucas.ribeiro@email.com'
            ],
            [
                'nome' => 'Mariana Rodrigues',
                'email' => 'mariana.rodrigues@email.com'
            ]
        ];

        foreach ($usuarios as $usuario) {
            Usuario::create($usuario);
        }
    }
}
