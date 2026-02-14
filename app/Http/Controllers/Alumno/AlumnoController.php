<?php

namespace App\Http\Controllers\Alumno;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Submission;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * Controlador del Alumno.
 * Acceso a cursos, material, entregas de tareas y calificaciones.
 */
class AlumnoController extends Controller
{
    // ─── Dashboard ──────────────────────────────────────────

    public function dashboard()
    {
        $courses = auth()->user()->enrolledCourses()
                        ->with('professor')
                        ->wherePivot('status', 'inscrito')
                        ->get();

        return view('alumno.dashboard', compact('courses'));
    }

    // ─── Ver Curso ──────────────────────────────────────────

    public function showCourse(Course $course)
    {
        $this->authorizeStudent($course);

        $course->load(['professor', 'academicContents', 'tasks']);
        return view('alumno.courses.show', compact('course'));
    }

    // ─── Contenido Académico ────────────────────────────────

    public function downloadContent(Course $course, \App\Models\AcademicContent $content)
    {
        $this->authorizeStudent($course);

        if ($content->file_path && Storage::disk('public')->exists($content->file_path)) {
            return Storage::disk('public')->download($content->file_path);
        }

        return back()->with('error', 'El archivo no está disponible.');
    }

    // ─── Tareas ─────────────────────────────────────────────

    public function showTask(Course $course, Task $task)
    {
        $this->authorizeStudent($course);

        $submission = Submission::where('task_id', $task->id)
                               ->where('user_id', auth()->id())
                               ->first();

        return view('alumno.tasks.show', compact('course', 'task', 'submission'));
    }

    public function submitTask(Request $request, Course $course, Task $task)
    {
        $this->authorizeStudent($course);

        // Verificar que no haya entrega previa
        $existing = Submission::where('task_id', $task->id)
                              ->where('user_id', auth()->id())
                              ->first();

        if ($existing) {
            return back()->with('error', 'Ya has enviado esta tarea.');
        }

        $validated = $request->validate([
            'content' => 'nullable|string',
            'file'    => 'nullable|file|mimes:pdf,doc,docx,zip,rar|max:10240',
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('submissions', 'public');
        }

        Submission::create([
            'task_id'      => $task->id,
            'user_id'      => auth()->id(),
            'content'      => $validated['content'],
            'file_path'    => $filePath,
            'submitted_at' => now(),
        ]);

        return redirect()->route('alumno.course.show', $course)
                         ->with('success', 'Tarea enviada exitosamente.');
    }

    // ─── Calificaciones ─────────────────────────────────────

    public function grades()
    {
        $submissions = Submission::where('user_id', auth()->id())
                                ->with(['task.course'])
                                ->whereNotNull('graded_at')
                                ->orderBy('graded_at', 'desc')
                                ->get();

        return view('alumno.grades', compact('submissions'));
    }

    // ─── Verificación de autorización ───────────────────────

    /**
     * Verifica que el alumno está inscrito en el curso.
     */
    private function authorizeStudent(Course $course): void
    {
        $isEnrolled = auth()->user()->enrolledCourses()
                           ->where('course_id', $course->id)
                           ->exists();

        if (!$isEnrolled) {
            abort(403, 'No estás inscrito en este curso.');
        }
    }
}
