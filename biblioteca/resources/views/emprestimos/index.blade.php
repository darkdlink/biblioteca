<!-- resources/views/emprestimos/index.blade.php -->
@extends('layouts.app')

@section('title', 'Empréstimos - Sistema de Biblioteca')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Empréstimos</h1>
        <a href="{{ route('emprestimos.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Novo Empréstimo
        </a>
    </div>

    <!-- Filtros -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('emprestimos.index') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label for="usuario_id" class="form-label">Usuário</label>
                    <select class="form-select" id="usuario_id" name="usuario_id">
                        <option value="">Todos</option>
                        @foreach($usuarios as $user)
                        <option value="{{ $user->id }}" {{ request('usuario_id') == $user->id ? 'selected' : '' }}>{{ $user->nome }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">Todos</option>
                        <option value="em_andamento" {{ request('status') == 'em_andamento' ? 'selected' : '' }}>Em Andamento</option>
                        <option value="devolvido" {{ request('status') == 'devolvido' ? 'selected' : '' }}>Devolvidos</option>
                        <option value="atrasado" {{ request('status') == 'atrasado' ? 'selected' : '' }}>Em Atraso</option>
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search"></i> Filtrar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Lista de Empréstimos -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Usuário</th>
                            <th>Livro</th>
                            <th>Data Empréstimo</th>
                            <th>Previsão Devolução</th>
                            <th>Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($emprestimos as $emprestimo)
                        <tr>
                            <td>{{ $emprestimo->id }}</td>
                            <td>{{ $emprestimo->usuario->nome }}</td>
                            <td>{{ $emprestimo->livro->titulo }}</td>
                            <td>{{ $emprestimo->data_emprestimo->format('d/m/Y') }}</td>
                            <td>{{ $emprestimo->data_prevista_devolucao->format('d/m/Y') }}</td>
                            <td>
                                @if($emprestimo->data_devolucao)
                                <span class="badge rounded-pill bg-success">Devolvido em {{ $emprestimo->data_devolucao->format('d/m/Y') }}</span>
                                @elseif($emprestimo->estaEmAtraso())
                                <span class="badge rounded-pill bg-danger">Em atraso ({{ abs($emprestimo->diasAteDevolucao()) }} dias)</span>
                                @else
                                <span class="badge rounded-pill bg-info">Em andamento (faltam {{ $emprestimo->diasAteDevolucao() }} dias)</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('emprestimos.show', $emprestimo) }}" class="btn btn-sm btn-info text-white">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if(!$emprestimo->data_devolucao)
                                    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#devolverModal{{ $emprestimo->id }}">
                                        <i class="fas fa-undo"></i>
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        <!-- Modal de Devolução -->
                        @if(!$emprestimo->data_devolucao)
                        <div class="modal fade" id="devolverModal{{ $emprestimo->id }}" tabindex="-1" aria-labelledby="devolverModalLabel{{ $emprestimo->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="devolverModalLabel{{ $emprestimo->id }}">Confirmar Devolução</h5>
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
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Nenhum empréstimo encontrado.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Paginação -->
            <div class="d-flex justify-content-center mt-4">
                {{ $emprestimos->links() }}
            </div>
        </div>
    </div>
</div>
@endsection