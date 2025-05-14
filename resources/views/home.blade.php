<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visitrack - Home</title>
<<<<<<< HEAD
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
        const modal = new bootstrap.Modal(modalElement);
        
        // Show modal on page load
        modal.show();

        // Handle checkbox
        const privacyCheck = document.getElementById('privacyCheck');
        const acceptButton = document.getElementById('acceptPrivacy');

        privacyCheck.addEventListener('change', function() {
            acceptButton.disabled = !this.checked;
        });

        // Handle accept button - improved event handling
        acceptButton.addEventListener('click', function() {
            console.log('Accept button clicked');
            modal.hide();
            
            // Force removal of modal elements from DOM
            setTimeout(function() {
                // Remove the modal backdrop
                const backdrop = document.querySelector('.modal-backdrop');
                if (backdrop) {
                    backdrop.parentNode.removeChild(backdrop);
                }
                
                // Remove modal-open class and inline styles from body
                document.body.classList.remove('modal-open');
                document.body.style.overflow = '';
                document.body.style.paddingRight = '';
                
                // Make the modal element hidden
                modalElement.style.display = 'none';
                modalElement.classList.remove('show');
                modalElement.setAttribute('aria-hidden', 'true');
                modalElement.removeAttribute('aria-modal');
            }, 100);
        });
        
        // Ensure button is properly bound by adding direct onclick attribute
        acceptButton.onclick = function() {
            console.log('Accept button clicked via onclick');
            modal.hide();
            
            // Same cleanup as above
            setTimeout(function() {
                const backdrop = document.querySelector('.modal-backdrop');
                if (backdrop) {
                    backdrop.parentNode.removeChild(backdrop);
                }
                document.body.classList.remove('modal-open');
                document.body.style.overflow = '';
                document.body.style.paddingRight = '';
                modalElement.style.display = 'none';
                modalElement.classList.remove('show');
            }, 100);
            
            return false;
        };
    });
</script>

<!-- Footer -->
@include('partials.footer')

