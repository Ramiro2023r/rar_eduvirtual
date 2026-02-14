{{-- Layout principal del panel EDUVIRTUAL con sidebar de navegación por rol --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>EDUVIRTUAL - @yield('title', 'Plataforma Universitaria')</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --primary-light: #a5b4fc;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --sidebar-bg: #1e1b4b;
            --sidebar-hover: #312e81;
            --body-bg: #f1f5f9;
            --card-bg: #ffffff;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
        }

        * { box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--body-bg);
            margin: 0;
            color: var(--text-primary);
        }

        /* ─── Sidebar ──────────────────────────────── */
        .sidebar {
            position: fixed;
            top: 0; left: 0; bottom: 0;
            width: 260px;
            background: var(--sidebar-bg);
            color: white;
            display: flex;
            flex-direction: column;
            z-index: 50;
            transition: transform 0.3s ease;
        }

        .sidebar-brand {
            padding: 1.5rem;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-brand h1 {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary-light), #818cf8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .sidebar-brand .role-badge {
            display: inline-block;
            margin-top: 0.5rem;
            padding: 0.25rem 0.75rem;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            border-radius: 9999px;
            background: rgba(255,255,255,0.15);
            color: var(--primary-light);
        }

        .sidebar-nav { flex: 1; padding: 1rem 0; overflow-y: auto; }

        .sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1.5rem;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s;
            border-left: 3px solid transparent;
        }

        .sidebar-nav a:hover,
        .sidebar-nav a.active {
            color: white;
            background: var(--sidebar-hover);
            border-left-color: var(--primary-light);
        }

        .sidebar-nav a .nav-icon {
            width: 20px;
            text-align: center;
            font-size: 1rem;
        }

        .sidebar-footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-footer .user-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 0.75rem;
        }

        .sidebar-footer .user-avatar {
            width: 36px; height: 36px;
            border-radius: 50%;
            background: var(--primary);
            display: flex; align-items: center; justify-content: center;
            font-weight: 700;
            font-size: 0.875rem;
        }

        .sidebar-footer .user-name {
            font-size: 0.8rem;
            font-weight: 600;
        }

        .sidebar-footer .user-email {
            font-size: 0.7rem;
            color: rgba(255,255,255,0.5);
        }

        .btn-logout {
            display: block;
            width: 100%;
            padding: 0.5rem;
            background: rgba(239, 68, 68, 0.2);
            color: #fca5a5;
            border: 1px solid rgba(239, 68, 68, 0.3);
            border-radius: 0.5rem;
            text-align: center;
            font-size: 0.8rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
        }

        .btn-logout:hover {
            background: rgba(239, 68, 68, 0.4);
            color: white;
        }

        /* ─── Main Content ─────────────────────────── */
        .main-content {
            margin-left: 260px;
            min-height: 100vh;
        }

        .top-bar {
            background: var(--card-bg);
            padding: 1rem 2rem;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 40;
        }

        .top-bar h2 {
            margin: 0;
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-primary);
        }

        .page-content {
            padding: 2rem;
        }

        /* ─── Cards & Stats ────────────────────────── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: var(--card-bg);
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06);
            border: 1px solid #e2e8f0;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }

        .stat-card .stat-icon {
            width: 48px; height: 48px;
            border-radius: 0.75rem;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.25rem;
            margin-bottom: 1rem;
        }

        .stat-card .stat-icon.blue { background: #eff6ff; color: #3b82f6; }
        .stat-card .stat-icon.green { background: #ecfdf5; color: #10b981; }
        .stat-card .stat-icon.purple { background: #f5f3ff; color: #8b5cf6; }
        .stat-card .stat-icon.orange { background: #fff7ed; color: #f97316; }

        .stat-card .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-primary);
            line-height: 1;
        }

        .stat-card .stat-label {
            font-size: 0.8rem;
            color: var(--text-secondary);
            margin-top: 0.25rem;
        }

        /* ─── Cards Generales ──────────────────────── */
        .card {
            background: var(--card-bg);
            border-radius: 1rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06);
            border: 1px solid #e2e8f0;
            margin-bottom: 1.5rem;
            overflow: hidden;
        }

        .card-header {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-header h3 {
            margin: 0;
            font-size: 1rem;
            font-weight: 600;
        }

        .card-body { padding: 1.5rem; }

        /* ─── Tabla ────────────────────────────────── */
        .table-responsive { overflow-x: auto; }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #f8fafc;
            padding: 0.75rem 1rem;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-secondary);
            text-align: left;
            border-bottom: 2px solid #e2e8f0;
        }

        td {
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }

        tr:hover td { background: #f8fafc; }

        /* ─── Botones ──────────────────────────────── */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-size: 0.8rem;
            font-weight: 500;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-primary { background: var(--primary); color: white; }
        .btn-primary:hover { background: var(--primary-dark); }

        .btn-success { background: var(--success); color: white; }
        .btn-success:hover { background: #059669; }

        .btn-warning { background: var(--warning); color: white; }
        .btn-warning:hover { background: #d97706; }

        .btn-danger { background: var(--danger); color: white; }
        .btn-danger:hover { background: #dc2626; }

        .btn-outline {
            background: transparent;
            border: 1px solid #cbd5e1;
            color: var(--text-secondary);
        }
        .btn-outline:hover {
            background: #f1f5f9;
            border-color: #94a3b8;
        }

        .btn-sm { padding: 0.35rem 0.75rem; font-size: 0.75rem; }

        /* ─── Badges ───────────────────────────────── */
        .badge {
            display: inline-block;
            padding: 0.2rem 0.6rem;
            font-size: 0.7rem;
            font-weight: 600;
            border-radius: 9999px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .badge-admin { background: #fef3c7; color: #92400e; }
        .badge-profesor { background: #dbeafe; color: #1e40af; }
        .badge-alumno { background: #dcfce7; color: #166534; }
        .badge-activo { background: #dcfce7; color: #166534; }
        .badge-inactivo { background: #fee2e2; color: #991b1b; }

        /* ─── Formularios ──────────────────────────── */
        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.375rem;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text-primary);
        }

        .form-control {
            width: 100%;
            padding: 0.625rem 0.875rem;
            border: 1px solid #cbd5e1;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-family: 'Inter', sans-serif;
            color: var(--text-primary);
            background: white;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
        }

        select.form-control { cursor: pointer; }
        textarea.form-control { resize: vertical; min-height: 100px; }

        .form-error {
            color: var(--danger);
            font-size: 0.75rem;
            margin-top: 0.25rem;
        }

        /* ─── Alertas ──────────────────────────────── */
        .alert {
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            font-size: 0.8rem;
            font-weight: 500;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .alert-success { background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; }
        .alert-error { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }

        /* ─── Course Cards ─────────────────────────── */
        .course-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .course-card {
            background: var(--card-bg);
            border-radius: 1rem;
            border: 1px solid #e2e8f0;
            overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .course-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(0,0,0,0.08);
        }

        .course-card-header {
            padding: 1.5rem;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
        }

        .course-card-header h4 {
            margin: 0 0 0.25rem;
            font-size: 1rem;
            font-weight: 600;
        }

        .course-card-header .course-code {
            font-size: 0.75rem;
            opacity: 0.8;
        }

        .course-card-body {
            padding: 1.25rem 1.5rem;
        }

        .course-card-body .meta {
            display: flex;
            gap: 1rem;
            font-size: 0.8rem;
            color: var(--text-secondary);
            margin-bottom: 1rem;
        }

        .course-card-body .meta span {
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        /* ─── Empty State ──────────────────────────── */
        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: var(--text-secondary);
        }

        .empty-state .empty-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .empty-state p { margin: 0.5rem 0; font-size: 0.875rem; }

        /* ─── Pagination ───────────────────────────── */
        .pagination-wrapper {
            margin-top: 1.5rem;
        }

        .pagination-wrapper nav { }
        .pagination-wrapper .flex.justify-between { font-size: 0.8rem; }

        /* ─── Responsive ───────────────────────────── */
        .mobile-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--text-primary);
        }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main-content { margin-left: 0; }
            .mobile-toggle { display: block; }
            .stats-grid { grid-template-columns: 1fr 1fr; }
            .course-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    {{-- Sidebar --}}
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <h1>📚 EDUVIRTUAL</h1>
            <span class="role-badge">{{ ucfirst(auth()->user()->role) }}</span>
        </div>

        <nav class="sidebar-nav">
            @yield('sidebar-nav')
        </nav>

        <div class="sidebar-footer">
            <div class="user-info">
                <div class="user-avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div>
                    <div class="user-name">{{ auth()->user()->name }}</div>
                    <div class="user-email">{{ auth()->user()->email }}</div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">🚪 Cerrar Sesión</button>
            </form>
        </div>
    </aside>

    {{-- Main --}}
    <div class="main-content">
        <div class="top-bar">
            <button class="mobile-toggle" onclick="document.getElementById('sidebar').classList.toggle('open')">☰</button>
            <h2>@yield('page-title', 'Dashboard')</h2>
            <div></div>
        </div>

        <div class="page-content">
            {{-- Alertas flash --}}
            @if(session('success'))
                <div class="alert alert-success">✅ {{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-error">❌ {{ session('error') }}</div>
            @endif

            @yield('content')
        </div>
    </div>

    @stack('scripts')
</body>
</html>
