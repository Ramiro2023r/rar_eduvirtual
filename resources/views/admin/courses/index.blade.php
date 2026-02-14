@extends('layouts.panel')
@section('title', 'Gestión de Cursos')
@section('page-title', 'Gestión de Cursos')

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
    <div class="card">
        <div class="card-header">
            <h3>📖 Listado de Cursos</h3>
            <a href="{{ route('admin.courses.create') }}" class="btn btn-primary btn-sm">+ Nuevo Curso</a>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Profesor</th>
                        <th>Créditos</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($courses as $course)
                        <tr>
                            <td><strong>{{ $course->code }}</strong></td>
                            <td>{{ $course->name }}</td>
                            <td>{{ $course->professor ? $course->professor->name : '—' }}</td>
                            <td>{{ $course->credits }}</td>
                            <td>
                                <span class="badge badge-{{ $course->status }}">{{ ucfirst($course->status) }}</span>
                            </td>
                            <td>
                                <div style="display: flex; gap: 0.5rem;">
                                    <a href="{{ route('admin.courses.students', $course) }}" class="btn btn-success btn-sm" title="Alumnos">👥</a>
                                    <a href="{{ route('admin.courses.edit', $course) }}" class="btn btn-warning btn-sm">✏️</a>
                                    <form method="POST" action="{{ route('admin.courses.destroy', $course) }}" onsubmit="return confirm('¿Eliminar este curso?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">🗑️</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <div class="empty-icon">📖</div>
                                    <p>No hay cursos creados.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="pagination-wrapper">
        {{ $courses->links() }}
    </div>
@endsection
