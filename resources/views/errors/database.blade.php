<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>404 | Page Not Found</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('public/assets/img/logo.png') }}">

    {{-- Bootstrap (optional) --}}
    <link rel="stylesheet" href="{{ asset('public/assets/css/bootstrap/bootstrap.min.css') }}">

    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea, #764ba2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-family: 'Segoe UI', sans-serif;
        }
        .error-box {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(12px);
            padding: 50px;
            border-radius: 16px;
            text-align: center;
            max-width: 420px;
            width: 100%;
            box-shadow: 0 20px 40px rgba(0,0,0,0.25);
        }
        .error-code {
            font-size: 96px;
            font-weight: 800;
            margin-bottom: 10px;
            letter-spacing: 4px;
        }
        .error-text {
            font-size: 20px;
            opacity: 0.9;
        }
        .btn-home {
            margin-top: 25px;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
        }
    </style>
</head>
<body>

    <div class="error-box">
        <div class="error-code">Database Error</div>
        <h3>Database Error</h3>
        <p class="error-text">
            {{ $exception->getMessage() }}
        </p>

        <a href="{{ url('/admin/dashboard') }}" class="btn btn-light btn-home">
            Go to Homepage
        </a>
    </div>

</body>
</html>
