@extends('layouts.panel')
@section('title', 'Crear Tarea')
@section('page-title', 'Crear Tarea: ' . $course->name)

@section('sidebar-nav')
    <a href="{{ route('profesor.dashboard') }}">
        <span class="nav-icon">🏠</span> Dashboard
    </a>
    <a href="{{ route('profesor.course.show', $course) }}" class="active">
        <span class="nav-icon">📖</span> {{ Str::limit($course->name, 20) }}
    </a>
@endsection

@section('content')
    <div class="card" style="max-width: 600px;">
        <div class="card-header">
            <h3>📝 Nueva Tarea</h3>
            <a href="{{ route('profesor.course.show', $course) }}" class="btn btn-outline btn-sm">← Volver</a>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('profesor.task.store', $course) }}">
                @csrf

                <div class="form-group">
                    <label for="title">Título de la Tarea</label>
                    <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
                    @error('title') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="description">Instrucciones</label>
                    <textarea name="description" id="description" class="form-control" rows="5">{{ old('description') }}</textarea>
                    @error('description') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="due_date">Fecha de Entrega</label>
                    <input type="datetime-local" name="due_date" id="due_date" class="form-control" value="{{ old('due_date') }}">
                    @error('due_date') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="max_score">Puntaje Máximo</label>
                    <input type="number" name="max_score" id="max_score" class="form-control" value="{{ old('max_score', 100) }}" min="1" max="100" required>
                    @error('max_score') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <button type="submit" class="btn btn-success">💾 Crear Tarea</button>
            </form>
        </div>
    </div>
@endsection
