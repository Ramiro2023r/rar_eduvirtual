@extends('layouts.panel')
@section('title', 'Mis Calificaciones')
@section('page-title', 'Mis Calificaciones')

@section('sidebar-nav')
    <a href="{{ route('alumno.dashboard') }}">
        <span class="nav-icon">🏠</span> Dashboard
    </a>
    <a href="{{ route('alumno.grades') }}" class="active">
        <span class="nav-icon">📊</span> Mis Calificaciones
    </a>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>📊 Historial de Calificaciones</h3>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Curso</th>
                        <th>Tarea</th>
                        <th>Calificación</th>
                        <th>Retroalimentación</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($submissions as $submission)
                        <tr>
                            <td>{{ $submission->task->course->name }}</td>
                            <td style="font-weight: 600;">{{ $submission->task->title }}</td>
                            <td>
                                @php
                                    $pct = ($submission->score / $submission->task->max_score) * 100;
                                    $color = $pct >= 70 ? 'badge-activo' : ($pct >= 50 ? 'badge-profesor' : 'badge-inactivo');
                                @endphp
                                <span class="badge {{ $color }}">
                                    {{ $submission->score }} / {{ $submission->task->max_score }}
                                </span>
                            </td>
                            <td>{{ $submission->feedback ?? '—' }}</td>
                            <td>{{ $submission->graded_at->format('d/m/Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <div class="empty-icon">📊</div>
                                    <p>No tienes calificaciones aún.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
