<!-- resources/views/usuarios/show.blade.php -->
@extends('layouts.app')

@section('title', $usuario->nome . ' - Sistema de Biblioteca')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Detalhes do Usuário</h1>
        <div>
            <a href="{{ route('usuarios.index') }}" class="btn btn-secondary me-2">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
            <a href="{{ route('usuarios.edit', $usuario) }}" class="btn btn-warning text-white">
                <i class="fas fa-edit"></i> Editar
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Informações do Usuário</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">ID:</div>
                        <div class="col-md-8">{{ $usuario->id }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Nome:</div>
                        <div class="col-md-8">{{ $usuario->nome }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">E-mail:</div>
                        <div class="col-md-8">{{ $usuario->email }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Cadastrado em:</div>
                        <div class="col-md-8">{{ $usuario->created_at->format('d/m/Y H:i:s') }}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 fw-bold">Última atualização:</div>
                        <div class="col-md-8">{{ $usuario->updated_at->format('d/m/Y H:i:s') }}</div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Ações</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('emprestimos.create') }}?usuario_id={{ $usuario->id }}" class="btn btn-primary">
                            <i class="fas fa-book-reader"></i> Registrar Novo Empréstimo
                        </a>
                        @php
                        $temEmprestimos = $usuario->emprestimos()->whereNull('data_devolucao')->exists();
                        @endphp
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteUserModal" {{ $temEmprestimos ? 'disabled' : '' }}>
                            <i class="fas fa-trash"></i> Excluir Usuário
                        </button>
                        
                        @if($temEmprestimos)
                        <div class="alert alert-warning mt-2">
                            <i class="fas fa-exclamation-triangle"></i> Este usuário possui livros emprestados e não pode ser excluído.
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Empréstimos Ativos</h5>
                    <span class="badge bg-primary">{{ count($emprestimos) }}</span>
                </div>
                <div class="card-body">
                    @if(count($emprestimos) > 0)
                    <div class="list-group">
                        @foreach($emprestimos as $emprestimo)
                        <a href="{{ route('emprestimos.show', $emprestimo) }}" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">{{ $emprestimo->livro->titulo }}</h6>
                                <small>{{ $emprestimo->data_emprestimo->format('d/m/Y') }}</small>
                            </div>
                            <p class="mb-1">
                                <small class="text-muted">Autor: {{ $emprestimo->livro->autor }}</small>
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small>Devolução prevista: {{ $emprestimo->data_prevista_devolucao->format('d/m/Y') }}</small>
                                @if($emprestimo->estaEmAtraso())
                                <span class="badge bg-danger">Em atraso ({{ abs($emprestimo->diasAteDevolucao()) }} dias)</span>
                                @else
                                <span class="badge bg-info">Em dia (faltam {{ $emprestimo->diasAteDevolucao() }} dias)</span>
                                @endif
                            </div>
                        </a>
                        @endforeach
                    </div>
                    @else
                    <p class="text-center mb-0">Este usuário não possui empréstimos ativos.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Exclusão -->
<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteUserModalLabel">Confirmar Exclusão</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Tem certeza que deseja excluir o usuário "{{ $usuario->nome }}"?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form action="{{ route('usuarios.destroy', $usuario) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Excluir</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection