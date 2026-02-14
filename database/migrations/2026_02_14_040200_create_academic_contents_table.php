<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabla para contenido académico (PDFs, videos, enlaces).
 * Subido por profesores y asociado a un curso.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('academic_contents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // Profesor que lo subió
            $table->string('title');                                         // Título del contenido
            $table->text('description')->nullable();                         // Descripción opcional
            $table->enum('type', ['pdf', 'video', 'enlace', 'otro'])->default('pdf');
            $table->string('file_path')->nullable();                         // Ruta del archivo (PDF)
            $table->string('url')->nullable();                               // URL (video/enlace)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('academic_contents');
    }
};
