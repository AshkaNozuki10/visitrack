<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visitrack - Login</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="stylesheet" href="{{ asset('css/partials.css') }}">
</head>

<body>

    <!-- NAV BAR -->
    @include('partials.nav');

    <div class="main-container">
        <div class="building-container">
            <img src="/css/img/building.png" alt="Building" class="building-img">
        </div>

            <div class="form-container">
                <div class="logo">visitrack</div>
                <div class="tagline">Know your safe</div>

                    <form id="login_form" action="{{ route('login')}}" method="POST">
                        <div class="login-form">
                            <!--Username or email-->
                            <div class="form-group">
                                <input type="text" 
                                    class="form-control" 
                                    name="username"
                                    value="{{ old('username') }}"
                                    placeholder="Username:" required>
                            </div>

                            <!--Password-->
                            <div class="form-group">
                                <input type="password" 
                                    class="form-control"
                                    name="password"
                                    value="{{ old('password') }}"
                                    placeholder="Password:" required>
                            </div>

                            <button type="submit" class="login-btn">Log In</button>

                            <div class="forgot-password">
                                <a href="#">Forgot Password?</a>
                            </div>

                            <a href="{{ route('register') }}">
                                <button type="button" class="register-btn">Register</button>
                            </a>

                        </div>

                        <div class="footer-text">Create a peaceful environment.</div>
                    </form>
            </div>
        </div>

</body>

<!-- NAV BAR -->

    @include('partials.footer');

</html>