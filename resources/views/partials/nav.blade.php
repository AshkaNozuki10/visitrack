<link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
<<<<<<< HEAD
<nav class="navbar navbar-expand-lg sticky-top" style="background-color: #476FB2; font-family: 'Lato', sans-serif;">
    <div class="container-fluid">
        <!-- Left Side: Title -->
        <a class="navbar-brand text-white ms-5 fs-2 fw-bold" href="/" id="logo">Visitrack</a>

        <!-- Right Side: About and Login/Sign Up -->
        @if(!isset($hideLinks) || !$hideLinks)
            <div class="d-flex align-items-center">
                <!-- About Link -->
                <a class="nav-link text-white me-3 fs-5" href="#stay-aware" id="about">About</a>

                <!-- Login and Sign Up -->
                <div class="d-flex border border-white p-1 rounded-pill" style="margin-right: 3rem;">
                    <a href="{{ route('show.login') }}" class="btn text-white fw-bold fs-6">Login</a>
                    <a href="{{ route('show.register') }}" class="btn btn-light signup_btn rounded-pill fw-bold fs-6">Sign Up</a>
=======
<nav class="navbar navbar-expand-lg sticky-top" style="background: rgba(72, 111, 178, 0.85); backdrop-filter: blur(8px); font-family: 'Poppins', sans-serif; border-radius: 0 0 24px 24px; box-shadow: 0 4px 24px rgba(72, 111, 178, 0.10); min-height: 70px;">
    <div class="container-fluid py-2 px-4">
        <!-- Left Side: Title -->
        <a class="navbar-brand fw-bold fs-2" href="/" id="logo" style="color: #fff; letter-spacing: 2px; text-shadow: 0 2px 8px #4a89dc55;">Visitrack</a>

        <!-- Right Side: About and Login/Sign Up -->
        @if(!isset($hideLinks) || !$hideLinks)
            <div class="d-flex align-items-center gap-3">
                <!-- About Link -->
                <a class="nav-link fs-5 fw-semibold" href="#stay-aware" id="about" style="color: #fff; transition: color 0.2s;">About</a>

                <!-- Login and Sign Up -->
                <div class="d-flex align-items-center gap-2 ms-2">
                    <a href="/login" class="btn fw-bold fs-6 px-4" style="color: #fff; background: transparent; border: 2px solid #fff; border-radius: 2rem; transition: background 0.2s, color 0.2s;">Login</a>
                    <a href="/register" class="btn fw-bold fs-6 px-4" style="background: linear-gradient(90deg, #ff6bcb 0%, #7749F8 100%); color: #fff; border: none; border-radius: 2rem; box-shadow: 0 2px 12px #7749f855; transition: background 0.2s, color 0.2s;">Sign Up</a>
>>>>>>> 2e02c0059258e474ba4d81b53ee3ad30139fb789
                </div>
            </div>
        @endif
    </div>
<<<<<<< HEAD
</nav>
=======
</nav>
<style>
    .navbar .nav-link:hover, .navbar .btn:hover {
        color: #ff6bcb !important;
        background: rgba(255,255,255,0.08) !important;
        text-decoration: none;
    }
    .navbar .btn[style*="background: linear-gradient"]:hover {
        background: linear-gradient(90deg, #7749F8 0%, #ff6bcb 100%) !important;
        color: #fff !important;
    }
    @media (max-width: 576px) {
        .navbar-brand { font-size: 1.3rem !important; }
        .navbar .btn, .navbar .nav-link { font-size: 1rem !important; padding: 0.4rem 1.2rem !important; }
    }
</style>
>>>>>>> 2e02c0059258e474ba4d81b53ee3ad30139fb789