=======
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #7749F8;
            --secondary-color: #4a89dc;
            --accent-color: #ff6bcb;
            --bg-gradient: linear-gradient(120deg, #7749F8 0%, #4a89dc 50%, #ff6bcb 100%);
            --text-color: #222;
            --light-color: #fff;
        }
        body {
            font-family: 'Poppins', sans-serif;
            background: var(--bg-gradient);
            background-size: 200% 200%;
            animation: bgMove 12s ease-in-out infinite;
            color: var(--text-color);
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
        }
        @keyframes bgMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        /* Floating shapes */
        .floating-shape {
            position: absolute;
            border-radius: 50%;
            opacity: 0.18;
            z-index: 0;
            animation: floatShape 8s ease-in-out infinite alternate;
        }
        .shape1 { width: 180px; height: 180px; top: 8%; left: 5%; background: #ff6bcb; animation-delay: 0s; }
        .shape2 { width: 120px; height: 120px; top: 60%; left: 80%; background: #4a89dc; animation-delay: 2s; }
        .shape3 { width: 90px; height: 90px; top: 80%; left: 10%; background: #7749F8; animation-delay: 4s; }
        @keyframes floatShape {
            0% { transform: translateY(0) scale(1) rotate(0deg); }
            50% { transform: translateY(-30px) scale(1.1) rotate(10deg); }
            100% { transform: translateY(0) scale(1) rotate(-10deg); }
        }
        .hero-section {
            width: 100%;
            min-height: 70vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 4rem 0 2rem 0;
            position: relative;
            z-index: 1;
        }
        .hero-row {
            width: 100%;
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 2rem;
        }
        .hero-img-col {
            flex: 1 1 350px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .hero-img {
            max-width: 370px;
            width: 100%;
            border-radius: 24px;
            box-shadow: 0 8px 32px rgba(119, 73, 248, 0.13);
            animation: heroFloat 3.5s ease-in-out infinite alternate;
        }
        @keyframes heroFloat {
            0% { transform: translateY(0) scale(1); }
            100% { transform: translateY(-18px) scale(1.04); }
        }
        .hero-content-col {
            flex: 2 1 500px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            justify-content: center;
        }
        .hero-title {
            font-size: 2.8rem;
            font-weight: 900;
            color: #fff;
            margin-bottom: 1.2rem;
            letter-spacing: 1px;
            text-shadow: 0 2px 12px rgba(119, 73, 248, 0.25), 0 1px 0 #333;
        }
        .hero-desc {
            font-size: 1.25rem;
            color: #f3f3f3;
            margin-bottom: 2.5rem;
            font-weight: 500;
            text-shadow: 0 1px 8px rgba(119, 73, 248, 0.18), 0 1px 0 #222;
        }
        .hero-btns {
            display: flex;
            gap: 1.2rem;
        }
        .hero-btns .btn {
            font-size: 1.25rem;
            font-weight: 700;
            border-radius: 2rem;
            padding: 0.8rem 2.7rem;
            transition: all 0.3s;
            box-shadow: 0 5px 18px rgba(119, 73, 248, 0.13);
            position: relative;
            overflow: hidden;
        }
        .btn-register {
            background: var(--accent-color);
            color: var(--light-color);
            border: 2px solid var(--accent-color);
            box-shadow: 0 0 18px 2px #ff6bcb44;
        }
        .btn-register:hover {
            background: var(--primary-color);
            color: #fff;
            border: 2px solid var(--primary-color);
            transform: scale(1.06) translateY(-2px);
            box-shadow: 0 0 24px 4px #7749f866;
        }
        .btn-contact {
            background: var(--primary-color);
            color: #fff;
            border: 2px solid var(--primary-color);
            box-shadow: 0 0 18px 2px #7749f844;
        }
        .btn-contact:hover {
            background: var(--secondary-color);
            border: 2px solid var(--secondary-color);
            transform: scale(1.06) translateY(-2px);
            box-shadow: 0 0 24px 4px #4a89dc66;
        }
        .btn:active::after {
            content: '';
            position: absolute;
            left: 50%; top: 50%;
            width: 200%; height: 200%;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            transform: translate(-50%, -50%) scale(0);
            animation: ripple 0.5s linear;
            z-index: 2;
        }
        @keyframes ripple {
            to { transform: translate(-50%, -50%) scale(1); opacity: 0; }
        }
        .section {
            padding: 4rem 0 2rem 0;
            position: relative;
            z-index: 1;
        }
        .section-title {
            color: var(--primary-color);
            font-weight: 800;
            font-size: 2.1rem;
            margin-bottom: 1.2rem;
            letter-spacing: 0.5px;
        }
        .section-desc {
            color: #222;
            font-size: 1.13rem;
            margin-bottom: 2rem;
            font-weight: 500;
        }
        .section-img {
            max-width: 320px;
            border-radius: 18px;
            box-shadow: 0 4px 16px rgba(119, 73, 248, 0.10);
            animation: sectionFloat 3s ease-in-out infinite alternate;
        }
        @keyframes sectionFloat {
            0% { transform: translateY(0) scale(1); }
            100% { transform: translateY(-12px) scale(1.03); }
        }
        .staggered {
            opacity: 0;
            animation: staggeredReveal 1.2s forwards;
        }
        .staggered-1 { animation-delay: 0.2s; }
        .staggered-2 { animation-delay: 0.5s; }
        .staggered-3 { animation-delay: 0.8s; }
        .staggered-4 { animation-delay: 1.1s; }
        @keyframes staggeredReveal {
            from { opacity: 0; transform: translateY(40px) scale(0.95); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }
        @media (max-width: 992px) {
            .hero-row { flex-direction: column; text-align: center; }
            .hero-img-col { margin-bottom: 2rem; }
            .hero-content-col { align-items: center; }
            .hero-title, .hero-desc { text-align: center; }
            .hero-btns { justify-content: center; }
        }
        @media (max-width: 576px) {
            .hero-title { font-size: 2rem; }
            .hero-section { padding: 2rem 0 1rem 0; }
        }
    </style>
</head>
<body>
    <div class="floating-shape shape1"></div>
    <div class="floating-shape shape2"></div>
    <div class="floating-shape shape3"></div>
    @include('partials.nav', ['hideLinks' => false])
    <section class="hero-section">
        <div class="hero-row">
            <div class="hero-img-col">
                <img src="{{ asset('css/img/building.png') }}" alt="Lab building" class="hero-img">
                </div>
            <div class="hero-content-col">
                <div class="hero-title">A REAL TIME LOCATION TRACKER FOR QCU VISITORS</div>
                <div class="hero-desc">At Quezon City University, we believe in creating a safe and connected environment for our students, faculty, and staff. That's why we've developed a cutting-edge location tracking system to enhance campus security and give you peace of mind.</div>
                <div class="hero-btns">
                    <a href="/register" class="btn btn-register">Register</a>
                    <a href="#contact" class="btn btn-contact">Contact Us</a>
                </div>
            </div>
        </div>
    </section>
    <section class="section">
    <div class="container">
            <div class="row align-items-center mb-5">
                <div class="col-md-6">
                    <div class="section-title">SECURE CAMPUS, EMPOWERED COMMUNITY</div>
                    <div class="section-desc">Stay aware, stay secure. Our location tracker allows you to monitor your position within the university grounds, ensuring you can quickly identify your location and access help if needed. With real-time updates and intuitive mapping, you'll always know where you are and how to reach the nearest emergency resources.</div>
            </div>
                <div class="col-md-6 text-center">
                    <img src="{{ asset('css/img/city.png') }}" alt="City drawing" class="section-img">
                </div>
            </div>
            <div class="row align-items-center mb-5 flex-md-row-reverse">
            <div class="col-md-6">
                    <div class="section-title">SAFETY WITH PRIVACY-ORIENTED TRACKING</div>
                    <div class="section-desc">By leveraging the power of OpenStreetMap-based location tracking, we're putting the tools for a secure campus directly in your hands while prioritizing your privacy. Whether you're walking to class, studying late, or attending an event, our system keeps you connected and empowered to take control of your safety without compromising your personal information.</div>
            </div>
                <div class="col-md-6 text-center">
                    <img src="{{ asset('css/img/map.png') }}" alt="Map drawing" class="section-img">
        </div>  
            </div>
            <div class="row align-items-center mb-5">
            <div class="col-md-6">
                    <div class="section-title">UNLOCK THE FULL POTENTIAL OF CAMPUS LIFE</div>
                    <div class="section-desc">Experience the freedom to explore your university to the fullest, knowing that your location is being monitored for your protection using open-source technology. Engage with the vibrant campus community, participate in extracurricular activities, and make the most of your university experience—all while enjoying the security of our advanced location tracking system.</div>
            </div>
                <div class="col-md-6 text-center">
                    <img src="{{ asset('css/img/college_students.png') }}" alt="students drawing" class="section-img">
        </div>
            </div>
            <div class="row align-items-center mb-5 flex-md-row-reverse">
            <div class="col-md-6">
                    <div class="section-title">JOIN THE MOVEMENT FOR A SAFER, PRIVACY-FOCUSED CAMPUS</div>
                    <div class="section-desc">Discover how Quezon City University's OpenStreetMap-powered location tracker can transform the way you experience campus life. Sign up today and take the first step towards a more secure, connected, and empowered university community.</div>
            </div>
                <div class="col-md-6 text-center">
                    <img src="{{ asset('css/img/security.png') }}" alt="security image" class="section-img">
            </div>
        </div>
        </div>
</section>
<script>
        // Staggered reveal for sections
    document.addEventListener('DOMContentLoaded', function() {
            const staggeredEls = document.querySelectorAll('.staggered');
            staggeredEls.forEach(el => {
                el.style.opacity = 1;
        });
    });
</script>
</body>
>>>>>>> 2e02c0059258e474ba4d81b53ee3ad30139fb789
</html>