<?php
namespace App\Http\Controllers;

use App\Models\Livro;
use Illuminate\Http\Request;
use App\Http\Requests\LivroRequest;

class LivroController extends Controller
{
    /**
     * Exibe uma lista de todos os livros.
     */
    public function index(Request $request)
    {
        $query = Livro::query();
        
        // Filtra por título
        if ($request->has('titulo')) {
            $query->where('titulo', 'like', '%' . $request->titulo . '%');
        }
        
        // Filtra por autor
        if ($request->has('autor')) {
            $query->where('autor', 'like', '%' . $request->autor . '%');
        }
        
        // Filtra por disponibilidade
        if ($request->has('disponivel')) {
            $query->where('disponivel', $request->disponivel == 'sim');
        }
        
        $livros = $query->orderBy('titulo')->paginate(10);
        
        return view('livros.index', compact('livros'));
    }

    /**
     * Mostra o formulário para criar um novo livro.
     */
    public function create()
    {
        return view('livros.create');
    }

    /**
     * Armazena um livro recém-criado.
     */
    public function store(LivroRequest $request)
    {
        Livro::create($request->validated());
        
        return redirect()->route('livros.index')
            ->with('success', 'Livro cadastrado com sucesso!');
    }

    /**
     * Exibe um livro específico.
     */
    public function show(Livro $livro)
    {
        // Carrega os empréstimos ativos deste livro
        $emprestimo = $livro->emprestimos()
            ->whereNull('data_devolucao')
            ->with('usuario')
            ->first();
            
        return view('livros.show', compact('livro', 'emprestimo'));
    }

    /**
     * Mostra o formulário para editar um livro.
     */
    public function edit(Livro $livro)
    {
        return view('livros.edit', compact('livro'));
    }

    /**
     * Atualiza um livro específico.
     */
    public function update(LivroRequest $request, Livro $livro)
    {
        $livro->update($request->validated());
        
        return redirect()->route('livros.show', $livro)
            ->with('success', 'Livro atualizado com sucesso!');
    }

    /**
     * Remove um livro.
     */
    public function destroy(Livro $livro)
    {
        // Verifica se o livro está emprestado
        if (!$livro->disponivel) {
            return redirect()->route('livros.show', $livro)
                ->with('error', 'Não é possível remover um livro que está emprestado.');
        }
        
        $livro->delete();
        
        return redirect()->route('livros.index')
            ->with('success', 'Livro removido com sucesso!');
    }
}
