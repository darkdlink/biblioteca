<?php
// app/Models/Emprestimo.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Emprestimo extends Model
{
    use HasFactory;

    protected $fillable = [
        'usuario_id',
        'livro_id',
        'data_emprestimo',
        'data_prevista_devolucao',
        'data_devolucao',
        'multa',
    ];

    protected $casts = [
        'data_emprestimo' => 'date',
        'data_prevista_devolucao' => 'date',
        'data_devolucao' => 'date',
        'multa' => 'float',
    ];

    /**
     * Define valor padrão para a data de empréstimo
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($emprestimo) {
            if (!$emprestimo->data_emprestimo) {
                $emprestimo->data_emprestimo = Carbon::today();
            }
            
            if (!$emprestimo->data_prevista_devolucao) {
                $emprestimo->data_prevista_devolucao = Carbon::today()->addDays(14);
            }
        });
    }

    /**
     * Obtém o usuário relacionado a este empréstimo
     */
    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    /**
     * Obtém o livro relacionado a este empréstimo
     */
    public function livro()
    {
        return $this->belongsTo(Livro::class);
    }

    /**
     * Verifica se o empréstimo está em andamento
     */
    public function estaEmAndamento()
    {
        return is_null($this->data_devolucao);
    }

    /**
     * Verifica se o empréstimo está em atraso
     */
    public function estaEmAtraso()
    {
        if (!$this->estaEmAndamento()) {
            return false;
        }

        return Carbon::today()->gt($this->data_prevista_devolucao);
    }

    /**
     * Registra a devolução do livro e calcula a multa, se houver
     */
    public function registrarDevolucao($dataDevolucao = null)
    {
        if (!$this->estaEmAndamento()) {
            return false;
        }

        // Se não for informada uma data, usa a data atual
        $dataDevolucao = $dataDevolucao ?: Carbon::today();
        $this->data_devolucao = $dataDevolucao;

        // Calcula multa para devolução em atraso (R$ 1,00 por dia)
        if ($dataDevolucao->gt($this->data_prevista_devolucao)) {
            $diasAtraso = $dataDevolucao->diffInDays($this->data_prevista_devolucao);
            $this->multa = $diasAtraso * 1.0;
        }

        $this->save();
        
        // Marca o livro como disponível
        $this->livro->devolver();

        return $this->multa;
    }

    /**
     * Calcula quantos dias faltam para a devolução ou quantos dias está em atraso
     */
    public function diasAteDevolucao()
    {
        if (!$this->estaEmAndamento()) {
            return 0;
        }

        $hoje = Carbon::today();
        
        if ($hoje->lte($this->data_prevista_devolucao)) {
            // Retorna dias faltantes (positivo)
            return $hoje->diffInDays($this->data_prevista_devolucao);
        } else {
            // Retorna dias em atraso (negativo)
            return -$this->data_prevista_devolucao->diffInDays($hoje);
        }
    }
}