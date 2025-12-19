<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BMTPC Mobile App Content Admin - Login</title>
    <link rel="icon" type="image/png" href="{{ asset('public/assets/img/logo.png') }}">

    <link rel="stylesheet" href="{{ asset('public/assets/css/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/assets/css/adminlogin.css') }}">
</head>

<body>
    <div class="login-container">

        <div class="login-header">
            Building Materials & Technology Promotion Council (BMTPC) <br>
            <small>Mobile App Content Administration</small>
        </div>

        <!-- @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif -->

        <form class="login-form" action="{{ route('admin.login.post') }}" method="POST">
            @csrf	

            <div class="mb-3">
                <label for="email" class="form-label">Email Address *</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email">
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror

            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password *</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Enter password">
                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror

            </div>

            <div class="mb-3">
                <label class="form-label">Enter characters being displayed in above image *</label>
                <div class="d-flex align-items-center captcha mb-2">
                    <img src="{{ captcha_src('default') }}" id="captcha-img" alt="captcha">
                    <button type="button" onclick="refreshCaptcha()" class="btn-refresh"
                        id="refresh-captcha">&#x21bb;</button>
                </div>
                <input type="text" id="captcha" name="captcha" class="form-control" placeholder="Captcha Code"
                    autocomplete="off">
                @error('captcha')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-success w-50 me-2">Login</button>
                <button type="reset" class="btn btn-secondary w-50">Reset</button>
            </div>
        </form>
    </div>

    <script src="{{ asset('public/assets/js/bootstrap.bundle.min.js') }}"></script>

    <script>
        function refreshCaptcha() {
            document.getElementById('captcha-img').src = "{{ captcha_src('default') }}" + "?" + Math.random();
            document.getElementById('captcha').value = '';
        }
    </script>
</body>

</html>