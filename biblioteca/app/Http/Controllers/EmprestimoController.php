<?php

namespace App\Http\Controllers;

use App\Models\Emprestimo;
use App\Models\Livro;
use App\Models\Usuario;
use Illuminate\Http\Request;
use App\Http\Requests\EmprestimoRequest;
use Carbon\Carbon;

class EmprestimoController extends Controller
{
    /**
     * Exibe uma lista de todos os empréstimos.
     */
    public function index(Request $request)
    {
        $query = Emprestimo::with(['usuario', 'livro']);
        
        // Filtra por status
        if ($request->has('status')) {
            if ($request->status === 'em_andamento') {
                $query->whereNull('data_devolucao');
            } elseif ($request->status === 'devolvido') {
                $query->whereNotNull('data_devolucao');
            } elseif ($request->status === 'atrasado') {
                $query->whereNull('data_devolucao')
                    ->where('data_prevista_devolucao', '<', Carbon::today());
            }
        }
        
        // Filtra por usuário
        if ($request->has('usuario_id') && $request->usuario_id) {
            $query->where('usuario_id', $request->usuario_id);
        }
        
        $emprestimos = $query->orderBy('created_at', 'desc')->paginate(10);
        $usuarios = Usuario::orderBy('nome')->get();
        
        return view('emprestimos.index', compact('emprestimos', 'usuarios'));
    }

    /**
     * Mostra o formulário para criar um novo empréstimo.
     */
    public function create()
    {
        $usuarios = Usuario::orderBy('nome')->get();
        $livros = Livro::where('disponivel', true)->orderBy('titulo')->get();
        
        return view('emprestimos.create', compact('usuarios', 'livros'));
    }

    /**
     * Armazena um empréstimo recém-criado.
     */
    public function store(EmprestimoRequest $request)
    {
        // Verifica se o livro existe e está disponível
        $livro = Livro::findOrFail($request->livro_id);
        
        if (!$livro->estaDisponivel()) {
            return redirect()->back()
                ->with('error', 'Este livro não está disponível para empréstimo.')
                ->withInput();
        }
        
        // Verifica se o usuário existe
        $usuario = Usuario::findOrFail($request->usuario_id);
        
        // Verifica se o usuário já possui o livro emprestado
        if ($usuario->possuiLivroEmprestado($livro->id)) {
            return redirect()->back()
                ->with('error', 'Este usuário já possui este livro emprestado.')
                ->withInput();
        }
        
        // Cria o empréstimo
        $emprestimo = new Emprestimo($request->validated());
        $emprestimo->save();
        
        // Marca o livro como emprestado
        $livro->emprestar();
        
        return redirect()->route('emprestimos.show', $emprestimo)
            ->with('success', 'Empréstimo registrado com sucesso!');
    }

    /**
     * Exibe um empréstimo específico.
     */
    public function show(Emprestimo $emprestimo)
    {
        return view('emprestimos.show', compact('emprestimo'));
    }

    /**
     * Registra a devolução de um livro.
     */
    public function devolver(Emprestimo $emprestimo)
    {
        if (!$emprestimo->estaEmAndamento()) {
            return redirect()->route('emprestimos.show', $emprestimo)
                ->with('error', 'Este empréstimo já foi devolvido.');
        }
        
        $multa = $emprestimo->registrarDevolucao();
        
        if ($multa > 0) {
            $mensagem = "Devolução registrada com sucesso! Multa aplicada: R$ " . number_format($multa, 2, ',', '.');
        } else {
            $mensagem = "Devolução registrada com sucesso!";
        }
        
        return redirect()->route('emprestimos.show', $emprestimo)
            ->with('success', $mensagem);
    }
}