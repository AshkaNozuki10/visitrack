<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
</head>
@include('partials.nav', ['hideLinks' => true])

<body class="bg-custom fs-5">
    <div class="container">
        <div class="row align-items-center" style="min-height: 80vh;">
            <div class="col-md-4 mx-auto">
                <div class="card p-4 shadow-lg rounded-5" style="max-width: 400px; margin: 0 auto;">
                    <h4 class="text-center mb-4">Forgot Password</h4>
                    
                    @if(session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" 
                                class="form-control @error('email') is-invalid @enderror" 
                                id="email" 
                                name="email" 
                                value="{{ old('email') }}"
                                placeholder="e.g. name@gmail.com"
                                required 
                                autocomplete="email">
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary fw-bold" style="background-color: #7749F8; width: 120px; padding: 0.5rem 1rem;">
                                Send Code
                            </button>
                        </div>
                    </form>

                    <div class="text-center mt-3">
                        <a href="{{ route('auth.login') }}" class="text-primary">Back to Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('partials.footer')
</body>
</html>