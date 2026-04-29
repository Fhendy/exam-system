<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Exam System</title>
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
            background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 50%, #7dd3fc 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        
        /* Background decoration */
        body::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            pointer-events: none;
        }
        
        .login-container {
            width: 100%;
            max-width: 460px;
            padding: 20px;
            position: relative;
            z-index: 1;
        }
        
        .login-card {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            border-radius: 40px;
            padding: 48px 40px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }
        
        .logo {
            text-align: center;
            margin-bottom: 36px;
        }
        
        .logo-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #0ea5e9, #3b82f6);
            border-radius: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            box-shadow: 0 10px 25px -5px rgba(14, 165, 233, 0.4);
        }
        
        .logo-icon i {
            font-size: 32px;
            color: white;
        }
        
        .logo h1 {
            font-size: 28px;
            font-weight: 800;
            background: linear-gradient(135deg, #0f172a, #0ea5e9);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            letter-spacing: -0.5px;
        }
        
        .logo p {
            color: #64748b;
            margin-top: 8px;
            font-size: 14px;
        }
        
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
            margin-right: 8px;
            color: #0ea5e9;
        }
        
        .input-group {
            position: relative;
        }
        
        .form-control {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #e2e8f0;
            border-radius: 18px;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
            font-family: 'Inter', sans-serif;
        }
        
        .form-control:focus {
            outline: none;
            border-color: #0ea5e9;
            box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.1);
        }
        
        .form-control::placeholder {
            color: #cbd5e1;
            font-weight: 400;
        }
        
        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #0ea5e9, #3b82f6);
            color: white;
            border: none;
            border-radius: 18px;
            font-weight: 700;
            font-size: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 4px 12px rgba(14, 165, 233, 0.3);
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(14, 165, 233, 0.4);
        }
        
        .btn-login:active {
            transform: translateY(0);
        }
        
        .alert {
            padding: 14px 18px;
            border-radius: 18px;
            margin-bottom: 24px;
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
            font-size: 13px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .alert i {
            font-size: 16px;
        }
        
        .demo {
            text-align: center;
            margin-top: 28px;
            padding-top: 24px;
            border-top: 1px solid #e2e8f0;
            font-size: 12px;
            color: #94a3b8;
        }
        
        .demo p {
            margin: 4px 0;
        }
        
        .demo i {
            margin-right: 4px;
            color: #0ea5e9;
        }
        
        .demo strong {
            color: #0ea5e9;
            font-weight: 600;
        }
        
        @media (max-width: 480px) {
            .login-card {
                padding: 32px 24px;
            }
            
            .logo-icon {
                width: 55px;
                height: 55px;
            }
            
            .logo-icon i {
                font-size: 26px;
            }
            
            .logo h1 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="logo">
                <div class="logo-icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h1>Exam System</h1>
                <p>Silakan login untuk melanjutkan</p>
            </div>
            
            @if($errors->any())
                <div class="alert">
                    <i class="fas fa-exclamation-triangle"></i>
                    {{ $errors->first() }}
                </div>
            @endif
            
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-id-card"></i> NIS
                    </label>
                    <div class="input-group">
                        <input type="text" 
                               name="nis" 
                               class="form-control" 
                               placeholder="Masukkan NIS" 
                               required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-lock"></i> Password
                    </label>
                    <div class="input-group">
                        <input type="password" 
                               name="password" 
                               class="form-control" 
                               placeholder="Masukkan password" 
                               required>
                    </div>
                </div>
                
                <button type="submit" class="btn-login">
                    <span>Login</span>
                    <i class="fas fa-arrow-right"></i>
                </button>
            </form>
            
            <div class="demo">
                <p><i class="fas fa-user-shield"></i> <strong>Demo Admin:</strong> NIS: ADMIN001 | Password: password</p>
                <p><i class="fas fa-user-graduate"></i> <strong>Demo Siswa:</strong> NIS: 2024001 | Password: student123</p>
            </div>
        </div>
    </div>
</body>
</html>