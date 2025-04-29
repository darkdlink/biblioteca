<?php
// database/seeders/EmprestimoSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Emprestimo;
use App\Models\Livro;
use Carbon\Carbon;

class EmprestimoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Empréstimos em andamento
        $emprestimos = [
            // Empréstimos em dia
            [
                'usuario_id' => 1,
                'livro_id' => 1,
                'data_emprestimo' => Carbon::today()->subDays(5),
                'data_prevista_devolucao' => Carbon::today()->addDays(9),
                'data_devolucao' => null,
                'multa' => 0
            ],
            [
                'usuario_id' => 2,
                'livro_id' => 4,
                'data_emprestimo' => Carbon::today()->subDays(3),
                'data_prevista_devolucao' => Carbon::today()->addDays(11),
                'data_devolucao' => null,
                'multa' => 0
            ],
            [
                'usuario_id' => 3,
                'livro_id' => 7,
                'data_emprestimo' => Carbon::today()->subDays(2),
                'data_prevista_devolucao' => Carbon::today()->addDays(12),
                'data_devolucao' => null,
                'multa' => 0
            ],
            
            // Empréstimos em atraso
            [
                'usuario_id' => 4,
                'livro_id' => 10,
                'data_emprestimo' => Carbon::today()->subDays(20),
                'data_prevista_devolucao' => Carbon::today()->subDays(6),
                'data_devolucao' => null,
                'multa' => 0
            ],
            [
                'usuario_id' => 5,
                'livro_id' => 13,
                'data_emprestimo' => Carbon::today()->subDays(25),
                'data_prevista_devolucao' => Carbon::today()->subDays(11),
                'data_devolucao' => null,
                'multa' => 0
            ]
        ];

        // Empréstimos devolvidos
        $emprestimosDevolvidos = [
            // Devolvidos sem atraso
            [
                'usuario_id' => 6,
                'livro_id' => 16,
                'data_emprestimo' => Carbon::today()->subDays(30),
                'data_prevista_devolucao' => Carbon::today()->subDays(16),
                'data_devolucao' => Carbon::today()->subDays(20),
                'multa' => 0
            ],
            [
                'usuario_id' => 7,
                'livro_id' => 17,
                'data_emprestimo' => Carbon::today()->subDays(25),
                'data_prevista_devolucao' => Carbon::today()->subDays(11),
                'data_devolucao' => Carbon::today()->subDays(15),
                'multa' => 0
            ],
            
            // Devolvidos com atraso
            [
                'usuario_id' => 8,
                'livro_id' => 18,
                'data_emprestimo' => Carbon::today()->subDays(40),
                'data_prevista_devolucao' => Carbon::today()->subDays(26),
                'data_devolucao' => Carbon::today()->subDays(20),
                'multa' => 6.0
            ],
            [
                'usuario_id' => 9,
                'livro_id' => 19,
                'data_emprestimo' => Carbon::today()->subDays(35),
                'data_prevista_devolucao' => Carbon::today()->subDays(21),
                'data_devolucao' => Carbon::today()->subDays(10),
                'multa' => 11.0
            ]
        ];

        // Combina os arrays
        $todosEmprestimos = array_merge($emprestimos, $emprestimosDevolvidos);

        // Cria os empréstimos e atualiza o status dos livros
        foreach ($todosEmprestimos as $emprestimo) {
            // Cria o empréstimo
            Emprestimo::create($emprestimo);
            
            // Se não tiver data de devolução, marca o livro como indisponível
            if ($emprestimo['data_devolucao'] === null) {
                $livro = Livro::find($emprestimo['livro_id']);
                $livro->disponivel = false;
                $livro->save();
            }
        }
    }
}