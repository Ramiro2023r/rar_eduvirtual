<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

/**
 * Controlador principal del Administrador.
 * Gestiona usuarios, cursos y asignaciones.
 */
class AdminController extends Controller
{
    // ─── Dashboard ──────────────────────────────────────────

    public function dashboard()
    {
        $stats = [
            'totalUsers'      => User::count(),
            'totalProfesores' => User::where('role', 'profesor')->count(),
            'totalAlumnos'    => User::where('role', 'alumno')->count(),
            'totalCourses'    => Course::count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    // ─── CRUD de Usuarios ───────────────────────────────────

    public function users()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function createUser()
    {
        return view('admin.users.create');
    }

    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role'     => ['required', Rule::in(['admin', 'profesor', 'alumno'])],
        ]);

        User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => $validated['password'], // El cast 'hashed' se encarga
            'role'     => $validated['role'],
        ]);

        return redirect()->route('admin.users')->with('success', 'Usuario creado exitosamente.');
    }

    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'role'  => ['required', Rule::in(['admin', 'profesor', 'alumno'])],
        ]);

        $user->update($validated);

        // Si se proporcionó nueva contraseña
        if ($request->filled('password')) {
            $request->validate(['password' => 'string|min:8|confirmed']);
            $user->update(['password' => $request->password]);
        }

        return redirect()->route('admin.users')->with('success', 'Usuario actualizado.');
    }

    public function destroyUser(User $user)
    {
        // Evitar que el admin se elimine a sí mismo
        if ($user->id === auth()->id()) {
            return back()->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        $user->delete();
        return redirect()->route('admin.users')->with('success', 'Usuario eliminado.');
    }

    // ─── Gestión de Cursos ──────────────────────────────────

    public function courses()
    {
        $courses = Course::with('professor')->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.courses.index', compact('courses'));
    }

    public function createCourse()
    {
        $profesores = User::where('role', 'profesor')->orderBy('name')->get();
        return view('admin.courses.create', compact('profesores'));
    }

    public function storeCourse(Request $request)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'code'         => 'required|string|max:20|unique:courses,code',
            'description'  => 'nullable|string',
            'professor_id' => 'nullable|exists:users,id',
            'credits'      => 'required|integer|min:1|max:10',
        ]);

        Course::create($validated);

        return redirect()->route('admin.courses')->with('success', 'Curso creado exitosamente.');
    }

    public function editCourse(Course $course)
    {
        $profesores = User::where('role', 'profesor')->orderBy('name')->get();
        return view('admin.courses.edit', compact('course', 'profesores'));
    }

    public function updateCourse(Request $request, Course $course)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'code'         => ['required', 'string', 'max:20', Rule::unique('courses')->ignore($course->id)],
            'description'  => 'nullable|string',
            'professor_id' => 'nullable|exists:users,id',
            'credits'      => 'required|integer|min:1|max:10',
            'status'       => ['required', Rule::in(['activo', 'inactivo'])],
        ]);

        $course->update($validated);

        return redirect()->route('admin.courses')->with('success', 'Curso actualizado.');
    }

    public function destroyCourse(Course $course)
    {
        $course->delete();
        return redirect()->route('admin.courses')->with('success', 'Curso eliminado.');
    }

    // ─── Inscripción de Alumnos ─────────────────────────────

    public function courseStudents(Course $course)
    {
        $course->load('students');
        $alumnos = User::where('role', 'alumno')
                       ->whereNotIn('id', $course->students->pluck('id'))
                       ->orderBy('name')
                       ->get();

        return view('admin.courses.students', compact('course', 'alumnos'));
    }

    public function enrollStudent(Request $request, Course $course)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $course->students()->syncWithoutDetaching([$validated['user_id']]);

        return back()->with('success', 'Alumno inscrito exitosamente.');
    }

    public function unenrollStudent(Course $course, User $user)
    {
        $course->students()->detach($user->id);
        return back()->with('success', 'Alumno removido del curso.');
    }
}
