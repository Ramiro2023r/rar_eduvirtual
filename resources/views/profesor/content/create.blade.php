@extends('layouts.panel')
@section('title', 'Subir Contenido')
@section('page-title', 'Subir Contenido: ' . $course->name)

@section('sidebar-nav')
    <a href="{{ route('profesor.dashboard') }}">
        <span class="nav-icon">🏠</span> Dashboard
    </a>
    <a href="{{ route('profesor.course.show', $course) }}" class="active">
        <span class="nav-icon">📖</span> {{ Str::limit($course->name, 20) }}
    </a>
@endsection

@section('content')
    <div class="card" style="max-width: 600px;">
        <div class="card-header">
            <h3>📄 Subir Contenido Académico</h3>
            <a href="{{ route('profesor.course.show', $course) }}" class="btn btn-outline btn-sm">← Volver</a>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('profesor.content.store', $course) }}" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="title">Título</label>
                    <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
                    @error('title') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="description">Descripción</label>
                    <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
                </div>

                <div class="form-group">
                    <label for="type">Tipo de Contenido</label>
                    <select name="type" id="type" class="form-control" required onchange="toggleFields()">
                        <option value="pdf">📄 PDF / Documento</option>
                        <option value="video">🎥 Video (URL)</option>
                        <option value="enlace">🔗 Enlace Externo</option>
                        <option value="otro">📁 Otro</option>
                    </select>
                </div>

                <div class="form-group" id="file-group">
                    <label for="file">Archivo (máx. 10 MB)</label>
                    <input type="file" name="file" id="file" class="form-control">
                    @error('file') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <div class="form-group" id="url-group" style="display: none;">
                    <label for="url">URL</label>
                    <input type="url" name="url" id="url" class="form-control" placeholder="https://...">
                    @error('url') <div class="form-error">{{ $message }}</div> @enderror
                </div>

                <button type="submit" class="btn btn-primary">📤 Subir Contenido</button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function toggleFields() {
        const type = document.getElementById('type').value;
        const fileGroup = document.getElementById('file-group');
        const urlGroup = document.getElementById('url-group');

        if (type === 'video' || type === 'enlace') {
            fileGroup.style.display = 'none';
            urlGroup.style.display = 'block';
        } else {
            fileGroup.style.display = 'block';
            urlGroup.style.display = 'none';
        }
    }
</script>
@endpush
