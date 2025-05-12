@extends('layouts.app')

@section('content')
<div class="bg-custom min-vh-100 py-4 animate__animated animate__fadeIn">
    <div class="container-fluid">
        <!-- Modern Admin Navbar -->
        @section('custom_admin_nav')
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm animate__animated animate__fadeInDown mb-4" style="border-radius: 0 0 1.5rem 1.5rem;">
            <div class="container-fluid">
                <a class="navbar-brand d-flex align-items-center" href="{{ route('admin.dashboard') }}">
                    <img src="{{ asset('css/img/building.png') }}" alt="Logo" width="40" height="40" class="d-inline-block align-text-top me-2 animate__animated animate__bounceIn">
                    <span class="fw-bold fs-3">Visitrack Admin</span>
                </a>
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item me-3">
                        <a class="nav-link position-relative" href="#">
                            <i class="fas fa-bell fa-lg"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">3</span>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle fa-lg me-2"></i> {{ Auth::user()->information->first_name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end animate__animated animate__fadeIn" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="{{ route('admin.settings') }}"><i class="fas fa-cog me-2"></i>Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt me-2"></i>Log out</a></li>
                        </ul>
                    </li>
                </ul>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </nav>
        @endsection
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar p-0 animate__animated animate__fadeInLeft">
                <div class="bg-white rounded-4 shadow p-4 mb-4">
                    <div class="admin-profile text-center mb-4">
                        <div class="profile-avatar mb-2">
                            <i class="fas fa-user-shield fa-3x text-primary"></i>
                        </div>
                        <h4 class="fw-bold text-primary">ADMIN PANEL</h4>
                    </div>
                    <nav>
                        <ul class="nav flex-column sidebar-nav">
                            <li class="nav-item mb-2 {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                                <a href="{{ route('admin.dashboard') }}" class="nav-link text-dark fw-semibold"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a>
                            </li>
                            <li class="nav-item mb-2 {{ request()->is('admin/visitor-tracking') ? 'active' : '' }}">
                                <a href="{{ route('admin.visitor-tracking') }}" class="nav-link text-dark fw-semibold"><i class="fas fa-map-marker-alt me-2"></i> Visitor Tracking</a>
                            </li>
                            <li class="nav-item mb-2 {{ request()->is('admin/pending-appointments') ? 'active' : '' }}">
                                <a href="{{ route('admin.pending-appointments') }}" id="pending-tab" class="nav-link text-dark fw-semibold"><i class="fas fa-clock me-2"></i> Pending Appointments <span class="badge badge-danger" id="pending-count">0</span></a>
                            </li>
                            <li class="nav-item mb-2 {{ request()->is('admin/approved-appointments') ? 'active' : '' }}">
                                <a href="{{ route('admin.approved-appointments') }}" class="nav-link text-dark fw-semibold"><i class="fas fa-check-circle me-2"></i> Approved</a>
                            </li>
                            <li class="nav-item mb-2 {{ request()->is('admin/rejected-appointments') ? 'active' : '' }}">
                                <a href="{{ route('admin.rejected-appointments') }}" class="nav-link text-dark fw-semibold"><i class="fas fa-times-circle me-2"></i> Rejected</a>
                            </li>
                            <li class="nav-item mb-2 {{ request()->is('admin/settings') ? 'active' : '' }}">
                                <a href="{{ route('admin.settings') }}" class="nav-link text-dark fw-semibold"><i class="fas fa-cog me-2"></i> Settings</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- Main Content Area -->
            <div class="col-md-10 main-content animate__animated animate__fadeInRight">
                <!-- Dashboard Overview -->
                <div class="row g-4 mb-4 mt-5">
                    <div class="col-md-3">
                        <div class="card shadow-lg border-0 animate__animated animate__zoomIn" style="background: #2563eb; color: white;">
                            <div class="card-body text-center">
                                <i class="fas fa-user-graduate fa-2x mb-2"></i>
                                <h5 class="card-title">Active Visitors</h5>
                                <h2 class="fw-bold" id="active-count">{{ $activeStudentsCount ?? 0 }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card shadow-lg border-0 animate__animated animate__zoomIn" style="background: #fbbf24; color: #1a202c;">
                            <div class="card-body text-center">
                                <i class="fas fa-clock fa-2x mb-2"></i>
                                <h5 class="card-title">Pending Appointments</h5>
                                <h2 class="fw-bold" id="pending-appointments-count">{{ $pendingAppointmentsCount ?? 0 }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card shadow-lg border-0 animate__animated animate__zoomIn" style="background: #22c55e; color: white;">
                            <div class="card-body text-center">
                                <i class="fas fa-check-circle fa-2x mb-2"></i>
                                <h5 class="card-title">Approved Appointments</h5>
                                <h2 class="fw-bold">{{ $approvedAppointmentsCount ?? 0 }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card shadow-lg border-0 animate__animated animate__zoomIn" style="background: #ef4444; color: white;">
                            <div class="card-body text-center">
                                <i class="fas fa-building fa-2x mb-2"></i>
                                <h5 class="card-title">Total Buildings</h5>
                                <h2 class="fw-bold">{{ $buildingsCount ?? 0 }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Recent Activity -->
                <div class="card shadow-lg border-0 mb-4 animate__animated animate__fadeInUp">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0">Recent Activity</h3>
                    </div>
                    <div class="card-body bg-light">
                        <ul class="activity-list list-unstyled mb-0">
                            @forelse($recentActivities ?? [] as $activity)
                            <li class="activity-item mb-3 d-flex align-items-center animate__animated animate__fadeInLeft">
                                <div class="activity-icon me-3 rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background: #e0e7ff;">
                                    <i class="fas {{ $activity->type == 'appointment' ? 'fa-calendar-check text-info' : 'fa-map-marker-alt text-primary' }} fa-lg"></i>
                                </div>
                                <div class="activity-info">
                                    <h5 class="mb-1">{{ $activity->title }}</h5>
                                    <p class="mb-0">{{ $activity->description }}</p>
                                    <small class="text-muted">{{ $activity->created_at->diffForHumans() }}</small>
                                </div>
                            </li>
                            @empty
                            <li class="no-activity text-center py-4">
                                <p class="text-secondary mb-0">No recent activity found.</p>
                            </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
                <!-- Quick Actions -->
                <div class="card shadow-lg border-0 animate__animated animate__fadeInUp">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0">Quick Actions</h3>
                    </div>
                    <div class="card-body bg-light">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <a href="{{ route('admin.visitor-tracking') }}" class="quick-action-item card p-3 text-center shadow-sm border-0 animate__animated animate__pulse" style="background: #2563eb; color: white; transition: transform 0.2s;">
                                    <div class="quick-action-icon mb-2">
                                        <i class="fas fa-map-marker-alt fa-2x"></i>
                                    </div>
                                    <h5>Visitor Tracking</h5>
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="#" class="quick-action-item card p-3 text-center shadow-sm border-0 animate__animated animate__pulse" style="background: #fbbf24; color: #1a202c; pointer-events: none; opacity: 0.7;">
                                    <div class="quick-action-icon mb-2">
                                        <i class="fas fa-clock fa-2x"></i>
                                    </div>
                                    <h5>Manage Appointments</h5>
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ route('admin.reports') }}" class="quick-action-item card p-3 text-center shadow-sm border-0 animate__animated animate__pulse" style="background: #22c55e; color: white;">
                                    <div class="quick-action-icon mb-2">
                                        <i class="fas fa-chart-bar fa-2x"></i>
                                    </div>
                                    <h5>View Reports</h5>
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ route('admin.settings') }}" class="quick-action-item card p-3 text-center shadow-sm border-0 animate__animated animate__pulse" style="background: #06b6d4; color: white;">
                                    <div class="quick-action-icon mb-2">
                                        <i class="fas fa-cog fa-2x"></i>
                                    </div>
                                    <h5>System Settings</h5>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Animate.css for animations -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
<link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
<style>
    body, .bg-custom { font-family: 'Lato', sans-serif !important; }
    .sidebar { background: linear-gradient(180deg, #e0e7ff 0%, #417ADA 100%); min-height: 100vh; }
    .sidebar .nav-link.active, .sidebar .nav-link:hover { background: #417ADA; color: white !important; border-radius: 8px; transition: background 0.2s; }
    .sidebar .nav-link { transition: background 0.2s, color 0.2s; }
    .card { border-radius: 1.5rem !important; }
    .quick-action-item:hover { transform: scale(1.05); box-shadow: 0 8px 24px rgba(65, 122, 218, 0.15); }
    .profile-avatar { animation: bounceIn 1s; }
    @keyframes bounceIn {
        0% { transform: scale(0.5); opacity: 0; }
        60% { transform: scale(1.2); opacity: 1; }
        100% { transform: scale(1); }
    }
</style>
@endsection

@section('navbar')
{{-- Override the default navbar to remove it on the admin dashboard --}}
<style>.navbar.navbar-expand-md { display: none !important; }</style>
@endsection
<style>
    .dropdown-menu {
        z-index: 1055 !important; /* higher than most Bootstrap elements */
    }
    .navbar {
        z-index: 1100 !important;
    }
    .main-content {
        margin-top: 2rem !important;
    }
</style>