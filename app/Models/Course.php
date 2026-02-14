<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'professor_id',
        'credits',
        'status',
    ];

    // ─── Relaciones ──────────────────────────────────────────

    /**
     * Profesor asignado al curso.
     */
    public function professor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'professor_id');
    }

    /**
     * Alumnos inscritos en el curso.
     */
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
                    ->withPivot('status')
                    ->withTimestamps();
    }

    /**
     * Contenido académico del curso.
     */
    public function academicContents(): HasMany
    {
        return $this->hasMany(AcademicContent::class);
    }

    /**
     * Tareas del curso.
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}
