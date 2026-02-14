<?php

namespace App\Http\Controllers\Profesor;

use App\Http\Controllers\Controller;
use App\Models\AcademicContent;
use App\Models\Course;
use App\Models\Submission;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * Controlador del Profesor.
 * Gestión de cursos asignados, contenido académico, tareas y calificaciones.
 */
class ProfesorController extends Controller
{
    // ─── Dashboard ──────────────────────────────────────────

    public function dashboard()
    {
        $courses = auth()->user()->taughtCourses()->withCount('students')->get();
        return view('profesor.dashboard', compact('courses'));
    }

    // ─── Ver Curso ──────────────────────────────────────────

    public function showCourse(Course $course)
    {
        // Verificar que el profesor es dueño del curso
        $this->authorizeProfessor($course);

        $course->load(['students', 'academicContents', 'tasks']);
        return view('profesor.courses.show', compact('course'));
    }

    // ─── Contenido Académico ────────────────────────────────

    public function createContent(Course $course)
    {
        $this->authorizeProfessor($course);
        return view('profesor.content.create', compact('course'));
    }

    public function storeContent(Request $request, Course $course)
    {
        $this->authorizeProfessor($course);

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'type'        => 'required|in:pdf,video,enlace,otro',
            'file'        => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx|max:10240', // Max 10MB
            'url'         => 'nullable|url',
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('academic_content', 'public');
        }

        AcademicContent::create([
            'course_id'   => $course->id,
            'user_id'     => auth()->id(),
            'title'       => $validated['title'],
            'description' => $validated['description'],
            'type'        => $validated['type'],
            'file_path'   => $filePath,
            'url'         => $validated['url'] ?? null,
        ]);

        return redirect()->route('profesor.course.show', $course)
                         ->with('success', 'Contenido subido exitosamente.');
    }

    public function destroyContent(Course $course, AcademicContent $content)
    {
        $this->authorizeProfessor($course);

        if ($content->file_path) {
            Storage::disk('public')->delete($content->file_path);
        }

        $content->delete();
        return back()->with('success', 'Contenido eliminado.');
    }

    // ─── Tareas ─────────────────────────────────────────────

    public function createTask(Course $course)
    {
        $this->authorizeProfessor($course);
        return view('profesor.tasks.create', compact('course'));
    }

    public function storeTask(Request $request, Course $course)
    {
        $this->authorizeProfessor($course);

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date'    => 'nullable|date|after:now',
            'max_score'   => 'required|numeric|min:1|max:100',
        ]);

        Task::create([
            'course_id' => $course->id,
            'user_id'   => auth()->id(),
            ...$validated,
        ]);

        return redirect()->route('profesor.course.show', $course)
                         ->with('success', 'Tarea creada exitosamente.');
    }

    public function destroyTask(Course $course, Task $task)
    {
        $this->authorizeProfessor($course);
        $task->delete();
        return back()->with('success', 'Tarea eliminada.');
    }

    // ─── Calificaciones ─────────────────────────────────────

    public function taskSubmissions(Course $course, Task $task)
    {
        $this->authorizeProfessor($course);
        $task->load('submissions.student');
        return view('profesor.tasks.submissions', compact('course', 'task'));
    }

    public function gradeSubmission(Request $request, Course $course, Task $task, Submission $submission)
    {
        $this->authorizeProfessor($course);

        $validated = $request->validate([
            'score'    => 'required|numeric|min:0|max:' . $task->max_score,
            'feedback' => 'nullable|string',
        ]);

        $submission->update([
            'score'     => $validated['score'],
            'feedback'  => $validated['feedback'],
            'graded_at' => now(),
        ]);

        return back()->with('success', 'Calificación guardada.');
    }

    // ─── Verificación de autorización ───────────────────────

    /**
     * Verifica que el profesor autenticado es el dueño del curso.
     */
    private function authorizeProfessor(Course $course): void
    {
        if ($course->professor_id !== auth()->id()) {
            abort(403, 'No tienes acceso a este curso.');
        }
    }
}
