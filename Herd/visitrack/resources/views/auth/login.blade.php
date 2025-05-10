<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Visitrack - Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Animate.css for animations -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #7749F8;
            --secondary-color: #5a36c9;
            --bg-color: #f5f7ff;
            --text-color: #333;
            --light-color: #ffffff;
            --accent-color: #4a89dc;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #6b8cce, #7749F8);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
            color: var(--text-color);
            min-height: 100vh;
            overflow-x: hidden;
        }
        
        @keyframes gradientBG {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }
        
        .main-container {
            min-height: 85vh;
        }
        
        .logo-text {
            font-weight: 700;
            color: var(--light-color);
            letter-spacing: 1px;
            font-size: 2.5rem;
        }
        
        .tagline {
            color: var(--light-color);
            font-weight: 300;
            letter-spacing: 0.5px;
        }
        
        .login-card {
            border-radius: 20px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            background-color: rgba(255, 255, 255, 0.95);
            border: none;
        }
        
        .login-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }
        
        .card-header {
            background-color: var(--light-color);
            border-bottom: 2px solid rgba(119, 73, 248, 0.2);
            padding: 20px;
        }
        
        .form-control {
            height: 50px;
            border-radius: 10px;
            border: 1px solid #e0e0e0;
            padding-left: 15px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(119, 73, 248, 0.2);
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border: none;
            border-radius: 10px;
            height: 50px;
            font-weight: 600;
            letter-spacing: 0.5px;
            box-shadow: 0 5px 15px rgba(119, 73, 248, 0.3);
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background-color: var(--secondary-color);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(119, 73, 248, 0.4);
        }
        
        .btn-primary:active {
            transform: translateY(0);
        }
        
        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .form-label {
            font-weight: 500;
            color: #555;
        }
        
        .input-group {
            position: relative;
        }
        
        .input-icon {
            position: absolute;
            top: 17px;
            left: 15px;
            color: #aaa;
            z-index: 10;
        }
        
        .input-with-icon {
            padding-left: 45px;
        }
        
        .form-links {
            font-size: 0.9rem;
            font-weight: 500;
        }
        
        .form-links a {
            color: var(--primary-color);
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .form-links a:hover {
            color: var(--secondary-color);
            text-decoration: underline;
        }
        
        .footer {
            background-color: rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(5px);
            color: var(--light-color);
            padding: 15px 0;
        }
        
        .footer a {
            color: var(--light-color);
            text-decoration: none;
        }
        
        .divider {
            height: 1px;
            background: linear-gradient(to right, transparent, rgba(255, 255, 255, 0.5), transparent);
            margin: 15px 0;
        }
        
        .building-img {
            max-height: 80vh;
            object-fit: cover;
            transition: all 0.5s ease;
            filter: drop-shadow(5px 5px 15px rgba(0, 0, 0, 0.3));
        }
        
        /* Animation classes */
        .slide-in-left {
            animation: slideInLeft 1s ease forwards;
        }
        
        .slide-in-right {
            animation: slideInRight 1s ease forwards;
        }
        
        .fade-in-up {
            animation: fadeInUp 1s ease forwards;
        }
        
        @keyframes slideInLeft {
            from {
                transform: translateX(-100px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        @keyframes slideInRight {
            from {
                transform: translateX(100px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        @keyframes fadeInUp {
            from {
                transform: translateY(30px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
        
        /* Password visibility toggle */
        .password-toggle {
            position: absolute;
            right: 15px;
            top: 17px;
            cursor: pointer;
            color: #aaa;
            z-index: 10;
        }
        
        /* Mobile responsiveness */
        @media (max-width: 992px) {
            .building-container {
                margin-bottom: 2rem;
                text-align: center;
            }
            
            .building-img {
                max-height: 50vh;
                margin: 0 auto;
            }
            
            .login-container {
                padding: 0 20px;
            }
        }
        
        @media (max-width: 576px) {
            .login-card {
                margin: 10px;
            }
            
            .building-img {
                max-height: 40vh;
            }
            
            .logo-text {
                font-size: 2rem;
            }
        }
        
        /* Alert styles */
        .alert {
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
        
        .alert-danger {
            background-color: #ffe6e6;
            border-left: 4px solid #ff4d4d;
            color: #cc0000;
        }
        
        .alert-success {
            background-color: #e6ffee;
            border-left: 4px solid #33cc66;
            color: #00994d;
        }
    </style>
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg" style="background: linear-gradient(135deg, rgba(78, 84, 200, 0.9), rgba(119, 73, 248, 0.9)); backdrop-filter: blur(10px); box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); padding: 15px 0;">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <div class="d-flex align-items-center">
                    <span class="me-2 animate__animated animate__fadeIn">
                        <svg width="30" height="30" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M12 16V12" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M12 8H12.01" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                    <span class="fw-bold text-white" style="font-size: 1.3rem; letter-spacing: 1px;">Visitrack</span>
                </div>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item mx-2">
                        <a class="nav-link active position-relative" href="#" style="color: white; font-weight: 500; padding: 8px 15px;">
                            Home
                            <span class="position-absolute" style="height: 2px; width: 100%; background-color: white; bottom: 0; left: 0; transform: scaleX(1); transition: transform 0.3s ease;"></span>
                        </a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link position-relative" href="#" style="color: rgba(255, 255, 255, 0.8); font-weight: 500; padding: 8px 15px;">
                            About
                            <span class="position-absolute" style="height: 2px; width: 100%; background-color: white; bottom: 0; left: 0; transform: scaleX(0); transition: transform 0.3s ease;"></span>
                        </a>
                    </li>
                    <li class="nav-item mx-2">
                        <a class="nav-link position-relative" href="#" style="color: rgba(255, 255, 255, 0.8); font-weight: 500; padding: 8px 15px;">
                            Contact
                            <span class="position-absolute" style="height: 2px; width: 100%; background-color: white; bottom: 0; left: 0; transform: scaleX(0); transition: transform 0.3s ease;"></span>
                        </a>
                    </li>
                    <li class="nav-item ms-3">
                        <a class="btn px-4 py-2" href="#" style="background-color: rgba(255, 255, 255, 0.15); color: white; border-radius: 50px; backdrop-filter: blur(5px); transition: all 0.3s ease;">
                            <i class="fas fa-user-circle me-1"></i> Login
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container main-container">
        <!-- Alerts -->
        @if ($errors->any())
        <div class="alert alert-danger animate__animated animate__fadeIn mt-3">
            <i class="fas fa-exclamation-circle me-2"></i>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @if (session('status'))
        <div class="alert alert-success animate__animated animate__fadeIn mt-3">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('status') }}
        </div>
        @endif

        <div class="row align-items-center" style="min-height: 80vh;">
            <!-- Left Column: Building Image -->
            <div class="col-lg-6 building-container slide-in-left">
                <div class="text-start mb-4 ps-4">
                    <h1 class="logo-text animate__animated animate__fadeIn mb-0" style="font-size: 3.2rem; position: relative; z-index: 1; text-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                        <span style="color: #fff;">visi</span><span style="color: #f0f0f0;">track</span>
                        <div style="position: absolute; top: -10px; right: -15px; width: 40px; height: 40px; background: rgba(255,255,255,0.15); border-radius: 50%; z-index: -1;" class="animate__animated animate__pulse animate__infinite animate__slow"></div>
                    </h1>
                    <p class="tagline animate__animated animate__fadeIn animate__delay-1s" style="font-size: 1.2rem; letter-spacing: 1px; margin-left: 5px;">Know your safe</p>
                </div>
                <img src="{{ asset('css/img/building.png') }}" alt="Lab building" class="img-fluid building-img animate__animated animate__fadeIn animate__delay-1s">
                <p class="text-center mt-4 text-light">Create a peaceful environment.</p>
            </div>

            <!-- Right Column: Login Form -->
            <div class="col-lg-6 login-container slide-in-right">
                <div class="card login-card animate__animated animate__fadeInUp animate__delay-1s" style="border-radius: 16px; overflow: hidden;">
                    <div class="card-header text-center" style="background: linear-gradient(to right, #7749F8, #5a36c9); border: none; padding: 25px;">
                        <h4 class="mb-0 fw-bold" style="color: white; letter-spacing: 0.5px;">Login to your account</h4>
                    </div>
                    <div class="card-body p-4">
                        <form id="login_form" action="{{ route('auth.login')}}" method="POST">
                            @csrf
                            
                            <!-- Username Input -->
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <div class="input-group">
                                    <span class="input-icon">
                                        <i class="fas fa-user"></i>
                                    </span>
                                    <input type="text" 
                                           class="form-control input-with-icon @error('username') is-invalid @enderror" 
                                           name="username"
                                           value="{{ old('username') }}"
                                           placeholder="Enter your username"
                                           required
                                           autocomplete="username">
                                    @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Password Input -->
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-icon">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input type="password" 
                                           id="password"
                                           class="form-control input-with-icon @error('password') is-invalid @enderror"
                                           name="password"
                                           placeholder="Enter your password"
                                           required
                                           autocomplete="current-password">
                                    <span class="password-toggle" onclick="togglePassword()">
                                        <i class="fas fa-eye" id="toggleIcon"></i>
                                    </span>
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Remember Me -->
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">Remember me</label>
                            </div>

                            @if(session('error'))
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>Error:</strong> {{ session('error') }}
                            </div>
                            @endif

                            <!-- Login Button -->
                            <div class="d-grid gap-2 mt-4">
                                <button type="submit" class="btn btn-primary animate__animated animate__pulse animate__infinite animate__slow" style="background: linear-gradient(135deg, #7749F8, #5a36c9); border: none; border-radius: 50px; padding: 12px; font-size: 1.1rem; font-weight: 600; letter-spacing: 1px; box-shadow: 0 10px 20px rgba(90, 54, 201, 0.3);">
                                    <i class="fas fa-sign-in-alt me-2"></i> Login
                                </button>
                            </div>
                        </form>

                        <div class="divider"></div>

                        <!-- Form Links -->
                        <div class="form-links d-flex justify-content-between mt-3">
                            <a href="{{ route('forgotpass') }}" class="btn btn-link" style="color: #7749F8; text-decoration: none; padding: 8px 12px; transition: all 0.3s ease;">
                                <i class="fas fa-key me-1"></i> Forgot Password?
                            </a>
                            <a href="{{ route('show.register') }}" class="btn" style="background-color: rgba(119, 73, 248, 0.1); color: #7749F8; border-radius: 50px; padding: 8px 16px; transition: all 0.3s ease;">
                                <i class="fas fa-user-plus me-1"></i> Create an account
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer mt-5" style="background: linear-gradient(to right, rgba(78, 84, 200, 0.9), rgba(119, 73, 248, 0.9)); padding: 20px 0; box-shadow: 0 -5px 20px rgba(0, 0, 0, 0.1);">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-4">
                    <div class="d-flex align-items-center">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="me-2">
                            <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M12 16V12" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M12 8H12.01" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <p class="mb-0 text-white fw-bold">© 2025 Visitrack. All rights reserved.</p>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <div class="social-icons">
                        <a href="#" class="text-white mx-2"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-white mx-2"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-white mx-2"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-white mx-2"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-md-4 text-end">
                    <a href="#" class="text-white me-3" style="text-decoration: none;">Security</a>
                    <a href="#" class="text-white me-3" style="text-decoration: none;">Privacy</a>
                    <a href="#" class="text-white" style="text-decoration: none;">Terms</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JavaScript -->
    <script>
        // Toggle password visibility
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
        
        // Animation on scroll
        document.addEventListener('DOMContentLoaded', function() {
            // Animate elements when they come into view
            const animateOnScroll = function() {
                const elements = document.querySelectorAll('.animate-on-scroll');
                
                elements.forEach(element => {
                    const elementPosition = element.getBoundingClientRect().top;
                    const screenPosition = window.innerHeight;
                    
                    if (elementPosition < screenPosition) {
                        element.classList.add('animate__animated');
                        element.classList.add('animate__fadeInUp');
                    }
                });
            };
            
            window.addEventListener('scroll', animateOnScroll);
            
            // Initial check for elements in view
            animateOnScroll();
        });
    </script>
</body>

</html>
