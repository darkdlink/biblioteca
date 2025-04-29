<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Livro extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'autor',
        'ano',
        'categoria',
        'disponivel'
    ];

    protected $casts = [
        'ano' => 'integer',
        'disponivel' => 'boolean',
    ];

    /**
     * Obtém os empréstimos relacionados a este livro
     */
    public function emprestimos()
    {
        return $this->hasMany(Emprestimo::class);
    }

    /**
     * Verifica se o livro está disponível para empréstimo
     */
    public function estaDisponivel()
    {
        return $this->disponivel;
    }

    /**
     * Marca o livro como emprestado
     */
    public function emprestar()
    {
        if (!$this->disponivel) {
            return false;
        }

        $this->disponivel = false;
        $this->save();
        return true;
    }

    /**
     * Marca o livro como devolvido
     */
    public function devolver()
    {
        if ($this->disponivel) {
            return false;
        }

        $this->disponivel = true;
        $this->save();
        return true;
    }
}
