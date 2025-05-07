<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visitrack - Home</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">  
    <link rel="stylesheet" href="{{ asset('css/partials.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Nav Bar -->
    @include('partials.nav')
</head>
<body class="bg-custom">
    <!-- Section 1 -->
    <section class="full-height">
    <div class="container">
        <div class="row align-items-center">
            <!-- Image Column -->
            <div class="col-md-6 d-flex justify-content-center">
                <img src="{{ asset('css/img/building.png') }}" alt="Lab building" class="img-fluid w-100">
            </div>
            <!-- Text Column -->
            <div class="col-md-6">
                <p class="h2">A REAL TIME LOCATION TRACKER FOR QCU VISITORS</p>
                <p>At Quezon City University, We Believe In Creating A Safe And <br> Connected Environment For Our Students,
                    Faculty, And Staff. That's <br> Why We've Developed A Cutting-Edge Location Tracking System To <br>
                    Enhance Campus Security And Give You Peace Of Mind.</p>
                <div>
                    <a href="#" class="btn btn-primary register_btn">Register</a>
                    <a href="#terms" class="btn btn-secondary contact_btn">Contact Us</a>
                </div>
            </div>
        </div>  
    </div>
</section>  


    <!-- Section 2 -->

    <section>
    <div class="container">
       
        <div class="row align-items-center mb-5">
            <!-- Text Column -->
            <div class="col-md-6">
                <h1 id="stay-aware">SECURE CAMPUS, EMPOWERED COMMUNITY</h1>
                <h2>Stay Aware, Stay Secure</h2>
                <p>Our Location Tracker Allows You to Monitor Your Position Within the University Grounds, Ensuring You
                    Can Quickly Identify Your Location and Access Help If Needed. With Real-Time Updates and Intuitive
                    Mapping, You'll Always Know Where You Are and How to Reach the Nearest Emergency Resources.</p>
            </div>
            <!-- Image Column -->
            <div class="col-md-6">
                <img src="{{ asset('css/img/city.png') }}" alt="City drawing" class="img-fluid w-100">
            </div>
        </div>  
        <div class="row align-items-center">
            <!-- Image Column -->
            <div class="col-md-6">
                <img src="{{ asset('css/img/map.png') }}" alt="Map drawing" class="img-fluid">
            </div>
            <!-- Text Column -->
            <div class="col-md-6">
                <h1>SAFETY WITH PRIVACY-ORIENTED TRACKING</h1>
                <p>By Leveraging the Power of Openstreetmap-Based Location Tracking, We're Putting the Tools for a
                    Secure Campus Directly in   Your Hands While Prioritizing Your Privacy. Whether You're Walking to
                    Class, Studying Late, or Attending an Event, Our System Keeps You Connected and Empowered to Take
                    Control of Your Safety Without Compromising Your Personal Information.</p>
            </div>
        </div>
        </div>
        </section>

    <!-- Section 3 -->

    <section>
    <div class="container">
        <!-- Row 1: Image on the left, text on the right -->
        <div class="row align-items-center mb-5">
        <!-- Text Column -->
             <div class="col-md-6">
                <h1>UNLOCK THE FULL POTENTIAL <br>OF CAMPUS LIFE</h1>
                <p>Experience the Freedom to Explore Your University to the Fullest,<br> Knowing That Your Location Is Being
                    Monitored for Your Protection<br> Using Open-Source Technology. Engage with the Vibrant Campus<br>
                    Community, Participate in Extracurricular Activities, and Make the<br> Most of Your University
                    Experience - All While Enjoying the Security<br> of Our Advanced Location Tracking System.</p>
            </div>
        
      
            <!-- Image Column -->
            <div class="col-md-6">
                <img src="{{ asset('css/img/college_students.png') }}" alt="students drawing" class="img-fluid">
            </div>
            
        </div>
 <!-- Row 2: Image on the right, text on the left -->
 <div class="row align-items-center">
            <!-- Text Column -->
            <div class="col-md-6">
                <h1>JOIN THE MOVEMENT FOR A SAFER, <br>PRIVACY-FOCUSED CAMPUS</h1>
                <p>Discover How Quezon City University's Openstreetmap-Powered Location<br> Tracker Can Transform the Way
                    You Experience Campus Life. Sign Up Today<br> and Take the First Step Towards a More Secure, Connected,
                    and<br> Empowered University Community.</p>
            </div>
            <!-- Image Column -->
            <div class="col-md-6">
                <img src="{{ asset('css/img/security.png') }}" alt="security image" class="img-fluid">
            </div>
        </div>
        </div>
</section>
</body>

</body>

<!-- Footer -->
@include('partials.footer')

</html>