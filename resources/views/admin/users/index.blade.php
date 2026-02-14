@extends('layouts.panel')
@section('title', 'Gestión de Usuarios')
@section('page-title', 'Gestión de Usuarios')

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
    <div class="card">
        <div class="card-header">
            <h3>👥 Listado de Usuarios</h3>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">+ Nuevo Usuario</a>
        </div>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Registro</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td style="font-weight: 600;">{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge badge-{{ $user->role }}">{{ ucfirst($user->role) }}</span>
                            </td>
                            <td>{{ $user->created_at->format('d/m/Y') }}</td>
                            <td>
                                <div style="display: flex; gap: 0.5rem;">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning btn-sm">✏️</a>
                                    @if($user->id !== auth()->id())
                                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('¿Eliminar este usuario?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">🗑️</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <div class="empty-icon">👤</div>
                                    <p>No hay usuarios registrados.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="pagination-wrapper">
        {{ $users->links() }}
    </div>
@endsection
