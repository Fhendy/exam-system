<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Student Portal') - Exam System</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 50%, #f8fafc 100%);
            color: #0f172a;
            min-height: 100vh;
        }
        
        /* Navbar Premium */
        .navbar {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            padding: 12px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
            position: sticky;
            top: 0;
            z-index: 100;
            border-bottom: 1px solid rgba(14, 165, 233, 0.1);
        }
        
        .logo h2 {
            font-size: 22px;
            font-weight: 800;
            background: linear-gradient(135deg, #0ea5e9, #3b82f6);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            letter-spacing: -0.3px;
        }
        
        .nav-links {
            display: flex;
            gap: 32px;
            align-items: center;
        }
        
        .nav-links a {
            text-decoration: none;
            color: #475569;
            font-weight: 500;
            font-size: 14px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .nav-links a i {
            font-size: 16px;
        }
        
        .nav-links a:hover {
            color: #0ea5e9;
            transform: translateY(-1px);
        }
        
        .nav-links a.active {
            color: #0ea5e9;
            font-weight: 600;
        }
        
        /* User Menu */
        .user-menu {
            display: flex;
            align-items: center;
            gap: 20px;
            background: #f8fafc;
            padding: 6px 6px 6px 20px;
            border-radius: 60px;
            border: 1px solid #e2e8f0;
        }
        
        .user-avatar {
            width: 38px;
            height: 38px;
            background: linear-gradient(135deg, #0ea5e9, #3b82f6);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 15px;
            box-shadow: 0 2px 8px rgba(14, 165, 233, 0.3);
        }
        
        .user-info {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }
        
        .user-name {
            font-weight: 700;
            color: #0f172a;
            font-size: 13px;
        }
        
        .user-role {
            font-size: 10px;
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
        
        /* Container */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 32px;
        }
        
        /* Cards */
        .card {
            background: white;
            border-radius: 28px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
            overflow: hidden;
            margin-bottom: 28px;
            border: 1px solid rgba(14, 165, 233, 0.08);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
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
            background: #ffffff;
        }
        
        .card-body {
            padding: 28px;
        }
        
        /* Buttons */
        .btn {
            padding: 10px 20px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            border: none;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #0ea5e9, #3b82f6);
            color: white;
            box-shadow: 0 2px 8px rgba(14, 165, 233, 0.3);
        }
        
        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(14, 165, 233, 0.4);
        }
        
        .btn-outline {
            background: transparent;
            border: 1px solid #e2e8f0;
            color: #475569;
        }
        
        .btn-outline:hover {
            border-color: #0ea5e9;
            color: #0ea5e9;
        }
        
        /* Alerts */
        .alert {
            padding: 16px 20px;
            border-radius: 16px;
            margin-bottom: 24px;
            font-size: 14px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
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
        
        /* Form */
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
        
        /* Badges */
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
        
        /* Tables */
        .table-wrapper {
            overflow-x: auto;
            border-radius: 16px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th {
            padding: 14px 16px;
            text-align: left;
            font-weight: 600;
            color: #64748b;
            font-size: 12px;
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
        }
        
        td {
            padding: 14px 16px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 14px;
        }
        
        /* Responsive */
        @media (max-width: 800px) {
            .navbar {
                padding: 12px 20px;
            }
            
            .container {
                padding: 20px;
            }
            
            .nav-links {
                gap: 20px;
            }
            
            .user-info {
                display: none;
            }
            
            .user-menu {
                padding: 4px 4px 4px 12px;
            }
        }
        
        @media (max-width: 640px) {
            .navbar {
                flex-wrap: wrap;
                gap: 12px;
            }
            
            .nav-links {
                order: 3;
                width: 100%;
                justify-content: center;
                padding-top: 8px;
                border-top: 1px solid #e2e8f0;
            }
            
            .card-header {
                padding: 16px 20px;
            }
            
            .card-body {
                padding: 20px;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="navbar">
        <div class="logo">
            <h2><i class="fas fa-graduation-cap" style="margin-right: 8px;"></i> Exam System</h2>
        </div>
        <div class="nav-links">
            <a href="{{ route('student.enter-code') }}" class="{{ request()->routeIs('student.enter-code') ? 'active' : '' }}">
                <i class="fas fa-home"></i> Beranda
            </a>
            <a href="{{ route('student.dashboard') }}" class="{{ request()->routeIs('student.dashboard') ? 'active' : '' }}">
                <i class="fas fa-history"></i> Riwayat
            </a>
        </div>
        <div class="user-menu">
            <div class="user-info">
                <span class="user-name">{{ Auth::user()->name }}</span>
                <span class="user-role">NIS: {{ Auth::user()->nis }}</span>
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
    
    <div class="container">
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
    
    @stack('scripts')
</body>
</html>