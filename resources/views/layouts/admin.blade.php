<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - Exam System</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f0f9ff;
            color: #0f172a;
        }

        /* ==================== SIDEBAR PREMIUM ==================== */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 280px;
            height: 100%;
            background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%);
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            z-index: 1000;
            overflow-y: auto;
        }

        .sidebar-brand {
            padding: 28px 24px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            margin-bottom: 20px;
        }

        .sidebar-brand h2 {
            color: white;
            font-size: 22px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar-brand h2 i {
            font-size: 24px;
            color: #0ea5e9;
        }

        .sidebar-brand p {
            color: rgba(255, 255, 255, 0.5);
            font-size: 12px;
            margin-top: 8px;
            letter-spacing: 0.5px;
        }

        .sidebar-nav {
            padding: 0 12px;
        }

        .nav-item {
            padding: 10px 16px;
            margin: 4px 0;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .nav-item a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .nav-item i {
            width: 24px;
            font-size: 18px;
            text-align: center;
        }

        .nav-item:hover {
            background: rgba(14, 165, 233, 0.15);
        }

        .nav-item:hover a {
            color: white;
        }

        .nav-item.active {
            background: linear-gradient(135deg, #0ea5e9, #3b82f6);
            box-shadow: 0 4px 12px rgba(14, 165, 233, 0.3);
        }

        .nav-item.active a {
            color: white;
        }

        /* ==================== MAIN CONTENT ==================== */
        .main-content {
            margin-left: 280px;
            min-height: 100vh;
            transition: all 0.3s ease;
        }

        /* ==================== TOP BAR ==================== */
        .top-bar {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            padding: 16px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 0;
            z-index: 999;
            border-bottom: 1px solid rgba(14, 165, 233, 0.1);
        }

        .page-title {
            font-size: 24px;
            font-weight: 700;
            color: #0f172a;
            background: linear-gradient(135deg, #0f172a, #0ea5e9);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 20px;
            background: #f8fafc;
            padding: 6px 6px 6px 20px;
            border-radius: 60px;
            border: 1px solid #e2e8f0;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #0ea5e9, #3b82f6);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 16px;
            box-shadow: 0 2px 8px rgba(14, 165, 233, 0.3);
        }

        .user-details {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-weight: 700;
            color: #0f172a;
            font-size: 14px;
        }

        .user-role {
            font-size: 11px;
            color: #94a3b8;
        }

        .logout-btn {
            background: #f1f5f9;
            color: #475569;
            padding: 8px 16px;
            border-radius: 40px;
            font-size: 13px;
            font-weight: 500;
            border: 1px solid #e2e8f0;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .logout-btn:hover {
            background: #fee2e2;
            color: #ef4444;
            border-color: #fecaca;
        }

        /* ==================== CONTENT ==================== */
        .content {
            padding: 32px;
        }

        /* ==================== CARDS ==================== */
        .card {
            background: white;
            border-radius: 24px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
            overflow: hidden;
            margin-bottom: 28px;
            border: 1px solid rgba(14, 165, 233, 0.08);
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.05);
        }

        .card-header {
            padding: 20px 28px;
            border-bottom: 1px solid #f1f5f9;
            font-weight: 600;
            font-size: 16px;
            color: #0f172a;
            background: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
        }

        .card-body {
            padding: 28px;
        }

        /* ==================== BUTTONS ==================== */
        .btn {
            padding: 10px 20px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #0ea5e9, #3b82f6);
            color: white;
            box-shadow: 0 2px 8px rgba(14, 165, 233, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(14, 165, 233, 0.4);
        }

        .btn-success {
            background: #10b981;
            color: white;
        }

        .btn-success:hover {
            background: #059669;
            transform: translateY(-1px);
        }

        .btn-danger {
            background: #ef4444;
            color: white;
        }

        .btn-danger:hover {
            background: #dc2626;
            transform: translateY(-1px);
        }

        .btn-warning {
            background: #f59e0b;
            color: white;
        }

        .btn-warning:hover {
            background: #d97706;
            transform: translateY(-1px);
        }

        .btn-outline {
            background: transparent;
            border: 1px solid #e2e8f0;
            color: #475569;
        }

        .btn-outline:hover {
            border-color: #0ea5e9;
            color: #0ea5e9;
            background: #f0f9ff;
        }

        /* ==================== TABLES ==================== */
        .table-wrapper {
            overflow-x: auto;
            border-radius: 16px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 14px 16px;
            text-align: left;
            border-bottom: 1px solid #f1f5f9;
        }

        .table th {
            background: #f8fafc;
            font-weight: 600;
            font-size: 12px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table tr:hover td {
            background: #fafcff;
        }

        /* ==================== BADGES ==================== */
        .badge {
            padding: 4px 12px;
            border-radius: 30px;
            font-size: 11px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .badge-success {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .badge-warning {
            background: #fed7aa;
            color: #92400e;
        }

        .badge-info {
            background: #dbeafe;
            color: #1e40af;
        }

        /* ==================== STATS GRID ==================== */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 24px;
            margin-bottom: 32px;
        }

        .stat-card {
            background: white;
            border-radius: 24px;
            padding: 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border: 1px solid rgba(14, 165, 233, 0.08);
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px -8px rgba(0, 0, 0, 0.1);
        }

        .stat-info h3 {
            font-size: 32px;
            font-weight: 800;
            margin-bottom: 4px;
            color: #0f172a;
        }

        .stat-info p {
            font-size: 13px;
            color: #64748b;
            font-weight: 500;
        }

        .stat-icon {
            width: 56px;
            height: 56px;
            background: linear-gradient(135deg, #0ea5e9, #3b82f6);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 28px;
            box-shadow: 0 8px 16px -4px rgba(14, 165, 233, 0.3);
        }

        /* ==================== FORMS ==================== */
        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            font-size: 13px;
            color: #334155;
        }

        .form-label i {
            margin-right: 6px;
            color: #0ea5e9;
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 14px;
            font-size: 14px;
            transition: all 0.3s ease;
            font-family: 'Inter', sans-serif;
        }

        .form-control:focus {
            outline: none;
            border-color: #0ea5e9;
            box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.1);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }

        /* ==================== ALERTS ==================== */
        .alert {
            padding: 16px 20px;
            border-radius: 16px;
            margin-bottom: 24px;
            font-size: 14px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border-left: 4px solid #10b981;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border-left: 4px solid #ef4444;
        }

        .alert-warning {
            background: #fed7aa;
            color: #92400e;
            border-left: 4px solid #f59e0b;
        }

        /* ==================== PAGINATION ==================== */
        .pagination {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-top: 28px;
        }

        .pagination a,
        .pagination span {
            padding: 8px 14px;
            border-radius: 10px;
            text-decoration: none;
            color: #64748b;
            font-size: 14px;
            transition: all 0.2s ease;
        }

        .pagination a:hover {
            background: #f1f5f9;
            color: #0ea5e9;
        }

        .pagination .active {
            background: linear-gradient(135deg, #0ea5e9, #3b82f6);
            color: white;
        }

        /* ==================== RESPONSIVE ==================== */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                width: 260px;
            }
            
            .sidebar.open {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .top-bar {
                padding: 12px 20px;
            }
            
            .content {
                padding: 20px;
            }
            
            .page-title {
                font-size: 20px;
            }
            
            .user-details {
                display: none;
            }
        }

        /* Scrollbar */
        .sidebar::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 4px;
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <h2>
                <i class="fas fa-graduation-cap"></i>
                Exam System
            </h2>
            <p>Admin Dashboard</p>
        </div>
        <div class="sidebar-nav">
            <div class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-chart-line"></i>
                    <span>Dashboard</span>
                </a>
            </div>
            <div class="nav-item {{ request()->routeIs('admin.students*') ? 'active' : '' }}">
                <a href="{{ route('admin.students') }}">
                    <i class="fas fa-users"></i>
                    <span>Manajemen Siswa</span>
                </a>
            </div>
            <div class="nav-item {{ request()->routeIs('admin.exams*') ? 'active' : '' }}">
                <a href="{{ route('admin.exams') }}">
                    <i class="fas fa-file-alt"></i>
                    <span>Manajemen Ujian</span>
                </a>
            </div>
            <div class="nav-item {{ request()->routeIs('admin.sessions*') ? 'active' : '' }}">
                <a href="{{ route('admin.sessions') }}">
                    <i class="fas fa-clock"></i>
                    <span>Sesi Ujian</span>
                </a>
            </div>
            <div class="nav-item {{ request()->routeIs('admin.cheats*') ? 'active' : '' }}">
                <a href="{{ route('admin.cheats') }}">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span>Log Pelanggaran</span>
                </a>
            </div>
            <div class="nav-item {{ request()->routeIs('admin.activations*') ? 'active' : '' }}">
                <a href="{{ route('admin.activations') }}">
                    <i class="fas fa-key"></i>
                    <span>Kode Aktivasi</span>
                </a>
            </div>
        </div>
    </div>

    <div class="main-content">
        <div class="top-bar">
            <div class="page-title">@yield('page-title')</div>
            <div class="user-info">
                <div class="user-details">
                    <span class="user-name">{{ Auth::user()->name }}</span>
                    <span class="user-role">Administrator</span>
                </div>
                <div class="user-avatar">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </form>
            </div>
        </div>

        <div class="content">
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-triangle"></i>
                    {{ session('error') }}
                </div>
            @endif
            @if(session('warning'))
                <div class="alert alert-warning">
                    <i class="fas fa-info-circle"></i>
                    {{ session('warning') }}
                </div>
            @endif
            
            @yield('content')
        </div>
    </div>

    <script>
        // Toggle sidebar on mobile (optional)
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('open');
        }
    </script>
    
    @stack('scripts')
</body>
</html>