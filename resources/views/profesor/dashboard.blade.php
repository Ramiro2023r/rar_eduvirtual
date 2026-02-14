@extends('layouts.panel')
@section('title', 'Dashboard Profesor')
@section('page-title', 'Mis Cursos Asignados')

@section('sidebar-nav')
    <a href="{{ route('profesor.dashboard') }}" class="active">
        <span class="nav-icon">🏠</span> Dashboard
    </a>
    @foreach($courses as $course)
        <a href="{{ route('profesor.course.show', $course) }}">
            <span class="nav-icon">📖</span> {{ Str::limit($course->name, 20) }}
        </a>
    @endforeach
@endsection

@section('content')
    @if($courses->count())
        <div class="course-grid">
            @foreach($courses as $course)
                <div class="course-card">
                    <div class="course-card-header">
                        <h4>{{ $course->name }}</h4>
                        <span class="course-code">{{ $course->code }}</span>
                    </div>
                    <div class="course-card-body">
                        <div class="meta">
                            <span>👥 {{ $course->students_count }} alumnos</span>
                            <span>📊 {{ $course->credits }} créditos</span>
                        </div>
                        <p style="font-size: 0.8rem; color: var(--text-secondary); margin: 0 0 1rem;">
                            {{ Str::limit($course->description, 100) ?? 'Sin descripción' }}
                        </p>
                        <a href="{{ route('profesor.course.show', $course) }}" class="btn btn-primary" style="width: 100%; justify-content: center;">
                            📋 Gestionar Curso
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-state">
            <div class="empty-icon">📖</div>
            <p>No tienes cursos asignados.</p>
            <p>Contacta al administrador para que te asigne cursos.</p>
        </div>
    @endif
@endsection
