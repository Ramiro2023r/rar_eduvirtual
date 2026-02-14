<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migración para la tabla de cursos.
 * Cada curso tiene un nombre, descripción, código único, y un profesor asignado.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name');                         // Nombre del curso
            $table->string('code')->unique();               // Código único (ej: MAT-101)
            $table->text('description')->nullable();        // Descripción del curso
            $table->foreignId('professor_id')               // Profesor asignado
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();
            $table->integer('credits')->default(3);         // Créditos académicos
            $table->enum('status', ['activo', 'inactivo'])->default('activo');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
