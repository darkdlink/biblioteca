<!-- resources/views/livros/edit.blade.php -->
@extends('layouts.app')

@section('title', 'Editar Livro - Sistema de Biblioteca')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Editar Livro</h1>
        <a href="{{ route('livros.show', $livro) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('livros.update', $livro) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="titulo" class="form-label">Título <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('titulo') is-invalid @enderror" id="titulo" name="titulo" value="{{ old('titulo', $livro->titulo) }}" required>
                        @error('titulo')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label for="autor" class="form-label">Autor <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('autor') is-invalid @enderror" id="autor" name="autor" value="{{ old('autor', $livro->autor) }}" required>
                        @error('autor')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="ano" class="form-label">Ano de Publicação <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('ano') is-invalid @enderror" id="ano" name="ano" value="{{ old('ano', $livro->ano) }}" min="1000" max="{{ date('Y') }}" required>
                        @error('ano')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label for="categoria" class="form-label">Categoria <span class="text-danger">*</span></label>
                        <select class="form-select @error('categoria') is-invalid @enderror" id="categoria" name="categoria" required>
                            <option value="">Selecione...</option>
                            <option value="Romance" {{ old('categoria', $livro->categoria) == 'Romance' ? 'selected' : '' }}>Romance</option>
                            <option value="Ficção Científica" {{ old('categoria', $livro->categoria) == 'Ficção Científica' ? 'selected' : '' }}>Ficção Científica</option>
                            <option value="Fantasia" {{ old('categoria', $livro->categoria) == 'Fantasia' ? 'selected' : '' }}>Fantasia</option>
                            <option value="Biografia" {{ old('categoria', $livro->categoria) == 'Biografia' ? 'selected' : '' }}>Biografia</option>
                            <option value="História" {{ old('categoria', $livro->categoria) == 'História' ? 'selected' : '' }}>História</option>
                            <option value="Autoajuda" {{ old('categoria', $livro->categoria) == 'Autoajuda' ? 'selected' : '' }}>Autoajuda</option>
                            <option value="Infantil" {{ old('categoria', $livro->categoria) == 'Infantil' ? 'selected' : '' }}>Infantil</option>
                            <option value="Técnico" {{ old('categoria', $livro->categoria) == 'Técnico' ? 'selected' : '' }}>Técnico</option>
                            <option value="Didático" {{ old('categoria', $livro->categoria) == 'Didático' ? 'selected' : '' }}>Didático</option>
                            <option value="Outro" {{ old('categoria', $livro->categoria) == 'Outro' ? 'selected' : '' }}>Outro</option>
                        </select>
                        @error('categoria')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Salvar Alterações
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection