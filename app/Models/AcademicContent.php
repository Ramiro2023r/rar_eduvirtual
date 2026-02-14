<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AcademicContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'user_id',
        'title',
        'description',
        'type',
        'file_path',
        'url',
    ];

    /**
     * Curso al que pertenece el contenido.
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Profesor que subió el contenido.
     */
    public function professor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
