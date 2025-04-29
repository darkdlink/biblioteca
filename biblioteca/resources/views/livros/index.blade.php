<!-- resources/views/livros/index.blade.php -->
@extends('layouts.app')

@section('title', 'Livros - Sistema de Biblioteca')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Livros</h1>
        <a href="{{ route('livros.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Novo Livro
        </a>
    </div>

    <!-- Filtros -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('livros.index') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label for="titulo" class="form-label">Título</label>
                    <input type="text" class="form-control" id="titulo" name="titulo" value="{{ request('titulo') }}">
                </div>
                <div class="col-md-4">
                    <label for="autor" class="form-label">Autor</label>
                    <input type="text" class="form-control" id="autor" name="autor" value="{{ request('autor') }}">
                </div>
                <div class="col-md-2">
                    <label for="disponivel" class="form-label">Disponibilidade</label>
                    <select class="form-select" id="disponivel" name="disponivel">
                        <option value="">Todos</option>
                        <option value="sim" {{ request('disponivel') == 'sim' ? 'selected' : '' }}>Disponíveis</option>
                        <option value="nao" {{ request('disponivel') == 'nao' ? 'selected' : '' }}>Emprestados</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i> Filtrar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Lista de Livros -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Título</th>
                            <th>Autor</th>
                            <th>Ano</th>
                            <th>Categoria</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($livros as $livro)
                        <tr>
                            <td>{{ $livro->id }}</td>
                            <td>{{ $livro->titulo }}</td>
                            <td>{{ $livro->autor }}</td>
                            <td>{{ $livro->ano }}</td>
                            <td>{{ $livro->categoria }}</td>
                            <td>
                                @if($livro->disponivel)
                                <span class="badge rounded-pill bg-success">Disponível</span>
                                @else
                                <span class="badge rounded-pill bg-danger">Emprestado</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('livros.show', $livro) }}" class="btn btn-sm btn-info text-white">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('livros.edit', $livro) }}" class="btn btn-sm btn-warning text-white">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $livro->id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <!-- Modal de Exclusão -->
                        <div class="modal fade" id="deleteModal{{ $livro->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $livro->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel{{ $livro->id }}">Confirmar Exclusão</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Tem certeza que deseja excluir o livro "{{ $livro->titulo }}"?
                                        @if(!$livro->disponivel)
                                        <div class="alert alert-warning mt-3">
                                            <i class="fas fa-exclamation-triangle"></i> Este livro está emprestado e não pode ser excluído.
                                        </div>
                                        @endif
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        @if($livro->disponivel)
                                        <form action="{{ route('livros.destroy', $livro) }}" method="POST">
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
                            <td colspan="7" class="text-center">Nenhum livro encontrado.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Paginação -->
            <div class="d-flex justify-content-center mt-4">
                {{ $livros->links() }}
            </div>
        </div>
    </div>
</div>
@endsection