@extends('layouts.app')

@section('title', 'Empréstimos em Atraso - Sistema de Biblioteca')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Relatório de Empréstimos em Atraso</h1>
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
    </div>
    
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Empréstimos com Devolução em Atraso</h5>
            <span class="badge bg-danger">{{ $emprestimos->total() }} empréstimos</span>
        </div>
        <div class="card-body">
            @if($emprestimos->count() > 0)
                <div class="alert alert-warning mb-4">
                    <div class="d-flex">
                        <div class="me-3">
                            <i class="fas fa-exclamation-triangle fa-2x"></i>
                        </div>
                        <div>
                            <h5 class="alert-heading">Atenção!</h5>
                            <p class="mb-0">
                                Os empréstimos listados abaixo estão com a devolução em atraso. 
                                Entre em contato com os usuários para regularizar a situação.
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Usuário</th>
                                <th>Livro</th>
                                <th>Data Empréstimo</th>
                                <th>Previsão Devolução</th>
                                <th>Dias em Atraso</th>
                                <th>Multa Estimada</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($emprestimos as $emprestimo)
                            <tr>
                                <td>{{ $emprestimo->id }}</td>
                                <td>
                                    <a href="{{ route('usuarios.show', $emprestimo->usuario) }}">
                                        {{ $emprestimo->usuario->nome }}
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('livros.show', $emprestimo->livro) }}">
                                        {{ $emprestimo->livro->titulo }}
                                    </a>
                                </td>
                                <td>{{ $emprestimo->data_emprestimo->format('d/m/Y') }}</td>
                                <td>{{ $emprestimo->data_prevista_devolucao->format('d/m/Y') }}</td>
                                <td class="text-danger fw-bold">{{ abs($emprestimo->diasAteDevolucao()) }}</td>
                                <td class="text-danger fw-bold">R$ {{ number_format(abs($emprestimo->diasAteDevolucao()), 2, ',', '.') }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('emprestimos.show', $emprestimo) }}" class="btn btn-sm btn-info text-white">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#devolverModal{{ $emprestimo->id }}">
                                            <i class="fas fa-undo"></i>
                                        </button>
                                    </div>
                                    
                                    <!-- Modal de Devolução -->
                                    <div class="modal fade" id="devolverModal{{ $emprestimo->id }}" tabindex="-1" aria-labelledby="devolverModalLabel{{ $emprestimo->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="devolverModalLabel{{ $emprestimo->id }}">Confirmar Devolução</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Confirmar a devolução do livro <strong>{{ $emprestimo->livro->titulo }}</strong> que está emprestado para <strong>{{ $emprestimo->usuario->nome }}</strong>?</p>
                                                    
                                                    <div class="alert alert-warning">
                                                        <i class="fas fa-exclamation-triangle"></i> Este empréstimo está <strong>{{ abs($emprestimo->diasAteDevolucao()) }} dias em atraso</strong>. Uma multa de R$ {{ number_format(abs($emprestimo->diasAteDevolucao()), 2, ',', '.') }} será aplicada.
                                                    </div>
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
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Paginação -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $emprestimos->links() }}
                </div>
            @else
                <div class="alert alert-success mb-0">
                    <div class="d-flex">
                        <div class="me-3">
                            <i class="fas fa-check-circle fa-2x"></i>
                        </div>
                        <div>
                            <h5 class="alert-heading">Parabéns!</h5>
                            <p class="mb-0">
                                Não há empréstimos em atraso no momento. Continue o bom trabalho!
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection