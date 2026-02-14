<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Seeder para crear usuarios de prueba para cada rol.
 * Ejecutar con: php artisan db:seed --class=RoleSeeder
 */
class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Administrador
        User::updateOrCreate(
            ['email' => 'admin@eduvirtual.com'],
            [
                'name'     => 'Administrador',
                'password' => 'password',
                'role'     => 'admin',
            ]
        );

        // Profesor de prueba
        User::updateOrCreate(
            ['email' => 'profesor@eduvirtual.com'],
            [
                'name'     => 'Prof. Juan García',
                'password' => 'password',
                'role'     => 'profesor',
            ]
        );

        // Alumno de prueba
        User::updateOrCreate(
            ['email' => 'alumno@eduvirtual.com'],
            [
                'name'     => 'María López',
                'password' => 'password',
                'role'     => 'alumno',
            ]
        );
    }
}
