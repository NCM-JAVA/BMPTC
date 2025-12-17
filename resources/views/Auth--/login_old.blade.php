<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BMTPC Mobile App Content Admin - Login</title>
    <link rel="stylesheet" href="{{ asset('public/assets/css/adminlogin.css') }}">
</head>

<body>
    <div class="login-container">
        <div class="login-header">
            Building Materials & Technology Promotion Council (BMTPC) <br> Mobile App Content Administration
        </div>
        <form class="login-form" action="{{ route('login') }}" method="POST">
            @csrf
            <div>
                <label for="userid">{{ __('Email Address') }} *</label>
                <input type="email" id="userid" name="userid" placeholder="Enter your email" required>
            </div>
            <div>
                <label for="password">{{ __('Password') }} *</label>
                <input type="password" id="password" name="password" placeholder="Enter password" required>
            </div>
            <div>
                <div class="captcha">
                    <img src="{{ captcha_src('default') }}" id="captcha-img" alt="captcha">
                    <button type="button" onclick="refreshCaptcha()" class="btn-refresh" id="refresh-captcha">&#x21bb;</button>
                </div>
                <label for="captcha">Enter characters being displayed in above image *</label>
                <input type="text" id="captcha" name="captcha" placeholder="Captcha Code" autocomplete="off" placeholder="Verification" required>
            </div>

            <div style="display: flex; gap: 10px;">
                <button type="submit" class="btn btn-success">{{ __('Login') }}</button>
                <input type="reset" value="Reset">
            </div>
        </form>
    </div>

     <script>
        function refreshCaptcha() {
            document.getElementById('captcha-img').src = "{{ captcha_src('default') }}" + "?" + Math.random();
            document.getElementById('captcha').value = '';
        }
    </script>
</body>

</html>