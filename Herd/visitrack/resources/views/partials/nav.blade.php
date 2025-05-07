<nav class="navbar">

    <div class="navigation">
        <a href="{{ route('home') }}" class="logo">Visitrack</a>
    </div>

    <div class="navbar2">
        <div class="">
            <a  target="" id="login_btn">Login</a>
            <a  target="">
                <button class="signup_btn">Register</button>
            </a>
        </div>
    </div>

</nav>



<link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">

<nav class="navbar navbar-expand-lg sticky-top py-2" style="background-color: #476FB2; font-family: 'Lato', sans-serif;">
    <div class="container-fluid" style="margin-left: 5rem;">
        <!-- Left Side: Title -->
        <a class="navbar-brand text-white  ms-5 fs-2 fw-bold" href="/home" id="logo">Visitrack</a>
         <!-- Right Side: About and Login/Sign Up -->
         <div class="d-flex align-items-center">
            <!-- About Link -->
            <a class="nav-link text-white me-3 fs-5" href="#stay-aware" id="about">About</a>
             <!-- Login and Sign Up -->
             <div class="d-flex border border-white p-1 rounded-pill" style="margin-right: 3rem;">
                <a href="{{ route('auth.login')}}" class="btn text-white fw-bold fs-6">Login</a>
                <a href="{{ route('auth.registration')}}" class="btn btn-light signup_btn rounded-pill fw-bold fs-6">Sign Up</a>
            </div>
        </div>
    </div>
</nav>