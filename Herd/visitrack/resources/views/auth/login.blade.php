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
                   <form >
                       <!-- Email Input -->
                       <div class="mb-2 fs-5 px-3">
                           <label for="email" class="form-label">Email</label>
                           <input type="email" class="form-control" id="email" placeholder="Enter your email" required>
                       </div>
                       <!-- Password Input -->
                       <div class="mb-2 fs-5 px-3">
                           <label for="password" class="form-label">Password</label>
                           <input type="password" class="form-control" id="password" placeholder="Enter your password" required>
                       </div>
                       <!-- Login Button -->
                       <div class="px-5">
                           <button type="submit" class="btn btn-primary fw-bold ms-5" style="background-color: #7749F8;">
                            Login
                        </button>
                       </div>
                   </form>  
                   <!-- Forgot Password Link -->
                   <div class="text-center mt-1 fs-6">
                       <a href="#" class="text-primary">Forgot Password?</a>
                   </div>
               </div>
               <p class="text-center mt-2">Create a peaceful environment.</p>
           </div>   
       </div>
   </div>
   @include('partials.footer')
</body>


</html>