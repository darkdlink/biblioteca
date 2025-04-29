<!-- resources/views/emprestimos/show.blade.php -->
@extends('layouts.app')

@section('title', 'Detalhes do Empréstimo - Sistema de Biblioteca')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Detalhes do Empréstimo</h1>
        <a href="{{ route('emprestimos.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Informações do Empréstimo</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">ID:</div>
                        <div class="col-md-9">{{ $emprestimo->id }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Usuário:</div>
                        <div class="col-md-9">
                            <a href="{{ route('usuarios.show', $emprestimo->usuario) }}">{{ $emprestimo->usuario->nome }}</a>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Livro:</div>
                        <div class="col-md-9">
                            <a href="{{ route('livros.show', $emprestimo->livro) }}">{{ $emprestimo->livro->titulo }}</a>
                            <small class="text-muted d-block">{{ $emprestimo->livro->autor }}</small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Data de Empréstimo:</div>
                        <div class="col-md-9">{{ $emprestimo->data_emprestimo->format('d/m/Y') }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Previsão de Devolução:</div>
                        <div class="col-md-9">{{ $emprestimo->data_prevista_devolucao->format('d/m/Y') }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Status:</div>
                        <div class="col-md-9">
                            @if($emprestimo->data_devolucao)
                            <span class="badge bg-success">Devolvido em {{ $emprestimo->data_devolucao->format('d/m/Y') }}</span>
                            @elseif($emprestimo->estaEmAtraso())
                            <span class="badge bg-danger">Em atraso ({{ abs($emprestimo->diasAteDevolucao()) }} dias)</span>
                            @else
                            <span class="badge bg-info">Em andamento (faltam {{ $emprestimo->diasAteDevolucao() }} dias)</span>
                            @endif
                        </div>
                    </div>
                    @if($emprestimo->data_devolucao)
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Multa:</div>
                        <div class="col-md-9">
                            @if($emprestimo->multa > 0)
                            <span class="text-danger">R$ {{ number_format($emprestimo->multa, 2, ',', '.') }}</span>
                            @else
                            <span class="text-success">Sem multa</span>
                            @endif
                        </div>
                    </div>
                    @endif
                    <div class="row">
                        <div class="col-md-3 fw-bold">Registrado em:</div>
                        <div class="col-md-9">{{ $emprestimo->created_at->format('d/m/Y H:i:s') }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Ações</h5>
                </div>
                <div class="card-body">
                    @if(!$emprestimo->data_devolucao)
                    <div class="d-grid gap-2 mb-3">
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#devolverModal">
                            <i class="fas fa-undo"></i> Registrar Devolução
                        </button>
                    </div>
                    
                    @if($emprestimo->estaEmAtraso())
                    <div class="alert alert-danger mb-0">
                        <div class="d-flex">
                            <div class="me-3">
                                <i class="fas fa-exclamation-circle fa-2x"></i>
                            </div>
                            <div>
                                <h6 class="alert-heading">Empréstimo em Atraso!</h6>
                                <p class="mb-0">
                                    Este empréstimo está atrasado em {{ abs($emprestimo->diasAteDevolucao()) }} dias.
                                    Ao registrar a devolução, será aplicada uma multa de R$ {{ number_format(abs($emprestimo->diasAteDevolucao()), 2, ',', '.') }}.
                                </p>
                            </div>
                        </div>
                    </div>
                    @endif
                    @else
                    <div class="alert alert-success mb-0">
                        <div class="d-flex">
                            <div class="me-3">
                                <i class="fas fa-check-circle fa-2x"></i>
                            </div>
                            <div>
                                <h6 class="alert-heading">Empréstimo Concluído!</h6>
                                <p class="mb-0">
                                    Este livro foi devolvido em {{ $emprestimo->data_devolucao->format('d/m/Y') }}.
                                    @if($emprestimo->multa > 0)
                                    Foi aplicada uma multa de R$ {{ number_format($emprestimo->multa, 2, ',', '.') }}.
                                    @else
                                    Não foi aplicada nenhuma multa.
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Devolução -->
@if(!$emprestimo->data_devolucao)
<div class="modal fade" id="devolverModal" tabindex="-1" aria-labelledby="devolverModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="devolverModalLabel">Confirmar Devolução</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Confirmar a devolução do livro <strong>{{ $emprestimo->livro->titulo }}</strong> que está emprestado para <strong>{{ $emprestimo->usuario->nome }}</strong>?</p>
                
                @if($emprestimo->estaEmAtraso())
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i> Este empréstimo está <strong>{{ abs($emprestimo->diasAteDevolucao()) }} dias em atraso</strong>. Uma multa de R$ {{ number_format(abs($emprestimo->diasAteDevolucao()), 2, ',', '.') }} será aplicada.
                </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form action="{{ route('emprestimos.devolver', $emprestimo) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success">Confirmar Devolução</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif
@endsection