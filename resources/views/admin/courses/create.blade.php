@extends('layouts.panel')
@section('title', 'Crear Curso')
@section('page-title', 'Crear Nuevo Curso')

@section('sidebar-nav')
    <a href="{{ route('admin.dashboard') }}">
        <span class="nav-icon">🏠</span> Dashboard
    </a>
    <a href="{{ route('admin.users') }}">
        <span class="nav-icon">👥</span> Usuarios
    </a>
    <a href="{{ route('admin.courses') }}" class="active">
        <span class="nav-icon">📖</span> Cursos
    </a>
@endsection

@section('content')
    <div class="card" style="max-width: 600px;">
        <div class="card-header">
            <h3>📖 Nuevo Curso</h3>
            <a href="{{ route('admin.courses') }}" class="btn btn-outline btn-sm">← Volver</a>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.courses.store') }}">
                @csrf

                <div class="form-group">
                    <label for="name">Nombre del Curso</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                    @error('name') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="code">Código <small style="color: var(--text-secondary);">(ej: MAT-101)</small></label>
                    <input type="text" name="code" id="code" class="form-control" value="{{ old('code') }}" required>
                    @error('code') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="description">Descripción</label>
                    <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
                    @error('description') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="professor_id">Profesor Asignado</label>
                    <select name="professor_id" id="professor_id" class="form-control">
                        <option value="">— Sin asignar —</option>
                        @foreach($profesores as $prof)
                            <option value="{{ $prof->id }}" {{ old('professor_id') == $prof->id ? 'selected' : '' }}>
                                {{ $prof->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('professor_id') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="credits">Créditos</label>
                    <input type="number" name="credits" id="credits" class="form-control" value="{{ old('credits', 3) }}" min="1" max="10" required>
                    @error('credits') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <button type="submit" class="btn btn-primary">💾 Crear Curso</button>
            </form>
        </div>
    </div>
@endsection
