<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabla para entregas de tareas por alumnos y sus calificaciones.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // Alumno
            $table->text('content')->nullable();              // Texto de la entrega
            $table->string('file_path')->nullable();          // Archivo adjunto
            $table->decimal('score', 5, 2)->nullable();       // Calificación asignada
            $table->text('feedback')->nullable();              // Retroalimentación del profesor
            $table->datetime('submitted_at')->nullable();      // Fecha de entrega
            $table->datetime('graded_at')->nullable();         // Fecha de calificación
            $table->timestamps();

            // Un alumno solo puede entregar una vez por tarea
            $table->unique(['task_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('submissions');
    }
};
