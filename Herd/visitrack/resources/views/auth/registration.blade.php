<!-- resources/views/auth/register.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VisiTrack - Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
    <style>
        .required { color: red; }
        .form-container { max-width: 800px; margin: auto; padding: 20px; }
        .form-row { display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 15px; }
        .form-group { flex: 1; min-width: 200px; }
        .radio-group label { margin-right: 15px; }
        .form-buttons { display: flex; gap: 10px; justify-content: flex-end; }
        .error-messages { color: red; list-style: none; padding: 0; }
    </style>
</head>
<body>
    @include('partials.nav')
    <div class="container mt-5">
        <div class="header text-center mb-4">
            <h1>Register</h1>
        </div>
        <div class="form-container card shadow-sm p-4">
            <h2>New User?</h2>
            <p class="form-description">Use the form below to create your account</p>

            @if(session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <form id="registration_form" action="{{ route('auth.registration') }}" method="POST">
                @csrf
                <div class="form-row">
                    <!-- Last Name -->
                    <div class="form-group">
                        <label for="lastName">Last Name: <span class="required">*</span></label>
                        <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="lastName" name="last_name" value="{{ old('last_name') }}" required>
                        @error('last_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- First Name -->
                    <div class="form-group">
                        <label for="firstName">First Name: <span class="required">*</span></label>
                        <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="firstName" name="first_name" value="{{ old('first_name') }}" required>
                        @error('first_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- Middle Name -->
                    <div class="form-group">
                        <label for="middleName">Middle Name:</label>
                        <input type="text" class="form-control @error('middle_name') is-invalid @enderror" id="middleName" name="middle_name" value="{{ old('middle_name') }}">
                        @error('middle_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <!-- Sex -->
                    <div class="form-group">
                        <label>Sex: <span class="required">*</span></label>
                        <div class="radio-group">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input @error('sex') is-invalid @enderror" type="radio" id="male" name="sex" value="male" {{ old('sex') == 'male' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="male">Male</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input @error('sex') is-invalid @enderror" type="radio" id="female" name="sex" value="female" {{ old('sex') == 'female' ? 'checked' : '' }}>
                                <label class="form-check-label" for="female">Female</label>
                            </div>
                            @error('sex')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <!-- Birth Date -->
                    <div class="form-group">
                        <label for="birthDate">Birth Date: <span class="required">*</span></label>
                        <input type="date" class="form-control @error('birthdate') is-invalid @enderror" id="birthDate" name="birthdate" value="{{ old('birthdate') }}" required>
                        @error('birthdate')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Address -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="address">Street Number: <span class="required">*</span></label>
                        <input type="text" class="form-control @error('street_no') is-invalid @enderror" id="address" name="street_no" value="{{ old('street_no') }}" required>
                        @error('street_no')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="address">Street Name: <span class="required">*</span></label>
                        <input type="text" class="form-control @error('street_name') is-invalid @enderror" id="address" name="street_name" value="{{ old('street_name') }}" required>
                        @error('street_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="address">Barangay: <span class="required">*</span></label>
                        <input type="text" class="form-control @error('barangay') is-invalid @enderror" id="address" name="barangay" value="{{ old('barangay') }}" required>
                        @error('barangay')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>


                <div class="form-row">
                    <div class="form-group">
                        <label for="address">District: <span class="required">*</span></label>
                        <input type="text" class="form-control @error('district') is-invalid @enderror" id="address" name="district" value="{{ old('district') }}" required>
                        @error('district')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="address">City: <span class="required">*</span></label>
                        <input type="text" class="form-control @error('city') is-invalid @enderror" id="address" name="city" value="{{ old('city') }}" required>
                        @error('city')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <!-- Email -->
                    <div class="form-group">
                        <label for="email">Email: <span class="required">*</span></label>
                        <input type="email" class="form-control @error('username') is-invalid @enderror" id="email" name="username" value="{{ old('username') }}" required>
                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- Password -->
                    <div class="form-group">
                        <label for="password">Password: <span class="required">*</span></label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" value="{{ old('password') }}" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- Repeat Password -->
                    <div class="form-group">
                        <label for="repeatPassword">Repeat Password: <span class="required">*</span></label>
                        <input type="password" class="form-control" id="repeatPassword" name="password_confirmation" value="{{ old('password_confirmation') }}"required>
                    </div>
                </div>

                <div class="form-row">
                    <!-- Role -->
                    <div class="form-group">
                        <label>Role: <span class="required">*</span></label>
                        <div class="radio-group">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input @error('role') is-invalid @enderror" type="radio" id="student" name="role" value="student" {{ old('role') == 'student' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="student">Student</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="non_student" name="role" value="non_student" {{ old('role') == 'non_student' ? 'checked' : '' }}>
                                <label class="form-check-label" for="non_student">Non Student</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="contractor" name="role" value="contractor" {{ old('role') == 'contractor' ? 'checked' : '' }}>
                                <label class="form-check-label" for="contractor">Contractor</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="faculty" name="role" value="faculty" {{ old('role') == 'faculty' ? 'checked' : '' }}>
                                <label class="form-check-label" for="faculty">Faculty</label>
                            </div>
                            @error('role')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-buttons">
                    <a href="{{ route('show.login') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Register</button>
                </div>

                <!-- Validation Errors -->
                @if ($errors->any())
                    <ul class="error-messages mt-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
            </form>
        </div>
    </div>
    @include('partials.footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>