<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Visitrack') }}</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    {{-- local bootstrap config --}}
    @vite(['resources/css/app.css', 'resources/js/app.js']) {{-- <-- This links to the compiled assets --}}

    @yield('styles')
</head>
<body>
    <div id="app">
        @hasSection('custom_admin_nav')
            @yield('custom_admin_nav')
        @else
            <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                <div class="container">
                    <a class="navbar-brand fw-bold" href="{{ url('/') }}">
                        <i class="fa-solid fa-qrcode me-2"></i>{{ config('app.name', 'Visitrack') }}
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav me-auto">
                            @auth
                                @php $role = Auth::user()->information->role ?? 'visitor'; @endphp
                                @if($role === 'admin')
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-gauge me-1"></i>Admin Dashboard</a>
                                    </li>
                                @else
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('visitor.dashboard') }}"><i class="fa-solid fa-calendar-check me-1"></i>My Dashboard</a>
                                    </li>
                                @endif
                            @endauth
                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ms-auto">
                            @guest
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('show.register') }}">Register</a>
                                </li>
                            @else
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                        <span class="me-2"><i class="fa-solid fa-user-circle fa-lg"></i></span>
                                        <span>{{ Auth::user()->information ? Auth::user()->information->first_name : Auth::user()->username }}</span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end shadow">
                                        <li>
                                            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                                            @csrf
                                                <button type="submit" class="dropdown-item text-danger"><i class="fa-solid fa-right-from-bracket me-2"></i>Logout</button>
                                        </form>
                                        </li>
                                    </ul>
                                </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>
        @endif
        <main class="py-4">
            @if(session('status'))
                <div class="container">
                    <div class="alert alert-info">
                        {{ session('status') }}
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="container">
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                </div>
            @endif

        @yield('content')
        </main>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    @yield('scripts')
</body>
</html> 