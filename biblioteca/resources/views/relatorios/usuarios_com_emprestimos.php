@extends('layouts.app')

@section('title', 'Usuários com Empréstimos - Sistema de Biblioteca')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Relatório de Usuários com Empréstimos</h1>
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
    </div>
    
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Usuários com Livros Emprestados</h5>
            <span class="badge bg-primary">{{ $usuarios->total() }} usuários</span>
        </div>
        <div class="card-body">
            @if($usuarios->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Empréstimos Ativos</th>
                                <th>Empréstimos em Atraso</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($usuarios as $usuario)
                            @php
                                $emprestimosAtivos = $usuario->emprestimos()->whereNull('data_devolucao')->count();
                                $emprestimosAtrasados = $usuario->emprestimos()
                                    ->whereNull('data_devolucao')
                                    ->where('data_prevista_devolucao', '<', \Carbon\Carbon::today())
                                    ->count();
                            @endphp
                            <tr>
                                <td>{{ $usuario->id }}</td>
                                <td>{{ $usuario->nome }}</td>
                                <td>{{ $usuario->email }}</td>
                                <td>
                                    <span class="badge rounded-pill bg-primary">{{ $emprestimosAtivos }}</span>
                                </td>
                                <td>
                                    @if($emprestimosAtrasados > 0)
                                        <span class="badge rounded-pill bg-danger">{{ $emprestimosAtrasados }}</span>
                                    @else
                                        <span class="badge rounded-pill bg-success">0</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('usuarios.show', $usuario) }}" class="btn btn-sm btn-info text-white">
                                            <i class="fas fa-eye"></i> Detalhes
                                        </a>
                                        <a href="{{ route('emprestimos.create') }}?usuario_id={{ $usuario->id }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-book-reader"></i> Novo Empréstimo
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Paginação -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $usuarios->links() }}
                </div>
            @else
                <div class="alert alert-info mb-0">
                    <div class="d-flex">
                        <div class="me-3">
                            <i class="fas fa-info-circle fa-2x"></i>
                        </div>
                        <div>
                            <h5 class="alert-heading">Nenhum empréstimo ativo</h5>
                            <p class="mb-0">
                                Não há usuários com livros emprestados no momento.
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    
    <!-- Estatísticas Rápidas -->
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Total de Usuários com Empréstimos</h5>
                    <p class="card-text display-4">{{ $usuarios->total() }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Usuários em Dia</h5>
                    <p class="card-text display-4">
                        {{ $usuarios->filter(function($usuario) {
                            return !$usuario->emprestimos()
                                ->whereNull('data_devolucao')
                                ->where('data_prevista_devolucao', '<', \Carbon\Carbon::today())
                                ->exists();
                        })->count() }}
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <h5 class="card-title">Usuários com Atrasos</h5>
                    <p class="card-text display-4">
                        {{ $usuarios->filter(function($usuario) {
                            return $usuario->emprestimos()
                                ->whereNull('data_devolucao')
                                ->where('data_prevista_devolucao', '<', \Carbon\Carbon::today())
                                ->exists();
                        })->count() }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection