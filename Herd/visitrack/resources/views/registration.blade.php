<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
</head>

<!-- Nav Bar -->

@include('partials.nav');

<body>
    <div class="container">
        <div class="header">
            <h1>Register</h1>
        </div>
        <div class="form-container">
            <h2>New User?</h2>
            <p class="form-description">Use the form below to create your account</p>

            <form id="registration_form" action="{{ route('register')}}" method="POST">
                @csrf
                <div class="form-row">
                    <!-- Last Name -->
                    <div class="form-group">
                        <label for="lastName">Last Name: <span class="required">*</span></label>
                        <input type="text" 
                               id="lastName"
                               name="last_name"
                               value="{{ old('last_name') }}" required>
                    </div>

                    <!-- First Name -->
                    <div class="form-group">
                        <label for="firstName">First Name: <span class="required">*</span></label>
                        <input type="text" 
                               id="firstName"
                               name="first_name"
                               value="{{ old('first_name') }}" required>
                    </div>

                    <!-- Middle Name -->
                    <div class="form-group">
                        <label for="middleName">Middle Name: <span class="required">*</span></label>
                        <input type="text" 
                               id="middleName"
                               name="middle_name"
                               value="{{ old('middle_name') }}">
                    </div>
                </div>

                <div class="form-row">   
                    <!-- Sex -->
                        <div class="form-group">
                            <label>Sex: <span class="required">*</span></label>
                            <div class="radio-group">
                                <label for="male">
                                    <input type="radio" id="male" name="sex" value="{{ old('male') }}" required> Male
                                </label>
                                <label for="female">
                                    <input type="radio" id="female" name="sex" value="{{ old('female') }}"> Female
                                </label>
                            </div>
                        </div>
                </div>

                <div class="form-row">
                     <!-- Birth Date -->
                     <div class="form-group">
                        <label for="birthDate">Birth Date: <span class="required">*</span></label>
                        <input type="date" 
                               id="birthDate" 
                               name="birthdate" 
                               value="{{ old('birthdate') }}" required>
                    </div>
                </div>

                <div class="form-row">
                     <!--Email-->
                     <div class="form-group">
                        <label for="email">Email: <span class="required">*</span></label>
                        <input type="email" 
                               id="email" 
                               name="username" 
                               value="{{ old('username') }}"required>
                    </div>

                    <!--Password-->
                    <div class="form-group">
                        <label for="password">Password: <span class="required">*</span></label>
                        <input type="password" 
                               id="password" 
                               name="password"
                               value="{{ old('password') }}" required>
                    </div>

                    <!--Repeat password-->
                    <div class="form-group">
                        <label for="repeatPassword">Repeat Password: <span class="required">*</span></label>
                        <input type="password" 
                               id="repeatPassword" 
                               name="password_confirmation" required>
                    </div>
                </div>

                <div class="form-row">   
                    <!-- Sex -->
                        <div class="form-group">
                            <label>Role: <span class="required">*</span></label>
                            <div class="radio-group">
                                <label for="student">
                                    <input type="radio" id="student" name="role" value="{{ old('student') }}" required> Student
                                </label>
                                <label for="non_student">
                                    <input type="radio" id="non_student" name="role" value="{{ old('non_student') }}"> Non Student
                                </label>
                                <label for="contractor">
                                    <input type="radio" id="contractor" name="role" value="{{ old('contractor') }}"> Contractor
                                </label>
                                <label for="faculty">
                                    <input type="radio" id="faculty" name="role" value="{{ old('faculty') }}"> Faculty
                                </label>
                            </div>
                        </div>
                </div>

                <div class="form-buttons">
                    <a href="/login.php">
                        <button type="button" class="btn-cancel">Cancel</button>
                    </a>
                    <button type="submit" class="btn-register">Register</button>

                    <!--Validation-->
                        @if($errors->any())
                        <ul class="px-4 py-2 bg-red-100">
                            @foreach ($errors-> all() as $error)
                                <li class="my-2 text-red-500">{{$error}}</li>
                            @endforeach
                        </ul>
                        @endif
                </div>
            </form>
        </div>
    </div>
</body>

<!-- FOOTER -->

@include('partials.footer');

</html>