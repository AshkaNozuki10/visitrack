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
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <!-- Nav Bar -->
    @include('partials.nav', ['hideLinks' => false])
</head>
<body class="bg-custom fs-5">
    <!-- Privacy Policy Modal -->
    <div class="modal fade" id="privacyModal" tabindex="-1" aria-labelledby="privacyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title mx-auto" id="privacyModalLabel">Privacy Policy & Terms of Service</h5>
                </div>
                <div class="modal-body">
                    <h4>Privacy Policy</h4>
                    <p>At Quezon City University, we take your privacy seriously. This privacy policy explains how we collect, use, and protect your personal information when you use our location tracking system.</p>
                    
                    <h5>Information We Collect:</h5>
                    <ul>
                        <li>Location data while you are on campus</li>
                        <li>Basic personal information for registration</li>
                        <li>Device information for security purposes</li>
                    </ul>

                    <h5>How We Use Your Information:</h5>
                    <ul>
                        <li>To provide real-time location tracking services</li>
                        <li>To enhance campus security</li>
                        <li>To improve our services</li>
                    </ul>

                    <h4>Terms of Service</h4>
                    <p>By using our location tracking system, you agree to:</p>
                    <ul>
                        <li>Provide accurate information during registration</li>
                        <li>Use the system responsibly and ethically</li>
                        <li>Not misuse or attempt to manipulate the tracking system</li>
                        <li>Comply with all university policies and regulations</li>
                    </ul>
                </div>
                <div class="modal-footer d-flex flex-column align-items-center">
                    <div class="form-check mb-3 text-center">
                        <input class="form-check-input" type="checkbox" id="privacyCheck">
                        <label class="form-check-label" for="privacyCheck">
                            I have read and agree to the Privacy Policy and Terms of Service
                        </label>
                    </div>
                    <button type="button" class="btn btn-primary" id="acceptPrivacy" disabled>Accept and Continue</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Section 1 -->
    <section class="full-height">
    <div class="container">
        <div class="row align-items-center">
            <!-- Image Column -->
            <div class="col-md-6 d-flex justify-content-center">
                <img src="{{ asset('css/img/building.png') }}" alt="Lab building" class="img-fluid w-100">
            </div>
            <!-- Text Column -->
            <div class="col-md-6" style="padding-bottom: 15rem;">
                <p class="h2">A REAL TIME LOCATION TRACKER FOR QCU VISITORS</p>
                <p>At Quezon City University, We Believe In Creating A Safe And Connected Environment For Our Students,
                    Faculty, And Staff. That's Why We've Developed A Cutting-Edge Location Tracking System To
                    Enhance Campus Security And Give You Peace Of Mind.</p>
                    <br>
                 <div class="d-flex align-items-center">
                 <a href="{{ route('show.register') }}" type="button" class="btn btn-primary animate__animated animate__pulse animate__infinite animate__slow" style="width: 200px; background-color:rgb(252, 252, 252); color: black; border: none; border-radius: 50px; padding: 12px; font-size: 1.1rem; font-weight: 600; letter-spacing: 1px; box-shadow: 0 10px 20px rgba(90, 54, 201, 0.3);">
                                    <i class="fas fa-sign-in-alt me-2"></i> Register
                                </a>

                                <a href="#terms" type="button" class="btn btn-primary animate__animated animate__pulse animate__infinite animate__slow ms-5" style="width: 200px; background-color: transparent; color: white; border: 1px solid white; border-radius: 50px; padding: 12px; font-size: 1.1rem; font-weight: 600; letter-spacing: 1px; box-shadow: 0 10px 20px rgba(90, 54, 201, 0.3);">
                                    <i class="fas fa-sign-in-alt me-2"></i> Contact Us
                                </a>
             
                    </div>  
                </div>
            </div>
        </div>  
    </div>
</section>  


    <!-- Section 2 -->

    <section>
    <div id="section2" class="container">
       
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
                <h1>UNLOCK THE FULL POTENTIAL OF CAMPUS LIFE</h1>
                <p>Experience the Freedom to Explore Your University to the Fullest, Knowing That Your Location Is Being
                    Monitored for Your Protection Using Open-Source Technology. Engage with the Vibrant Campus
                    Community, Participate in Extracurricular Activities, and Make the Most of Your University
                    Experience - All While Enjoying the Security of Our Advanced Location Tracking System.</p>
            </div>
        
      
            <!-- Image Column -->
            <div class="col-md-6">
                <img src="{{ asset('css/img/college_students.png') }}" alt="students drawing" class="img-fluid">
            </div>
            
        </div>
 <!-- Row 2: Image on the right, text on the left -->
 <div class="row align-items-center">
     <!-- Image Column -->
     <div class="col-md-6">
                <img src="{{ asset('css/img/security.png') }}" alt="security image" class="img-fluid">
            </div>
            <!-- Text Column -->
            <div class="col-md-6">
                <h1>JOIN THE MOVEMENT FOR A SAFER, PRIVACY-FOCUSED CAMPUS</h1>
                <p>Discover How Quezon City University's Openstreetmap-Powered Location Tracker Can Transform the Way
                    You Experience Campus Life. Sign Up Today and Take the First Step Towards a More Secure, Connected,
                    and Empowered University Community.</p>
            </div>
           
        </div>
        </div>
</section>
</body>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Create the modal instance
        const modalElement = document.getElementById('privacyModal');
        const modal = new bootstrap.Modal(modalElement, {
            backdrop: 'static',
            keyboard: false
        });
        
        // Show modal on page load
        modal.show();

        // Handle checkbox
        const privacyCheck = document.getElementById('privacyCheck');
        const acceptButton = document.getElementById('acceptPrivacy');

        privacyCheck.addEventListener('change', function() {
            acceptButton.disabled = !this.checked;
        });

        // Handle accept button
        acceptButton.addEventListener('click', function() {
            modal.hide();
            // Remove the modal backdrop
            const backdrop = document.querySelector('.modal-backdrop');
            if (backdrop) {
                backdrop.remove();
            }
            // Remove modal-open class from body
            document.body.classList.remove('modal-open');
            document.body.style.overflow = '';
            document.body.style.paddingRight = '';
        });
    });
</script>

<!-- Footer -->
@include('partials.footer')

</html>