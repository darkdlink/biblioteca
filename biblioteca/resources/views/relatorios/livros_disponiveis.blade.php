@extends('layouts.app')

@section('title', 'Livros Disponíveis - Sistema de Biblioteca')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Relatório de Livros Disponíveis</h1>
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
    </div>
    
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Livros Disponíveis para Empréstimo</h5>
            <span class="badge bg-success">{{ $livros->total() }} livros</span>
        </div>
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
                                <div class="btn-group" role="group">
                                    <a href="{{ route('livros.show', $livro) }}" class="btn btn-sm btn-info text-white">
                                        <i class="fas fa-eye"></i> Detalhes
                                    </a>
                                    <a href="{{ route('emprestimos.create') }}?livro_id={{ $livro->id }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-book-reader"></i> Emprestar
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Nenhum livro disponível encontrado.</td>
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