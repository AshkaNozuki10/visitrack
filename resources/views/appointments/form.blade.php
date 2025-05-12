@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<link rel="stylesheet" href="{{ asset('css/appointment.css') }}">
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 px-0 sidebar">
            <div class="p-4">
                <div class="d-flex align-items-center mb-4">
                    <div class="bg-white rounded-circle p-2 me-2">
                        <i class="fas fa-user text-warning"></i>
                    </div>
                    <h4 class="text-white mb-0">VISITOR'S PORTAL</h4>
                </div>

                <nav class="mt-4">
                    <a href="#" class="sidebar-link mb-2">
                        PROFILE
                    </a>
                    <a href="#" class="sidebar-link mb-2">
                        Account Settings
                    </a>
                    <a href="#" class="sidebar-link mb-2">
                        Campus Map
                    </a>

                    <div class="mb-2">
                        <a href="{{ route('appointment.form') }}"><div class="sidebar-link">Appointments</div></a>
                        <div class="sub-menu">
                            <a href="{{ route('appointments.approved') }}" class="sidebar-link mb-1">Approved</a>
                            <a href="{{ route('appointments.rejected') }}" class="sidebar-link mb-1">Rejected</a>
                            <a href="{{ route('appointments.pending') }}" class="sidebar-link">Pending</a>
                        </div>
                    </div>

                    <a href="{{ route('logout') }}" 
                       class="sidebar-link mt-5"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Log Out
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9 col-lg-10 p-4">
            <div class="card shadow">
                <div class="card-body">
                    <h2 class="card-title mb-4">VISITOR'S APPOINTMENT FORM</h2>
                    @if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

                    <!-- Map Container -->
                    <div class="position-relative mb-4">
                    </div>
                    <form action="{{ route('appointment.store') }}" method="POST">
                        @csrf
                        
                        <!-- Transaction Type -->
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label for="appointment_type" class="form-label">Appointment or Walk-In*</label>
                                <select class="form-control" id="appointment_type" name="appointment_type" required>
                                    <option value="">-- Select Type --</option>
                                    <option value="appointment">Appointment</option>
                                    <option value="walk_in">Walk-In</option>
                                </select>
                                @error('appointment_type')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Entity -->
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label for="entity" class="form-label">Transaction With: (Entity)*</label>
                                <input type="text" 
                                       class="form-control" 
                                       id="entity" 
                                       placeholder="Enter entity name"
                                       name="entity"
                                       value="{{ old('entity') }}"
                                       required>
                                @error('entity')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Purpose of Visit -->
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label for="purpose" class="form-label">Purpose of Visit*</label>
                                <textarea class="form-control" 
                                          id="purpose" 
                                          placeholder="Enter purpose of visit"
                                          name="purpose"
                                          rows="3"
                                          required>{{ old('purpose') }}</textarea>
                                @error('purpose')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Department of Concern -->
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label for="department" class="form-label">Department of Concern*</label>
                                <select class="form-control" id="department" name="department" required>
                                    <option value="">-- Select Department --</option>
                                    <option value="Computer ">CCS Department</option>
                                    <option value="Education">Education Department</option>
                                    <option value="Accounting ">Accounting Department</option>
                                    <option value="Entrepreneurship">Entrepreneurship Department</option>
                                    <option value="Engineering">Engineering Department</option>
                                </select>
                                @error('department')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Building Selection -->
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label for="building" class="form-label">Select Building*</label>
                                <select class="form-control" id="building" name="building" required>
                                    <option value="">-- Select Building --</option>
                                    <option value="Gymnasium">Gymnasium</option>
                                    <option value="Administration Building">Administration Building</option>
                                    <option value="UrbanFarm">QCU Urban Farm Zone</option>
                                    <option value="KoreanPhilBldg">Korphil Building</option>
                                    <option value="ChedBldg">CHED Building</option>
                                    <option value="EntrepZone">QCU Entrep Zone</option>
                                    <option value="BelmonteBuilding">Belmonte Building</option>
                                    <option value="NewAcademicBuilding">Academic Building</option>
                                    <option value="QuarantineZone">Quarantine Zone</option>
                                    <option value="IK Building">Auditorium Building</option>
                                </select>
                                @error('building')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Date/Time Selection -->
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <label for="appointment_date" class="form-label">Appointment Date*</label>
                                <input type="date" 
                                       class="form-control" 
                                       id="appointment_date" 
                                       placeholder="Enter your preferred date"
                                       name="appointment_date"
                                       value="{{ old('appointment_date') }}"
                                       required>
                                @error('appointment_date')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="appointment_time" class="form-label">Appointment Time*</label>
                                <input type="time" 
                                       class="form-control" 
                                       id="appointment_time" 
                                       placeholder="Enter your preferred time"
                                       name="appointment_time"
                                       value="{{ old('appointment_time') }}"
                                       required>
                                @error('appointment_time')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <button type="submit" class="submit-btn">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
