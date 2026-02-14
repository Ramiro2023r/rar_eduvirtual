@extends('layouts.panel')
@section('title', 'Editar Usuario')
@section('page-title', 'Editar Usuario')

@section('sidebar-nav')
    <a href="{{ route('admin.dashboard') }}">
        <span class="nav-icon">🏠</span> Dashboard
    </a>
    <a href="{{ route('admin.users') }}" class="active">
        <span class="nav-icon">👥</span> Usuarios
    </a>
    <a href="{{ route('admin.courses') }}">
        <span class="nav-icon">📖</span> Cursos
    </a>
@endsection

@section('content')
    <div class="card" style="max-width: 600px;">
        <div class="card-header">
            <h3>✏️ Editar: {{ $user->name }}</h3>
            <a href="{{ route('admin.users') }}" class="btn btn-outline btn-sm">← Volver</a>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.users.update', $user) }}">
                @csrf @method('PUT')

                <div class="form-group">
                    <label for="name">Nombre Completo</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                    @error('name') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                    @error('email') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="role">Rol</label>
                    <select name="role" id="role" class="form-control" required>
                        <option value="alumno" {{ $user->role === 'alumno' ? 'selected' : '' }}>Alumno</option>
                        <option value="profesor" {{ $user->role === 'profesor' ? 'selected' : '' }}>Profesor</option>
                        <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Administrador</option>
                    </select>
                    @error('role') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="password">Nueva Contraseña <small style="color: var(--text-secondary);">(dejar vacío para no cambiar)</small></label>
                    <input type="password" name="password" id="password" class="form-control">
                    @error('password') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirmar Contraseña</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary">💾 Actualizar</button>
            </form>
        </div>
    </div>
@endsection
