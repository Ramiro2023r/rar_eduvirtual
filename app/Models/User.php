<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * Atributos asignables en masa.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * Atributos ocultos para serialización.
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Casts de atributos.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ─── Helpers de rol ───────────────────────────────────────

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isProfesor(): bool
    {
        return $this->role === 'profesor';
    }

    public function isAlumno(): bool
    {
        return $this->role === 'alumno';
    }

    // ─── Relaciones ──────────────────────────────────────────

    /**
     * Cursos donde el profesor está asignado.
     */
    public function taughtCourses(): HasMany
    {
        return $this->hasMany(Course::class, 'professor_id');
    }

    /**
     * Cursos donde el alumno está inscrito (pivot course_user).
     */
    public function enrolledCourses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class)
                    ->withPivot('status')
                    ->withTimestamps();
    }

    /**
     * Entregas de tareas (como alumno).
     */
    public function submissions(): HasMany
    {
        return $this->hasMany(Submission::class);
    }

    /**
     * Contenido académico subido (como profesor).
     */
    public function academicContents(): HasMany
    {
        return $this->hasMany(AcademicContent::class);
    }
}
