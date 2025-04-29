<?php
// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LivroController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\EmprestimoController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Aqui é onde você pode registrar rotas web para sua aplicação. Estas
| rotas são carregadas pelo RouteServiceProvider e todas elas serão
| atribuídas ao grupo de middleware "web".
|
*/

// Rota principal (dashboard)
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Rotas para Livros
Route::resource('livros', LivroController::class);

// Rotas para Usuários
Route::resource('usuarios', UsuarioController::class);

// Rotas para Empréstimos
Route::resource('emprestimos', EmprestimoController::class)->except(['edit', 'update', 'destroy']);

// Rota para registrar devolução
Route::post('/emprestimos/{emprestimo}/devolver', [EmprestimoController::class, 'devolver'])->name('emprestimos.devolver');

// Rotas para relatórios
Route::prefix('relatorios')->name('relatorios.')->group(function () {
    // Livros disponíveis
    Route::get('/livros-disponiveis', function () {
        $livros = App\Models\Livro::where('disponivel', true)->orderBy('titulo')->paginate(15);
        return view('relatorios.livros_disponiveis', compact('livros'));
    })->name('livros-disponiveis');
    
    // Empréstimos em atraso
    Route::get('/emprestimos-atrasados', function () {
        $emprestimos = App\Models\Emprestimo::whereNull('data_devolucao')
            ->where('data_prevista_devolucao', '<', Carbon\Carbon::today())
            ->with(['usuario', 'livro'])
            ->orderBy('data_prevista_devolucao')
            ->paginate(15);
        return view('relatorios.emprestimos_atrasados', compact('emprestimos'));
    })->name('emprestimos-atrasados');
    
    // Usuários com livros emprestados
    Route::get('/usuarios-com-emprestimos', function () {
        $usuarios = App\Models\Usuario::whereHas('emprestimos', function ($query) {
            $query->whereNull('data_devolucao');
        })->withCount(['emprestimos' => function ($query) {
            $query->whereNull('data_devolucao');
        }])->orderBy('emprestimos_count', 'desc')->paginate(15);
        
        return view('relatorios.usuarios_com_emprestimos', compact('usuarios'));
    })->name('usuarios-com-emprestimos');
});