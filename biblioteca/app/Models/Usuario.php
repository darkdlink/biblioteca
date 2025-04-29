<?php
// app/Models/Usuario.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'email',
    ];

    /**
     * Obtém os empréstimos relacionados a este usuário
     */
    public function emprestimos()
    {
        return $this->hasMany(Emprestimo::class);
    }

    /**
     * Obtém os livros que estão emprestados para este usuário
     */
    public function livrosEmprestados()
    {
        return $this->hasManyThrough(
            Livro::class,
            Emprestimo::class,
            'usuario_id', // Chave estrangeira em emprestimos
            'id', // Chave primária em livros
            'id', // Chave primária em usuarios
            'livro_id' // Chave estrangeira em emprestimos
        )->whereNull('emprestimos.data_devolucao');
    }

    /**
     * Verifica se o usuário já possui o livro emprestado
     */
    public function possuiLivroEmprestado($livroId)
    {
        return $this->emprestimos()
            ->where('livro_id', $livroId)
            ->whereNull('data_devolucao')
            ->exists();
    }

    /**
     * Conta quantos livros o usuário tem emprestados atualmente
     */
    public function quantidadeLivrosEmprestados()
    {
        return $this->emprestimos()
            ->whereNull('data_devolucao')
            ->count();
    }
}