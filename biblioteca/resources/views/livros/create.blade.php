<!-- resources/views/livros/create.blade.php -->
@extends('layouts.app')

@section('title', 'Novo Livro - Sistema de Biblioteca')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Novo Livro</h1>
        <a href="{{ route('livros.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('livros.store') }}" method="POST">
                @csrf
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="titulo" class="form-label">Título <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('titulo') is-invalid @enderror" id="titulo" name="titulo" value="{{ old('titulo') }}" required>
                        @error('titulo')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label for="autor" class="form-label">Autor <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('autor') is-invalid @enderror" id="autor" name="autor" value="{{ old('autor') }}" required>
                        @error('autor')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="ano" class="form-label">Ano de Publicação <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('ano') is-invalid @enderror" id="ano" name="ano" value="{{ old('ano') }}" min="1000" max="{{ date('Y') }}" required>
                        @error('ano')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label for="categoria" class="form-label">Categoria <span class="text-danger">*</span></label>
                        <select class="form-select @error('categoria') is-invalid @enderror" id="categoria" name="categoria" required>
                            <option value="">Selecione...</option>
                            <option value="Romance" {{ old('categoria') == 'Romance' ? 'selected' : '' }}>Romance</option>
                            <option value="Ficção Científica" {{ old('categoria') == 'Ficção Científica' ? 'selected' : '' }}>Ficção Científica</option>
                            <option value="Fantasia" {{ old('categoria') == 'Fantasia' ? 'selected' : '' }}>Fantasia</option>
                            <option value="Biografia" {{ old('categoria') == 'Biografia' ? 'selected' : '' }}>Biografia</option>
                            <option value="História" {{ old('categoria') == 'História' ? 'selected' : '' }}>História</option>
                            <option value="Autoajuda" {{ old('categoria') == 'Autoajuda' ? 'selected' : '' }}>Autoajuda</option>
                            <option value="Infantil" {{ old('categoria') == 'Infantil' ? 'selected' : '' }}>Infantil</option>
                            <option value="Técnico" {{ old('categoria') == 'Técnico' ? 'selected' : '' }}>Técnico</option>
                            <option value="Didático" {{ old('categoria') == 'Didático' ? 'selected' : '' }}>Didático</option>
                            <option value="Outro" {{ old('categoria') == 'Outro' ? 'selected' : '' }}>Outro</option>
                        </select>
                        @error('categoria')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Salvar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection