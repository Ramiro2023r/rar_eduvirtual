<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Profesor\ProfesorController;
use App\Http\Controllers\Alumno\AlumnoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| EDUVIRTUAL - Rutas Web
|--------------------------------------------------------------------------
| Cada grupo de rutas está protegido por middleware 'auth' + 'role:xxx'
| para garantizar acceso exclusivo por rol.
|--------------------------------------------------------------------------
*/

// ─── Página de inicio (pública) ─────────────────────────────
Route::get('/', function () {
    return view('welcome');
});

// ─── Redirección post-login según rol ───────────────────────
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();

        return match ($user->role) {
            'admin'    => redirect()->route('admin.dashboard'),
            'profesor' => redirect()->route('profesor.dashboard'),
            'alumno'   => redirect()->route('alumno.dashboard'),
            default    => redirect()->route('alumno.dashboard'),
        };
    })->name('dashboard');
});

// ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
// RUTAS DE ADMINISTRADOR
// ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

    // CRUD de usuarios
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
    Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');

    // Gestión de cursos
    Route::get('/courses', [AdminController::class, 'courses'])->name('courses');
    Route::get('/courses/create', [AdminController::class, 'createCourse'])->name('courses.create');
    Route::post('/courses', [AdminController::class, 'storeCourse'])->name('courses.store');
    Route::get('/courses/{course}/edit', [AdminController::class, 'editCourse'])->name('courses.edit');
    Route::put('/courses/{course}', [AdminController::class, 'updateCourse'])->name('courses.update');
    Route::delete('/courses/{course}', [AdminController::class, 'destroyCourse'])->name('courses.destroy');

    // Inscripción de alumnos en cursos
    Route::get('/courses/{course}/students', [AdminController::class, 'courseStudents'])->name('courses.students');
    Route::post('/courses/{course}/students', [AdminController::class, 'enrollStudent'])->name('courses.enroll');
    Route::delete('/courses/{course}/students/{user}', [AdminController::class, 'unenrollStudent'])->name('courses.unenroll');
});

// ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
// RUTAS DE PROFESOR
// ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
Route::middleware(['auth', 'role:profesor'])->prefix('profesor')->name('profesor.')->group(function () {

    // Dashboard
    Route::get('/', [ProfesorController::class, 'dashboard'])->name('dashboard');

    // Ver curso
    Route::get('/courses/{course}', [ProfesorController::class, 'showCourse'])->name('course.show');

    // Contenido académico
    Route::get('/courses/{course}/content/create', [ProfesorController::class, 'createContent'])->name('content.create');
    Route::post('/courses/{course}/content', [ProfesorController::class, 'storeContent'])->name('content.store');
    Route::delete('/courses/{course}/content/{content}', [ProfesorController::class, 'destroyContent'])->name('content.destroy');

    // Tareas
    Route::get('/courses/{course}/tasks/create', [ProfesorController::class, 'createTask'])->name('task.create');
    Route::post('/courses/{course}/tasks', [ProfesorController::class, 'storeTask'])->name('task.store');
    Route::delete('/courses/{course}/tasks/{task}', [ProfesorController::class, 'destroyTask'])->name('task.destroy');

    // Calificaciones
    Route::get('/courses/{course}/tasks/{task}/submissions', [ProfesorController::class, 'taskSubmissions'])->name('task.submissions');
    Route::put('/courses/{course}/tasks/{task}/submissions/{submission}', [ProfesorController::class, 'gradeSubmission'])->name('submission.grade');
});

// ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
// RUTAS DE ALUMNO
// ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
Route::middleware(['auth', 'role:alumno'])->prefix('alumno')->name('alumno.')->group(function () {

    // Dashboard
    Route::get('/', [AlumnoController::class, 'dashboard'])->name('dashboard');

    // Ver curso
    Route::get('/courses/{course}', [AlumnoController::class, 'showCourse'])->name('course.show');

    // Descargar contenido
    Route::get('/courses/{course}/content/{content}/download', [AlumnoController::class, 'downloadContent'])->name('content.download');

    // Tareas
    Route::get('/courses/{course}/tasks/{task}', [AlumnoController::class, 'showTask'])->name('task.show');
    Route::post('/courses/{course}/tasks/{task}/submit', [AlumnoController::class, 'submitTask'])->name('task.submit');

    // Calificaciones
    Route::get('/grades', [AlumnoController::class, 'grades'])->name('grades');
});
