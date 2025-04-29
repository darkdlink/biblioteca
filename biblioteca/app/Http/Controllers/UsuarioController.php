<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use App\Http\Requests\UsuarioRequest;

class UsuarioController extends Controller
{
    /**
     * Exibe uma lista de todos os usuários.
     */
    public function index(Request $request)
    {
        $query = Usuario::query();
        
        // Filtra por nome
        if ($request->has('nome')) {
            $query->where('nome', 'like', '%' . $request->nome . '%');
        }
        
        // Filtra por email
        if ($request->has('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }
        
        $usuarios = $query->orderBy('nome')->paginate(10);
        
        return view('usuarios.index', compact('usuarios'));
    }

    /**
     * Mostra o formulário para criar um novo usuário.
     */
    public function create()
    {
        return view('usuarios.create');
    }

    /**
     * Armazena um usuário recém-criado.
     */
    public function store(UsuarioRequest $request)
    {
        Usuario::create($request->validated());
        
        return redirect()->route('usuarios.index')
            ->with('success', 'Usuário cadastrado com sucesso!');
    }

    /**
     * Exibe um usuário específico.
     */
    public function show(Usuario $usuario)
    {
        // Carrega os empréstimos ativos deste usuário
        $emprestimos = $usuario->emprestimos()
            ->whereNull('data_devolucao')
            ->with('livro')
            ->get();
            
        return view('usuarios.show', compact('usuario', 'emprestimos'));
    }

    /**
     * Mostra o formulário para editar um usuário.
     */
    public function edit(Usuario $usuario)
    {
        return view('usuarios.edit', compact('usuario'));
    }

    /**
     * Atualiza um usuário específico.
     */
    public function update(UsuarioRequest $request, Usuario $usuario)
    {
        $usuario->update($request->validated());
        
        return redirect()->route('usuarios.show', $usuario)
            ->with('success', 'Usuário atualizado com sucesso!');
    }

    /**
     * Remove um usuário.
     */
    public function destroy(Usuario $usuario)
    {
        // Verifica se o usuário possui livros emprestados
        if ($usuario->quantidadeLivrosEmprestados() > 0) {
            return redirect()->route('usuarios.show', $usuario)
                ->with('error', 'Não é possível remover um usuário que possui livros emprestados.');
        }
        
        $usuario->delete();
        
        return redirect()->route('usuarios.index')
            ->with('success', 'Usuário removido com sucesso!');
    }
}
