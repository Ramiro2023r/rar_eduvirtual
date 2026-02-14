@extends('layouts.panel')
@section('title', 'Entregas de Tarea')
@section('page-title', 'Entregas: ' . $task->title)

@section('sidebar-nav')
    <a href="{{ route('profesor.dashboard') }}">
        <span class="nav-icon">🏠</span> Dashboard
    </a>
    <a href="{{ route('profesor.course.show', $course) }}" class="active">
        <span class="nav-icon">📖</span> {{ Str::limit($course->name, 20) }}
    </a>
@endsection

@section('content')
    <div style="margin-bottom: 1rem;">
        <a href="{{ route('profesor.course.show', $course) }}" class="btn btn-outline btn-sm">← Volver al Curso</a>
    </div>

    {{-- Info de la tarea --}}
    <div class="card" style="margin-bottom: 1.5rem;">
        <div class="card-body">
            <p><strong>Tarea:</strong> {{ $task->title }}</p>
            <p><strong>Fecha Límite:</strong> {{ $task->due_date ? $task->due_date->format('d/m/Y H:i') : 'Sin límite' }}</p>
            <p><strong>Puntaje Máximo:</strong> {{ $task->max_score }}</p>
            @if($task->description)
                <p><strong>Instrucciones:</strong> {{ $task->description }}</p>
            @endif
        </div>
    </div>

    {{-- Tabla de entregas --}}
    <div class="card">
        <div class="card-header">
            <h3>📊 Entregas de Alumnos ({{ $task->submissions->count() }})</h3>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Alumno</th>
                        <th>Contenido</th>
                        <th>Archivo</th>
                        <th>Fecha Entrega</th>
                        <th>Calificación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($task->submissions as $submission)
                        <tr>
                            <td style="font-weight: 600;">{{ $submission->student->name }}</td>
                            <td>{{ Str::limit($submission->content, 50) ?? '—' }}</td>
                            <td>
                                @if($submission->file_path)
                                    <a href="{{ Storage::url($submission->file_path) }}" target="_blank" class="btn btn-outline btn-sm">📥</a>
                                @else
                                    —
                                @endif
                            </td>
                            <td>{{ $submission->submitted_at?->format('d/m/Y H:i') ?? '—' }}</td>
                            <td>
                                @if($submission->graded_at)
                                    <span class="badge badge-activo">{{ $submission->score }} / {{ $task->max_score }}</span>
                                @else
                                    <span class="badge badge-inactivo">Pendiente</span>
                                @endif
                            </td>
                            <td>
                                <form method="POST" action="{{ route('profesor.submission.grade', [$course, $task, $submission]) }}" style="display: flex; gap: 0.5rem; align-items: center;">
                                    @csrf @method('PUT')
                                    <input type="number" name="score" class="form-control" style="width: 80px; padding: 0.3rem 0.5rem; font-size: 0.8rem;" value="{{ $submission->score }}" min="0" max="{{ $task->max_score }}" step="0.5" required>
                                    <input type="text" name="feedback" class="form-control" style="width: 150px; padding: 0.3rem 0.5rem; font-size: 0.8rem;" value="{{ $submission->feedback }}" placeholder="Feedback...">
                                    <button type="submit" class="btn btn-success btn-sm">✅</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <div class="empty-icon">📝</div>
                                    <p>Ningún alumno ha entregado esta tarea aún.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
