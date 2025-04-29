<?php
// database/seeders/LivroSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Livro;

class LivroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $livros = [
            [
                'titulo' => 'Dom Casmurro',
                'autor' => 'Machado de Assis',
                'ano' => 1899,
                'categoria' => 'Romance',
                'disponivel' => true
            ],
            [
                'titulo' => 'Memórias Póstumas de Brás Cubas',
                'autor' => 'Machado de Assis',
                'ano' => 1881,
                'categoria' => 'Romance',
                'disponivel' => true
            ],
            [
                'titulo' => 'O Cortiço',
                'autor' => 'Aluísio Azevedo',
                'ano' => 1890,
                'categoria' => 'Romance',
                'disponivel' => true
            ],
            [
                'titulo' => '1984',
                'autor' => 'George Orwell',
                'ano' => 1949,
                'categoria' => 'Ficção Científica',
                'disponivel' => true
            ],
            [
                'titulo' => 'A Revolução dos Bichos',
                'autor' => 'George Orwell',
                'ano' => 1945,
                'categoria' => 'Ficção Política',
                'disponivel' => true
            ],
            [
                'titulo' => 'O Pequeno Príncipe',
                'autor' => 'Antoine de Saint-Exupéry',
                'ano' => 1943,
                'categoria' => 'Infantil',
                'disponivel' => true
            ],
            [
                'titulo' => 'O Senhor dos Anéis: A Sociedade do Anel',
                'autor' => 'J.R.R. Tolkien',
                'ano' => 1954,
                'categoria' => 'Fantasia',
                'disponivel' => true
            ],
            [
                'titulo' => 'O Senhor dos Anéis: As Duas Torres',
                'autor' => 'J.R.R. Tolkien',
                'ano' => 1954,
                'categoria' => 'Fantasia',
                'disponivel' => true
            ],
            [
                'titulo' => 'O Senhor dos Anéis: O Retorno do Rei',
                'autor' => 'J.R.R. Tolkien',
                'ano' => 1955,
                'categoria' => 'Fantasia',
                'disponivel' => true
            ],
            [
                'titulo' => 'O Hobbit',
                'autor' => 'J.R.R. Tolkien',
                'ano' => 1937,
                'categoria' => 'Fantasia',
                'disponivel' => true
            ],
            [
                'titulo' => 'Harry Potter e a Pedra Filosofal',
                'autor' => 'J.K. Rowling',
                'ano' => 1997,
                'categoria' => 'Fantasia',
                'disponivel' => true
            ],
            [
                'titulo' => 'Harry Potter e a Câmara Secreta',
                'autor' => 'J.K. Rowling',
                'ano' => 1998,
                'categoria' => 'Fantasia',
                'disponivel' => true
            ],
            [
                'titulo' => 'Harry Potter e o Prisioneiro de Azkaban',
                'autor' => 'J.K. Rowling',
                'ano' => 1999,
                'categoria' => 'Fantasia',
                'disponivel' => true
            ],
            [
                'titulo' => 'A Culpa é das Estrelas',
                'autor' => 'John Green',
                'ano' => 2012,
                'categoria' => 'Romance',
                'disponivel' => true
            ],
            [
                'titulo' => 'O Código Da Vinci',
                'autor' => 'Dan Brown',
                'ano' => 2003,
                'categoria' => 'Suspense',
                'disponivel' => true
            ],
            [
                'titulo' => 'Orgulho e Preconceito',
                'autor' => 'Jane Austen',
                'ano' => 1813,
                'categoria' => 'Romance',
                'disponivel' => true
            ],
            [
                'titulo' => 'Cem Anos de Solidão',
                'autor' => 'Gabriel García Márquez',
                'ano' => 1967,
                'categoria' => 'Realismo Mágico',
                'disponivel' => true
            ],
            [
                'titulo' => 'O Alquimista',
                'autor' => 'Paulo Coelho',
                'ano' => 1988,
                'categoria' => 'Ficção',
                'disponivel' => true
            ],
            [
                'titulo' => 'A Menina que Roubava Livros',
                'autor' => 'Markus Zusak',
                'ano' => 2005,
                'categoria' => 'Ficção Histórica',
                'disponivel' => true
            ],
            [
                'titulo' => 'O Iluminado',
                'autor' => 'Stephen King',
                'ano' => 1977,
                'categoria' => 'Terror',
                'disponivel' => true
            ]
        ];

        foreach ($livros as $livro) {
            Livro::create($livro);
        }
    }
}
