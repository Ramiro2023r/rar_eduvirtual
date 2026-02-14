@extends('layouts.panel')
@section('title', $course->name)
@section('page-title', $course->name . ' (' . $course->code . ')')

@section('sidebar-nav')
    <a href="{{ route('profesor.dashboard') }}">
        <span class="nav-icon">🏠</span> Dashboard
    </a>
    <a href="{{ route('profesor.course.show', $course) }}" class="active">
        <span class="nav-icon">📖</span> {{ Str::limit($course->name, 20) }}
    </a>
@endsection

@section('content')
    {{-- Estadísticas del curso --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon blue">👥</div>
            <div class="stat-value">{{ $course->students->count() }}</div>
            <div class="stat-label">Alumnos Inscritos</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">📄</div>
            <div class="stat-value">{{ $course->academicContents->count() }}</div>
            <div class="stat-label">Material</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon purple">📝</div>
            <div class="stat-value">{{ $course->tasks->count() }}</div>
            <div class="stat-label">Tareas</div>
        </div>
    </div>

    {{-- Contenido Académico --}}
    <div class="card">
        <div class="card-header">
            <h3>📄 Contenido Académico</h3>
            <a href="{{ route('profesor.content.create', $course) }}" class="btn btn-primary btn-sm">+ Subir Contenido</a>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Tipo</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($course->academicContents as $content)
                        <tr>
                            <td style="font-weight: 600;">{{ $content->title }}</td>
                            <td><span class="badge badge-profesor">{{ strtoupper($content->type) }}</span></td>
                            <td>{{ $content->created_at->format('d/m/Y') }}</td>
                            <td>
                                <form method="POST" action="{{ route('profesor.content.destroy', [$course, $content]) }}" onsubmit="return confirm('¿Eliminar?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">🗑️</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" style="text-align: center; color: var(--text-secondary); padding: 2rem;">Sin contenido aún.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Tareas --}}
    <div class="card">
        <div class="card-header">
            <h3>📝 Tareas y Evaluaciones</h3>
            <a href="{{ route('profesor.task.create', $course) }}" class="btn btn-success btn-sm">+ Nueva Tarea</a>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Fecha Límite</th>
                        <th>Puntaje Máx.</th>
                        <th>Entregas</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($course->tasks as $task)
                        <tr>
                            <td style="font-weight: 600;">{{ $task->title }}</td>
                            <td>{{ $task->due_date ? $task->due_date->format('d/m/Y H:i') : '—' }}</td>
                            <td>{{ $task->max_score }}</td>
                            <td>
                                <a href="{{ route('profesor.task.submissions', [$course, $task]) }}" class="btn btn-outline btn-sm">
                                    📊 {{ $task->submissions->count() }} entregas
                                </a>
                            </td>
                            <td>
                                <form method="POST" action="{{ route('profesor.task.destroy', [$course, $task]) }}" onsubmit="return confirm('¿Eliminar?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">🗑️</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" style="text-align: center; color: var(--text-secondary); padding: 2rem;">Sin tareas aún.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Alumnos --}}
    <div class="card">
        <div class="card-header">
            <h3>👥 Alumnos Inscritos</h3>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($course->students as $student)
                        <tr>
                            <td style="font-weight: 600;">{{ $student->name }}</td>
                            <td>{{ $student->email }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="2" style="text-align: center; color: var(--text-secondary); padding: 2rem;">Sin alumnos inscritos.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
