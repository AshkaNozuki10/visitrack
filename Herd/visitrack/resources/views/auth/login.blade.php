<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Visitrack - Login</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="stylesheet" href="{{ asset('css/partials.css') }}">
</head>
<body>
    @include('partials.nav')

    <div class="main-container">
        <img src="{{ asset('css/img/building.png')}}" alt="Building" class="building">
        
        <div class="form-container">
            <div class="logo">visitrack</div>
            <div class="tagline">Know your safe</div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <form id="login_form" action="{{ route('auth.login')}}" method="POST">
                @csrf
                <div class="login-form">
                    <!--Username or email-->
                    <div class="form-group">
                        <input type="text" 
                            class="form-control @error('username') is-invalid @enderror" 
                            name="username"
                            value="{{ old('username') }}"
                            placeholder="Username:"
                            required
                            autocomplete="username">
                        @error('username')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!--Password-->
                    <div class="form-group">
                        <input type="password" 
                            class="form-control @error('password') is-invalid @enderror"
                            name="password"
                            placeholder="Password:"
                            required
                            autocomplete="current-password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div class="remember-me">
                            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label for="remember">Remember me</label>
                        </div>
                    </div>

                    @if(session('error'))
                    <div class="alert alert-danger">
                        <strong>Error:</strong> {{ session('error') }}
                    </div>
                    @endif
                    
                    <button type="submit" class="login-btn">Log In</button>

                    <div class="forgot-password">
                        <a href="#">Forgot Password?</a>
                    </div>

                    <a href="{{ route('auth.registration') }}" class="register-link">
                        <button type="button" class="register-btn">Register</button>
                    </a>
                </div>

                <div class="footer-text">Create a peaceful environment.</div>
            </form>
        </div>
    </div>

    @include('partials.footer')

</body>
</html>