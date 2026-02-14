@extends('layouts.panel')
@section('title', 'Dashboard Alumno')
@section('page-title', 'Mis Cursos')

@section('sidebar-nav')
    <a href="{{ route('alumno.dashboard') }}" class="active">
        <span class="nav-icon">🏠</span> Dashboard
    </a>
    <a href="{{ route('alumno.grades') }}">
        <span class="nav-icon">📊</span> Mis Calificaciones
    </a>
    @foreach($courses as $course)
        <a href="{{ route('alumno.course.show', $course) }}">
            <span class="nav-icon">📖</span> {{ Str::limit($course->name, 20) }}
        </a>
    @endforeach
@endsection

@section('content')
    @if($courses->count())
        <div class="course-grid">
            @foreach($courses as $course)
                <div class="course-card">
                    <div class="course-card-header" style="background: linear-gradient(135deg, #10b981, #059669);">
                        <h4>{{ $course->name }}</h4>
                        <span class="course-code">{{ $course->code }}</span>
                    </div>
                    <div class="course-card-body">
                        <div class="meta">
                            <span>👨‍🏫 {{ $course->professor?->name ?? 'Sin profesor' }}</span>
                            <span>📊 {{ $course->credits }} créditos</span>
                        </div>
                        <p style="font-size: 0.8rem; color: var(--text-secondary); margin: 0 0 1rem;">
                            {{ Str::limit($course->description, 100) ?? 'Sin descripción' }}
                        </p>
                        <a href="{{ route('alumno.course.show', $course) }}" class="btn btn-success" style="width: 100%; justify-content: center;">
                            📖 Ver Curso
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <div class="empty-icon">📖</div>
            <p>No estás inscrito en ningún curso.</p>
            <p>Contacta al administrador para inscribirte.</p>
        </div>
    @endif
@endsection
