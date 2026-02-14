@extends('layouts.panel')
@section('title', 'Tarea: ' . $task->title)
@section('page-title', 'Tarea: ' . $task->title)

@section('sidebar-nav')
    <a href="{{ route('alumno.dashboard') }}">
        <span class="nav-icon">🏠</span> Dashboard
    </a>
    <a href="{{ route('alumno.grades') }}">
        <span class="nav-icon">📊</span> Mis Calificaciones
    </a>
    <a href="{{ route('alumno.course.show', $course) }}" class="active">
        <span class="nav-icon">📖</span> {{ Str::limit($course->name, 20) }}
    </a>
@endsection

@section('content')
    <div style="margin-bottom: 1rem;">
        <a href="{{ route('alumno.course.show', $course) }}" class="btn btn-outline btn-sm">← Volver al Curso</a>
    </div>

    {{-- Detalle de la tarea --}}
    <div class="card">
        <div class="card-header">
            <h3>📝 {{ $task->title }}</h3>
        </div>
        <div class="card-body">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                <div>
                    <strong>Fecha Límite:</strong><br>
                    @if($task->due_date)
                        <span style="color: {{ now()->gt($task->due_date) ? 'var(--danger)' : 'var(--success)' }};">
                            {{ $task->due_date->format('d/m/Y H:i') }}
                            @if(now()->gt($task->due_date)) (Vencida) @endif
                        </span>
                    @else
                        Sin límite
                    @endif
                </div>
                <div>
                    <strong>Puntaje Máximo:</strong><br>
                    {{ $task->max_score }} puntos
                </div>
            </div>

            @if($task->description)
                <div style="background: #f8fafc; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
                    <strong>Instrucciones:</strong>
                    <p style="margin: 0.5rem 0 0; white-space: pre-wrap;">{{ $task->description }}</p>
                </div>
            @endif
        </div>
    </div>

    {{-- Estado de entrega --}}
    @if($submission)
        <div class="card">
            <div class="card-header">
                <h3>✅ Tu Entrega</h3>
            </div>
            <div class="card-body">
                <p><strong>Fecha de envío:</strong> {{ $submission->submitted_at?->format('d/m/Y H:i') }}</p>

                @if($submission->content)
                    <p><strong>Contenido:</strong></p>
                    <div style="background: #f8fafc; padding: 1rem; border-radius: 0.5rem; white-space: pre-wrap;">{{ $submission->content }}</div>
                @endif

                @if($submission->file_path)
                    <p style="margin-top: 1rem;">
                        <strong>Archivo:</strong>
                        <a href="{{ Storage::url($submission->file_path) }}" target="_blank" class="btn btn-outline btn-sm">📥 Ver Archivo</a>
                    </p>
                @endif

                @if($submission->graded_at)
                    <div style="margin-top: 1.5rem; padding: 1rem; background: #ecfdf5; border-radius: 0.5rem; border: 1px solid #a7f3d0;">
                        <p style="margin: 0;"><strong>📊 Calificación: {{ $submission->score }} / {{ $task->max_score }}</strong></p>
                        @if($submission->feedback)
                            <p style="margin: 0.5rem 0 0; font-size: 0.875rem;">💬 {{ $submission->feedback }}</p>
                        @endif
                    </div>
                @else
                    <p style="margin-top: 1rem;">
                        <span class="badge badge-profesor">⏳ Pendiente de calificación</span>
                    </p>
                @endif
            </div>
        </div>
    @else
        {{-- Formulario de entrega --}}
        <div class="card">
            <div class="card-header">
                <h3>📤 Enviar Tarea</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('alumno.task.submit', [$course, $task]) }}" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="content">Respuesta / Comentarios</label>
                        <textarea name="content" id="content" class="form-control" rows="5" placeholder="Escribe tu respuesta aquí...">{{ old('content') }}</textarea>
                        @error('content') <div class="form-error">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label for="file">Archivo Adjunto (máx. 10 MB)</label>
                        <input type="file" name="file" id="file" class="form-control">
                        @error('file') <div class="form-error">{{ $message }}</div> @enderror
                    </div>

                    <button type="submit" class="btn btn-success" onclick="return confirm('¿Estás seguro de enviar? Solo puedes enviar una vez.')">
                        📤 Enviar Tarea
                    </button>
                </form>
            </div>
        </div>
    @endif
@endsection
