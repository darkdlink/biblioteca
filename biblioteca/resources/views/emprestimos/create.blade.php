<!-- resources/views/emprestimos/create.blade.php -->
@extends('layouts.app')

@section('title', 'Novo Empréstimo - Sistema de Biblioteca')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Novo Empréstimo</h1>
        <a href="{{ route('emprestimos.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('emprestimos.store') }}" method="POST">
                @csrf
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="usuario_id" class="form-label">Usuário <span class="text-danger">*</span></label>
                        <select class="form-select @error('usuario_id') is-invalid @enderror" id="usuario_id" name="usuario_id" required>
                            <option value="">Selecione o usuário</option>
                            @foreach($usuarios as $usuario)
                            <option value="{{ $usuario->id }}" {{ old('usuario_id', request('usuario_id')) == $usuario->id ? 'selected' : '' }}>{{ $usuario->nome }} ({{ $usuario->email }})</option>
                            @endforeach
                        </select>
                        @error('usuario_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label for="livro_id" class="form-label">Livro <span class="text-danger">*</span></label>
                        <select class="form-select @error('livro_id') is-invalid @enderror" id="livro_id" name="livro_id" required>
                            <option value="">Selecione o livro</option>
                            @foreach($livros as $livro)
                            <option value="{{ $livro->id }}" {{ old('livro_id', request('livro_id')) == $livro->id ? 'selected' : '' }}>{{ $livro->titulo }} ({{ $livro->autor }})</option>
                            @endforeach
                        </select>
                        @error('livro_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="data_emprestimo" class="form-label">Data do Empréstimo</label>
                        <input type="date" class="form-control @error('data_emprestimo') is-invalid @enderror" id="data_emprestimo" name="data_emprestimo" value="{{ old('data_emprestimo', date('Y-m-d')) }}">
                        @error('data_emprestimo')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label for="data_prevista_devolucao" class="form-label">Data Prevista para Devolução</label>
                        <input type="date" class="form-control @error('data_prevista_devolucao') is-invalid @enderror" id="data_prevista_devolucao" name="data_prevista_devolucao" value="{{ old('data_prevista_devolucao', date('Y-m-d', strtotime('+14 days'))) }}">
                        @error('data_prevista_devolucao')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Registrar Empréstimo
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection