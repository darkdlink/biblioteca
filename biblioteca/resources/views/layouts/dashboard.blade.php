<!-- resources/views/dashboard.blade.php -->
@extends('layouts.app')

@section('title', 'Dashboard - Sistema de Biblioteca')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4">Dashboard</h1>
    
    <!-- Cards de Estatísticas -->
    <div class="row">
        <!-- Total de Livros -->
        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card stat-card bg-primary text-white">
                <div class="card-body p-3">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <div class="icon text-white-50">
                                <i class="fas fa-books fa-3x"></i>
                            </div>
                        </div>
                        <div class="col-8 text-end">
                            <div class="stat-count">{{ $totalLivros }}</div>
                            <div class="stat-name">Livros Cadastrados</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Total de Usuários -->
        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card stat-card bg-success text-white">
                <div class="card-body p-3">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <div class="icon text-white-50">
                                <i class="fas fa-users fa-3x"></i>
                            </div>
                        </div>
                        <div class="col-8 text-end">
                            <div class="stat-count">{{ $totalUsuarios }}</div>
                            <div class="stat-name">Usuários Cadastrados</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Livros Emprestados -->
        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card stat-card bg-info text-white">
                <div class="card-body p-3">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <div class="icon text-white-50">
                                <i class="fas fa-book-reader fa-3x"></i>
                            </div>
                        </div>
                        <div class="col-8 text-end">
                            <div class="stat-count">{{ $livrosEmprestados }}</div>
                            <div class="stat-name">Livros Emprestados</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Empréstimos em Atraso -->
        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card stat-card bg-danger text-white">
                <div class="card-body p-3">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <div class="icon text-white-50">
                                <i class="fas fa-exclamation-circle fa-3x"></i>
                            </div>
                        </div>
                        <div class="col-8 text-end">
                            <div class="stat-count">{{ $emprestimosAtrasados }}</div>
                            <div class="stat-name">Devoluções em Atraso</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Dashboard Content -->
    <div class="row">
        <!-- Empréstimos Recentes -->
        <div class="col-lg-7 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Empréstimos Recentes</h5>
                    <a href="{{ route('emprestimos.index') }}" class="btn btn-sm btn-light">Ver Todos</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Usuário</th>
                                    <th>Livro</th>
                                    <th>Data</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($emprestimosRecentes as $emprestimo)
                                <tr>
                                    <td>{{ $emprestimo->usuario->nome }}</td>
                                    <td>{{ $emprestimo->livro->titulo }}</td>
                                    <td>{{ $emprestimo->data_emprestimo->format('d/m/Y') }}</td>
                                    <td>
                                        @if($emprestimo->data_devolucao)
                                            <span class="badge rounded-pill bg-success">Devolvido</span>
                                        @elseif($emprestimo->estaEmAtraso())
                                            <span class="badge rounded-pill bg-danger">Em atraso</span>
                                        @else
                                            <span class="badge rounded-pill bg-info">Em andamento</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">Nenhum empréstimo encontrado.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Livros Mais Emprestados -->
        <div class="col-lg-5 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Livros Mais Populares</h5>
                    <a href="{{ route('livros.index') }}" class="btn btn-sm btn-light">Ver Todos</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Livro</th>
                                    <th>Autor</th>
                                    <th>Empréstimos</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($livrosMaisEmprestados as $livro)
                                <tr>
                                    <td>{{ $livro->titulo }}</td>
                                    <td>{{ $livro->autor }}</td>
                                    <td>
                                        <span class="badge rounded-pill bg-primary">{{ $livro->emprestimos_count }}</span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center">Nenhum livro emprestado ainda.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Status Summary -->
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Status do Acervo</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-around">
                        <div class="text-center">
                            <div class="p-3 rounded-circle bg-success text-white d-flex align-items-center justify-content-center mx-auto" style="width: 100px; height: 100px;">
                                <span class="fs-4">{{ $livrosDisponiveis }}</span>
                            </div>
                            <div class="mt-2">Disponíveis</div>
                        </div>
                        <div class="text-center">
                            <div class="p-3 rounded-circle bg-warning text-white d-flex align-items-center justify-content-center mx-auto" style="width: 100px; height: 100px;">
                                <span class="fs-4">{{ $livrosEmprestados }}</span>
                            </div>
                            <div class="mt-2">Emprestados</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Status dos Empréstimos</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-around">
                        <div class="text-center">
                            <div class="p-3 rounded-circle bg-info text-white d-flex align-items-center justify-content-center mx-auto" style="width: 100px; height: 100px;">
                                <span class="fs-4">{{ $emprestimosEmAndamento - $emprestimosAtrasados }}</span>
                            </div>
                            <div class="mt-2">Em dia</div>
                        </div>
                        <div class="text-center">
                            <div class="p-3 rounded-circle bg-danger text-white d-flex align-items-center justify-content-center mx-auto" style="width: 100px; height: 100px;">
                                <span class="fs-4">{{ $emprestimosAtrasados }}</span>
                            </div>
                            <div class="mt-2">Em atraso</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection