<?php
// app/Http/Controllers/DashboardController.php

namespace App\Http\Controllers;

use App\Models\Livro;
use App\Models\Usuario;
use App\Models\Emprestimo;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Exibe o dashboard com estatísticas do sistema.
     */
    public function index()
    {
        // Total de livros, usuários e empréstimos
        $totalLivros = Livro::count();
        $totalUsuarios = Usuario::count();
        $totalEmprestimos = Emprestimo::count();
        
        // Livros disponíveis e emprestados
        $livrosDisponiveis = Livro::where('disponivel', true)->count();
        $livrosEmprestados = Livro::where('disponivel', false)->count();
        
        // Empréstimos em andamento e atrasados
        $emprestimosEmAndamento = Emprestimo::whereNull('data_devolucao')->count();
        $emprestimosAtrasados = Emprestimo::whereNull('data_devolucao')
            ->where('data_prevista_devolucao', '<', Carbon::today())
            ->count();
            
        // Empréstimos recentes
        $emprestimosRecentes = Emprestimo::with(['usuario', 'livro'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            
        // Livros mais emprestados
        $livrosMaisEmprestados = Livro::withCount('emprestimos')
            ->orderBy('emprestimos_count', 'desc')
            ->take(5)
            ->get();
            
        return view('dashboard', compact(
            'totalLivros',
            'totalUsuarios',
            'totalEmprestimos',
            'livrosDisponiveis',
            'livrosEmprestados',
            'emprestimosEmAndamento',
            'emprestimosAtrasados',
            'emprestimosRecentes',
            'livrosMaisEmprestados'
        ));
    }
}