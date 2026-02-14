@extends('layouts.panel')
@section('title', $course->name)
@section('page-title', $course->name . ' (' . $course->code . ')')

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
    {{-- Info del curso --}}
    <div class="card" style="margin-bottom: 1.5rem;">
        <div class="card-body">
            <p><strong>👨‍🏫 Profesor:</strong> {{ $course->professor?->name ?? 'Sin asignar' }}</p>
            <p><strong>📊 Créditos:</strong> {{ $course->credits }}</p>
            @if($course->description)
                <p><strong>📝 Descripción:</strong> {{ $course->description }}</p>
            @endif
        </div>
    </div>

    {{-- Contenido Académico --}}
    <div class="card">
        <div class="card-header">
            <h3>📄 Material del Curso</h3>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Tipo</th>
                        <th>Descripción</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($course->academicContents as $content)
                        <tr>
                            <td style="font-weight: 600;">{{ $content->title }}</td>
                            <td><span class="badge badge-profesor">{{ strtoupper($content->type) }}</span></td>
                            <td>{{ Str::limit($content->description, 60) ?? '—' }}</td>
                            <td>
                                @if($content->file_path)
                                    <a href="{{ route('alumno.content.download', [$course, $content]) }}" class="btn btn-primary btn-sm">📥 Descargar</a>
                                @elseif($content->url)
                                    <a href="{{ $content->url }}" target="_blank" class="btn btn-primary btn-sm">🔗 Abrir</a>
                                @else
                                    —
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" style="text-align: center; color: var(--text-secondary); padding: 2rem;">Sin material disponible.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Tareas --}}
    <div class="card">
        <div class="card-header">
            <h3>📝 Tareas</h3>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Fecha Límite</th>
                        <th>Puntaje</th>
                        <th>Estado</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($course->tasks as $task)
                        @php
                            $submission = $task->submissions->where('user_id', auth()->id())->first();
                        @endphp
                        <tr>
                            <td style="font-weight: 600;">{{ $task->title }}</td>
                            <td>{{ $task->due_date ? $task->due_date->format('d/m/Y H:i') : '—' }}</td>
                            <td>{{ $task->max_score }}</td>
                            <td>
                                @if($submission && $submission->graded_at)
                                    <span class="badge badge-activo">Calificado: {{ $submission->score }}</span>
                                @elseif($submission)
                                    <span class="badge badge-profesor">Enviado</span>
                                @else
                                    <span class="badge badge-inactivo">Pendiente</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('alumno.task.show', [$course, $task]) }}" class="btn btn-outline btn-sm">📋 Ver</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" style="text-align: center; color: var(--text-secondary); padding: 2rem;">Sin tareas asignadas.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
