<!-- resources/views/livros/show.blade.php -->
@extends('layouts.app')

@section('title', $livro->titulo . ' - Sistema de Biblioteca')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Detalhes do Livro</h1>
        <div>
            <a href="{{ route('livros.index') }}" class="btn btn-secondary me-2">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
            <a href="{{ route('livros.edit', $livro) }}" class="btn btn-warning text-white">
                <i class="fas fa-edit"></i> Editar
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Informações do Livro</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">ID:</div>
                        <div class="col-md-9">{{ $livro->id }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Título:</div>
                        <div class="col-md-9">{{ $livro->titulo }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Autor:</div>
                        <div class="col-md-9">{{ $livro->autor }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Ano:</div>
                        <div class="col-md-9">{{ $livro->ano }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Categoria:</div>
                        <div class="col-md-9">{{ $livro->categoria }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Status:</div>
                        <div class="col-md-9">
                            @if($livro->disponivel)
                            <span class="badge bg-success">Disponível</span>
                            @else
                            <span class="badge bg-danger">Emprestado</span>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 fw-bold">Cadastrado em:</div>
                        <div class="col-md-9">{{ $livro->created_at->format('d/m/Y H:i:s') }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            @if($emprestimo)
            <div class="card mb-4">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">Empréstimo Atual</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Usuário:</strong> {{ $emprestimo->usuario->nome }}
                    </div>
                    <div class="mb-3">
                        <strong>Data do Empréstimo:</strong> {{ $emprestimo->data_emprestimo->format('d/m/Y') }}
                    </div>
                    <div class="mb-3">
                        <strong>Previsão de Devolução:</strong> {{ $emprestimo->data_prevista_devolucao->format('d/m/Y') }}
                    </div>
                    <div class="mb-3">
                        <strong>Status:</strong> 
                        @if($emprestimo->estaEmAtraso())
                        <span class="badge bg-danger">Em atraso ({{ abs($emprestimo->diasAteDevolucao()) }} dias)</span>
                        @else
                        <span class="badge bg-info">Em dia (faltam {{ $emprestimo->diasAteDevolucao() }} dias)</span>
                        @endif
                    </div>
                    <div class="d-grid">
                        <a href="{{ route('emprestimos.show', $emprestimo) }}" class="btn btn-primary">
                            <i class="fas fa-info-circle"></i> Ver Detalhes do Empréstimo
                        </a>
                    </div>
                </div>
            </div>
            @else
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Livro Disponível</h5>
                </div>
                <div class="card-body">
                    <p>Este livro está disponível para empréstimo.</p>
                    <div class="d-grid">
                        <a href="{{ route('emprestimos.create') }}?livro_id={{ $livro->id }}" class="btn btn-primary">
                            <i class="fas fa-book-reader"></i> Registrar Empréstimo
                        </a>
                    </div>
                </div>
            </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Histórico de Empréstimos</h5>
                </div>
                <div class="card-body">
                    @php
                    $historico = $livro->emprestimos()->with('usuario')->latest()->take(5)->get();
                    @endphp
                    
                    @if($historico->count() > 0)
                    <div class="list-group">
                        @foreach($historico as $emp)
                        <a href="{{ route('emprestimos.show', $emp) }}" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">{{ $emp->usuario->nome }}</h6>
                                <small>{{ $emp->data_emprestimo->format('d/m/Y') }}</small>
                            </div>
                            <p class="mb-1">
                                @if($emp->data_devolucao)
                                <span class="badge bg-success">Devolvido em {{ $emp->data_devolucao->format('d/m/Y') }}</span>
                                @elseif($emp->estaEmAtraso())
                                <span class="badge bg-danger">Em atraso</span>
                                @else
                                <span class="badge bg-info">Em andamento</span>
                                @endif
                            </p>
                        </a>
                        @endforeach
                    </div>
                    @else
                    <p class="text-center mb-0">Nenhum empréstimo registrado para este livro.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection