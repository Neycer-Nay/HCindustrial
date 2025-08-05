<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Acceso restringido</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f4f6fb;
        }
        .error-container {
            max-width: 400px;
            margin: 80px auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            padding: 32px 24px;
            text-align: center;
        }
        .error-icon {
            font-size: 48px;
            color: #dc3545;
            margin-bottom: 16px;
        }
        .error-title {
            font-size: 22px;
            font-weight: bold;
            color: #333;
            margin-bottom: 12px;
        }
        .error-message {
            color: #555;
            margin-bottom: 24px;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-icon">
            <i class="fas fa-ban"></i>
        </div>
        <div class="error-title">Acceso restringido</div>
        <div class="error-message">
            {{ $mensaje }}
        </div>
        <a href="{{ route('dashboard.index') }}" class="btn btn-primary">Ir al inicio</a>
    </div>
    <script src="https://kit.fontawesome.com/2c36e9b7b1.js" crossorigin="anonymous"></script>
</body>
</html>