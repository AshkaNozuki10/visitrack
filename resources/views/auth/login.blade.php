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
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<body >
    <!-- Navigation -->
   @include('partials.nav')

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
                    <div class="card-header text-center" style="background-color:#476FB2"; border: none; padding: 25px;">
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
                            <div class="d-flex justify-content-center mt-3">
                                <button type="submit" class="btn btn-primary animate__animated animate__pulse animate__infinite animate__slow" style="width: 200px; background: linear-gradient(135deg, #7749F8, #5a36c9); border: none; border-radius: 50px; padding: 12px; font-size: 1.1rem; font-weight: 600; letter-spacing: 1px; box-shadow: 0 10px 20px rgba(90, 54, 201, 0.3);">
                                    <i class="fas fa-sign-in-alt me-2"></i> Login
                                </button>
                            </div>
                        </form>

                        <div class="divider"></div>

                        <!-- Form Links -->
                        <div class="form-links d-flex justify-content-between mt-3">
                            <a href="{{ route('forgotpass') }}" class="btn btn-link" style="color: #0D6EFD; text-decoration: none; padding: 8px 12px; transition: all 0.3s ease;">
                                <i class="fas fa-key me-1"></i> Forgot Password?
                            </a>
                            <a href="{{ route('show.register') }}" class="btn" style="background-color: rgba(119, 73, 248, 0.1); color:#0D6EFD; border-radius: 50px; padding: 8px 16px; transition: all 0.3s ease;">
                                <i class="fas fa-user-plus me-1"></i> Create an account
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    
    @include('partials.footer')

<<<<<<< HEAD:resources/views/auth/login.blade.php
                       <!-- Login Button -->
                       <div class="px-5 ms-2">
                           <button type="submit" class="btn btn-primary fw-bold ms-5" style="background-color: #7749F8;">
                            Login
                        </button>
                       </div>
                   </form>  
                   <!-- Forgot Password Link -->
                   <div class="text-center mt-1 fs-6">
                       <a href="#" class="text-primary">Forgot Password?</a>
                   </div>

                   <div class="text-center mt-1 fs-6">
                       <a href="{{ route('show.register') }}" class="text-primary">Create an account</a>
                   </div>
                   
               </div>
               <p class="text-center mt-2">Create a peaceful environment.</p>
           </div>   
       </div>
   </div>
   @include('partials.footer')
=======
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
>>>>>>> 6e30a1d51f314c99c4e42fd3a8bfdc8657652a4c:Herd/visitrack/resources/views/auth/login.blade.php
</body>

</html>
