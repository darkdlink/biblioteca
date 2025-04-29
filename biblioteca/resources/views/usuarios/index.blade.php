<!-- resources/views/usuarios/index.blade.php -->
@extends('layouts.app')

@section('title', 'Usuários - Sistema de Biblioteca')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Usuários</h1>
        <a href="{{ route('usuarios.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Novo Usuário
        </a>
    </div>

    <!-- Filtros -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('usuarios.index') }}" method="GET" class="row g-3">
                <div class="col-md-5">
                    <label for="nome" class="form-label">Nome</label>
                    <input type="text" class="form-control" id="nome" name="nome" value="{{ request('nome') }}">
                </div>
                <div class="col-md-5">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="text" class="form-control" id="email" name="email" value="{{ request('email') }}">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i> Filtrar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Lista de Usuários -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>Livros Emprestados</th>
                            <th>Cadastrado em</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($usuarios as $usuario)
                        <tr>
                            <td>{{ $usuario->id }}</td>
                            <td>{{ $usuario->nome }}</td>
                            <td>{{ $usuario->email }}</td>
                            <td>
                                @php
                                $qtdEmprestados = $usuario->emprestimos()->whereNull('data_devolucao')->count();
                                @endphp
                                @if($qtdEmprestados > 0)
                                <span class="badge rounded-pill bg-primary">{{ $qtdEmprestados }}</span>
                                @else
                                <span class="badge rounded-pill bg-secondary">0</span>
                                @endif
                            </td>
                            <td>{{ $usuario->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('usuarios.show', $usuario) }}" class="btn btn-sm btn-info text-white">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('usuarios.edit', $usuario) }}" class="btn btn-sm btn-warning text-white">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $usuario->id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <!-- Modal de Exclusão -->
                        <div class="modal fade" id="deleteModal{{ $usuario->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $usuario->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel{{ $usuario->id }}">Confirmar Exclusão</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Tem certeza que deseja excluir o usuário "{{ $usuario->nome }}"?
                                        @if($qtdEmprestados > 0)
                                        <div class="alert alert-warning mt-3">
                                            <i class="fas fa-exclamation-triangle"></i> Este usuário possui livros emprestados e não pode ser excluído.
                                        </div>
                                        @endif
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        @if($qtdEmprestados == 0)
                                        <form action="{{ route('usuarios.destroy', $usuario) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Excluir</button>
                                        </form>
                                        @else
                                        <button type="button" class="btn btn-danger" disabled>Excluir</button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Nenhum usuário encontrado.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Paginação -->
            <div class="d-flex justify-content-center mt-4">
                {{ $usuarios->links() }}
            </div>
        </div>
    </div>
</div>
@endsection