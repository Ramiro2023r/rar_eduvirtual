@extends('layouts.panel')
@section('title', 'Dashboard Administrativo')
@section('page-title', 'Dashboard Administrativo')

@section('sidebar-nav')
    <a href="{{ route('admin.dashboard') }}" class="active">
        <span class="nav-icon">🏠</span> Dashboard
    </a>
    <a href="{{ route('admin.users') }}">
        <span class="nav-icon">👥</span> Usuarios
    </a>
    <a href="{{ route('admin.courses') }}">
        <span class="nav-icon">📖</span> Cursos
    </a>
@endsection

@section('content')
    {{-- Estadísticas --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon blue">👥</div>
            <div class="stat-value">{{ $stats['totalUsers'] }}</div>
            <div class="stat-label">Usuarios Totales</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon purple">🎓</div>
            <div class="stat-value">{{ $stats['totalProfesores'] }}</div>
            <div class="stat-label">Profesores</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">📝</div>
            <div class="stat-value">{{ $stats['totalAlumnos'] }}</div>
            <div class="stat-label">Alumnos</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon orange">📖</div>
            <div class="stat-value">{{ $stats['totalCourses'] }}</div>
            <div class="stat-label">Cursos</div>
        </div>
    </div>

    {{-- Accesos rápidos --}}
    <div class="card">
        <div class="card-header">
            <h3>⚡ Acciones Rápidas</h3>
        </div>
        <div class="card-body" style="display: flex; gap: 1rem; flex-wrap: wrap;">
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">👤 Nuevo Usuario</a>
            <a href="{{ route('admin.courses.create') }}" class="btn btn-success">📖 Nuevo Curso</a>
            <a href="{{ route('admin.users') }}" class="btn btn-outline">📋 Ver Todos los Usuarios</a>
        </div>
    </div>
@endsection
