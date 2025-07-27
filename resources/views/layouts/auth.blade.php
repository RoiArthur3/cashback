<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Cashback Market - Connexion')</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Styles personnalisés -->
    <style>
        body { 
            background: #f3f4f6;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
        }
        .auth-card {
            background: white;
            border-radius: 1rem;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            width: 100%;
            max-width: 28rem;
            overflow: hidden;
        }
        .auth-header {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: white;
            padding: 2rem;
            text-align: center;
        }
        .auth-logo {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        .auth-title {
            font-size: 1.25rem;
            font-weight: 500;
            opacity: 0.9;
        }
        .auth-body {
            padding: 2rem;
        }
        .form-group {
            margin-bottom: 1.25rem;
        }
        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #374151;
        }
        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            font-size: 1rem;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .form-input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
        }
        .btn-primary {
            display: block;
            width: 100%;
            background: #2563eb;
            color: white;
            font-weight: 500;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            text-align: center;
            transition: background-color 0.2s;
        }
        .btn-primary:hover {
            background: #1d4ed8;
        }
        .auth-footer {
            margin-top: 1.5rem;
            text-align: center;
            font-size: 0.875rem;
            color: #6b7280;
        }
        .auth-footer a {
            color: #2563eb;
            font-weight: 500;
            text-decoration: none;
        }
        .auth-footer a:hover {
            text-decoration: underline;
        }
        .social-login {
            margin-top: 1.5rem;
            display: flex;
            gap: 1rem;
        }
        .social-btn {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0.5rem;
            border: 1px solid #d1d5db;
            border-radius: 0.5rem;
            background: white;
            color: #4b5563;
            font-weight: 500;
            transition: all 0.2s;
        }
        .social-btn:hover {
            background: #f9fafb;
            border-color: #9ca3af;
        }
        .social-btn i {
            margin-right: 0.5rem;
            font-size: 1.25rem;
        }
        .divider {
            display: flex;
            align-items: center;
            margin: 1.5rem 0;
            color: #9ca3af;
            font-size: 0.875rem;
        }
        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e5e7eb;
            margin: 0 0.75rem;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <div class="auth-logo">Cashback Market</div>
                <div class="auth-title">@yield('auth-title', 'Bienvenue')</div>
            </div>
            <div class="auth-body">
                @yield('content')
            </div>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
