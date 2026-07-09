<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Aaksh News 24</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 20px;
            color: #f8fafc;
        }

        .login-card {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 24px;
            padding: 40px;
            width: 100%;
            max-width: 440px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            animation: fadeInUp 0.6s ease;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .brand-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .brand-header img {
            width: 54px;
            height: 54px;
            border-radius: 50%;
            margin-bottom: 12px;
            box-shadow: 0 4px 15px rgba(229, 62, 62, 0.4);
        }

        .brand-header h2 {
            font-size: 1.5rem;
            font-weight: 800;
            margin: 0;
            color: #ffffff;
        }

        .brand-header h2 span {
            color: #e53e3e;
        }

        .brand-header p {
            font-size: 0.85rem;
            color: #94a3b8;
            margin-top: 6px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            font-size: 0.85rem;
            font-weight: 700;
            color: #cbd5e1;
            margin-bottom: 8px;
            display: block;
        }

        .input-group-custom {
            position: relative;
        }

        .input-group-custom i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            font-size: 1.1rem;
            transition: color 0.3s;
        }

        .form-control-custom {
            width: 100%;
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid #334155;
            border-radius: 12px;
            padding: 12px 16px 12px 48px;
            color: #ffffff;
            font-size: 0.95rem;
            outline: none;
            transition: all 0.3s;
        }

        .form-control-custom:focus {
            border-color: #e53e3e;
            box-shadow: 0 0 0 4px rgba(229, 62, 62, 0.15);
            background: rgba(15, 23, 42, 0.9);
        }

        .form-control-custom:focus + i {
            color: #e53e3e;
        }

        .btn-submit {
            width: 100%;
            background: linear-gradient(135deg, #e53e3e 0%, #c53030 100%);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 8px 20px rgba(229, 62, 62, 0.3);
            margin-top: 10px;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(229, 62, 62, 0.4);
        }

        .alert-custom {
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #fca5a5;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 0.85rem;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="brand-header">
            <img src="/images/logo.png" alt="Aaksh News 24 Logo" onerror="this.src='https://via.placeholder.com/54'">
            <h2>AAKSH <span>NEWS 24</span></h2>
            <p>Admin Dashboard Portal Access</p>
        </div>

        @if(session('error'))
            <div class="alert-custom">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="alert-custom">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <form action="/admin/login" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label">Email Address</label>
                <div class="input-group-custom">
                    <input type="email" name="email" class="form-control-custom" placeholder="admin@newsportal.in" value="{{ old('email', 'admin@newsportal.in') }}" required autofocus>
                    <i class="fas fa-envelope"></i>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>
                <div class="input-group-custom">
                    <input type="password" name="password" class="form-control-custom" placeholder="••••••••" value="admin123" required>
                    <i class="fas fa-lock"></i>
                </div>
            </div>

            <button type="submit" class="btn-submit">
                <i class="fas fa-sign-in-alt me-2"></i> Log In to Dashboard
            </button>
        </form>

        <div style="text-align: center; margin-top: 25px;">
            <a href="http://localhost:3001" style="color: #64748b; font-size: 0.85rem; text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='#cbd5e1'" onmouseout="this.style.color='#64748b'">
                <i class="fas fa-arrow-left me-1"></i> Back to Main News Portal
            </a>
        </div>
    </div>
</body>
</html>
