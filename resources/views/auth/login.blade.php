<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Visitrack - Login</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

@include('partials.nav', ['hideLinks' => true])

<body class="bg-custom fs-5">
   <div class="container">

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

       <div class="row align-items-center" style="min-height: 80vh;">
           <!-- Left Column: Image -->
           <div class="col-md-6 d-flex justify-content-center align-items-end mt-auto" style="min-height: 80vh;">
    <img src="{{ asset('css/img/building.png') }}" alt="Lab building" class="img-fluid">
</div>
    
           <!-- Right Column: Form -->
           <div class="col-md-4 ps-5 ms-5">

            <h1 class="text-center">visitrack</h1>
            <p class="text-center ">Know your safe</p>

               <div class="card p-4 shadow-lg rounded-5">
                   <h4 class="text-center mb-1">Login</h4>
                  <form id="login_form" action="{{ route('auth.login')}}" method="POST">
                  @csrf
                       <!-- Email Input -->
                       <div class="mb-2 fs-5 px-3">
                           <label for="email" class="form-label">Email</label>
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
                       </div>

                       <!-- Password Input -->
                       <div class="mb-2 fs-5 px-3">
                           <label for="password" class="form-label">Password</label>
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
                       </div>

                       <!-- Remember Me -->
                       <div class="mb-2 fs-5 px-3">
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

                   <a href="{{ route('auth.registration') }}" class="text-center mt-1 fs-6">Create an account</a></a>
                   
               </div>
               <p class="text-center mt-2">Create a peaceful environment.</p>
           </div>   
       </div>
   </div>
   @include('partials.footer')
</body>


</html>