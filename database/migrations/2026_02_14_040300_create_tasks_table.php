<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabla para tareas y evaluaciones creadas por profesores.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // Profesor creador
            $table->string('title');                           // Título de la tarea
            $table->text('description')->nullable();           // Instrucciones
            $table->datetime('due_date')->nullable();          // Fecha de entrega
            $table->decimal('max_score', 5, 2)->default(100);  // Puntuación máxima
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
