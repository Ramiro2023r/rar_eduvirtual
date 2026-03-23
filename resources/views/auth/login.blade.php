<x-guest-layout>
    <div class="login-container">
        {{-- ═══════════════════════════════════════════════════════════
             COLUMNA IZQUIERDA — Branding institucional
        ═══════════════════════════════════════════════════════════ --}}
        <div class="login-left">
            {{-- Decorative circles --}}
            <div class="decor-circle"></div>
            <div class="decor-circle-sm"></div>

            <div class="brand-content">
                <h1 class="brand-name">RAREDUVIRTUAL</h1>
                <p class="brand-subtitle">Universidad Virtual</p>
                <p class="brand-description">
                    Plataforma académica de educación virtual.
                    Accede a tus cursos, tareas y calificaciones desde cualquier lugar.
                </p>

                <img src="{{ asset('images/education-illustration.png') }}"
                     alt="Educación Virtual - RAREDUVIRTUAL"
                     class="brand-illustration" />
            </div>
        </div>

        {{-- ═══════════════════════════════════════════════════════════
             COLUMNA DERECHA — Formulario de Login
        ═══════════════════════════════════════════════════════════ --}}
        <div class="login-right">
            <div class="login-card">
                {{-- Mobile-only branding --}}
                <div class="mobile-brand" style="display:none;">
                    <span class="mobile-brand-name">RAREDUVIRTUAL</span>
                    <span class="mobile-brand-sub">Universidad Virtual</span>
                </div>

                {{-- Header --}}
                <div class="login-card-header">
                    <h2 class="login-card-title">Iniciar Sesión</h2>
                    <p class="login-card-subtitle">Ingresa tus credenciales para continuar</p>
                </div>

                {{-- Validation Errors --}}
                @if ($errors->any())
                    <div class="validation-errors">
                        <p>{{ __('Whoops! Something went wrong.') }}</p>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Status Message --}}
                @session('status')
                    <div class="status-message">
                        {{ $value }}
                    </div>
                @endsession

                {{-- Login Form --}}
                <form method="POST" action="{{ route('login') }}" id="login-form">
                    @csrf

                    {{-- Email Field --}}
                    <div class="form-group">
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <div class="input-wrapper">
                            <input id="email"
                                   class="form-input"
                                   type="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   placeholder="correo@universidad.edu"
                                   required
                                   autofocus
                                   autocomplete="username" />
                            <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                            </svg>
                        </div>
                    </div>

                    {{-- Password Field --}}
                    <div class="form-group">
                        <label for="password" class="form-label">Contraseña</label>
                        <div class="input-wrapper">
                            <input id="password"
                                   class="form-input"
                                   type="password"
                                   name="password"
                                   placeholder="••••••••"
                                   required
                                   autocomplete="current-password" />
                            <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                            </svg>
                        </div>
                    </div>

                    {{-- Options: Remember me & Forgot password --}}
                    <div class="form-options">
                        <label for="remember_me" class="remember-label">
                            <input id="remember_me"
                                   type="checkbox"
                                   name="remember"
                                   class="remember-checkbox" />
                            <span>Recordarme</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="forgot-link">
                                ¿Olvidaste tu contraseña?
                            </a>
                        @endif
                    </div>

                    {{-- Submit Button --}}
                    <button type="submit" class="btn-login" id="btn-login">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                            </svg>
                            Iniciar Sesión
                        </span>
                    </button>
                </form>

                {{-- Footer: Roles --}}
                <div class="login-footer">
                    <p>Acceso disponible para:</p>
                    <div class="role-badges">
                        <span class="role-badge">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Administradores
                        </span>
                        <span class="role-badge">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342" />
                            </svg>
                            Profesores
                        </span>
                        <span class="role-badge">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                            </svg>
                            Alumnos
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
