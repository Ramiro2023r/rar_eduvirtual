<p align="center">
<img width="1891" height="865" alt="Captura de pantalla 2026-03-22 211207" src="https://github.com/user-attachments/assets/4041b79a-dd35-4703-900d-cce44d648121" />

</p>

<h1 align="center">EDUVIRTUAL</h1>

<p align="center">
  <strong>Plataforma de Gestión de Educación Virtual (LMS)</strong><br>
  <em>Una solución moderna, eficiente y segura para el aprendizaje en línea.</em>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel" alt="Laravel 12">
  <img src="https://img.shields.io/badge/Livewire-3.x-4e56a6?style=for-the-badge&logo=livewire" alt="Livewire 3">
  <img src="https://img.shields.io/badge/Tailwind_CSS-3.x-38B2AC?style=for-the-badge&logo=tailwind-css" alt="Tailwind CSS">
  <img src="https://img.shields.io/badge/SQLite-3-003B57?style=for-the-badge&logo=sqlite" alt="SQLite">
  <img src="https://img.shields.io/badge/Status-Development-yellow?style=for-the-badge" alt="Status">
</p>

---

## 🚀 Acerca del Proyecto

**EDUVIRTUAL** es un Sistema de Gestión de Aprendizaje (LMS) construido con el stack TALL (Tailwind, Alpine, Laravel, Livewire). Está diseñado para facilitar la interacción entre administradores, profesores y alumnos en un entorno digital intuitivo y profesional.

### ✨ Vista Previa
<p align="center">
<img width="1918" height="873" alt="Captura de pantalla 2026-03-22 211226" src="https://github.com/user-attachments/assets/3318ba23-8570-4ef5-bed2-04b4a45cab54" />
<img width="1914" height="853" alt="Captura de pantalla 2026-03-22 211255" src="https://github.com/user-attachments/assets/751c4318-01f7-4f2d-a30a-008a278fe85c" />
<img width="1910" height="860" alt="Captura de pantalla 2026-03-22 211326" src="https://github.com/user-attachments/assets/621a0221-74e6-4455-900e-f37c2d965dbd" />


</p>

---

## 🛠️ Características por Rol

La plataforma implementa un sistema robusto de roles y permisos para garantizar una experiencia personalizada:

### 🔑 Administrador
*   **Gestión de Usuarios:** Control total sobre el ciclo de vida de usuarios (Admin, Profesor, Alumno).
*   **Gestión de Cursos:** Creación, edición y eliminación de la oferta académica.
*   **Gestión de Inscripciones:** Vinculación de alumnos a sus respectivos cursos de manera centralizada.

### 👨‍🏫 Profesor
*   **Gestión de Contenido:** Subida de material académico (recursos, lecturas, enlaces).
*   **Evaluación:** Creación de tareas con fechas de entrega y descripción detallada.
*   **Calificaciones:** Panel dedicado para revisar entregas de alumnos y asignar puntajes.

### 🎓 Alumno
*   **Dashboard Académico:** Resumen de cursos inscritos y progreso.
*   **Material de Estudio:** Acceso y descarga de contenidos publicados por los docentes.
*   **Entregas Online:** Carga de tareas directamente en la plataforma.
*   **Boletín de Notas:** Consulta instantánea de calificaciones obtenidas.

---

## 💻 Tech Stack

- **Framework:** [Laravel 12.x](https://laravel.com)
- **Frontend Interactivo:** [Livewire 3.x](https://livewire.laravel.com)
- **Estilos:** [Tailwind CSS](https://tailwindcss.com)
- **Autenticación:** [Laravel Jetstream](https://jetstream.laravel.com)
- **Base de Datos:** SQLite (para fácil portabilidad y desarrollo rápido)
- **Herramienta de Construcción:** [Vite](https://vitejs.dev)

---

## 📦 Instalación y Configuración

Siga estos pasos para ejecutar el proyecto en su entorno local:

1. **Clonar el repositorio:**
   ```bash
   git clone https://github.com/tu-usuario/rar_eduvirtual.git
   cd rar_eduvirtual
   ```

2. **Ejecutar el script de configuración automática:**
   Este proyecto incluye un comando personalizado para simplificar el setup inicial:
   ```bash
   composer run setup
   ```
   *Este comando instalará dependencias de PHP (Composer), Node.js (NPM), configurará el archivo `.env`, generará la clave de aplicación, creará la base de datos SQLite y ejecutará las migraciones.*

3. **Ejecutar el servidor de desarrollo:**
   ```bash
   composer run dev
   ```
   *Iniciará simultáneamente el servidor de Laravel, los procesos de cola y Vite.*

---

## 📄 Licencia

Este proyecto es software de código abierto bajo la licencia [MIT](LICENSE).

---

<p align="center">
  Construido con ❤️ por L9TDeveloper
</p>
