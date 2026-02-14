@extends('layouts.panel')
@section('title', 'Alumnos del Curso')
@section('page-title', 'Alumnos: ' . $course->name)

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
    {{-- Inscribir alumno --}}
    <div class="card" style="max-width: 600px;">
        <div class="card-header">
            <h3>➕ Inscribir Alumno</h3>
            <a href="{{ route('admin.courses') }}" class="btn btn-outline btn-sm">← Volver a Cursos</a>
        </div>
        <div class="card-body">
            @if($alumnos->count())
                <form method="POST" action="{{ route('admin.courses.enroll', $course) }}" style="display: flex; gap: 0.75rem; align-items: flex-end;">
                    @csrf
                    <div class="form-group" style="flex: 1; margin-bottom: 0;">
                        <label for="user_id">Seleccionar Alumno</label>
                        <select name="user_id" id="user_id" class="form-control" required>
                            <option value="">— Seleccionar —</option>
                            @foreach($alumnos as $alumno)
                                <option value="{{ $alumno->id }}">{{ $alumno->name }} ({{ $alumno->email }})</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success">📝 Inscribir</button>
                </form>
            @else
                <p style="color: var(--text-secondary); font-size: 0.875rem;">Todos los alumnos ya están inscritos en este curso.</p>
            @endif
        </div>
    </div>

    {{-- Lista de inscritos --}}
    <div class="card">
        <div class="card-header">
            <h3>👥 Alumnos Inscritos ({{ $course->students->count() }})</h3>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Fecha Inscripción</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($course->students as $student)
                        <tr>
                            <td style="font-weight: 600;">{{ $student->name }}</td>
                            <td>{{ $student->email }}</td>
                            <td>{{ $student->pivot->created_at?->format('d/m/Y') ?? '—' }}</td>
                            <td>
                                <form method="POST" action="{{ route('admin.courses.unenroll', [$course, $student]) }}" onsubmit="return confirm('¿Remover a este alumno del curso?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">❌ Remover</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">
                                <div class="empty-state">
                                    <div class="empty-icon">📝</div>
                                    <p>No hay alumnos inscritos en este curso.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
