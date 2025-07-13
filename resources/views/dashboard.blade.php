@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white fw-semibold">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </div>

                <div class="card-body">
                    @include('components.back-button') <!-- ✅ Back Button -->
                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('status') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <h5 class="mb-3">Welcome, <strong>{{ Auth::user()->name }}</strong> 👋</h5>
                    <p class="text-muted">
                        You're logged in! This is your dashboard. Use the navigation bar to access your profile or make a booking.
                    </p>

                    <hr>

                    <div class="row text-center">
                        <div class="col-md-4 mb-3">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <i class="bi bi-calendar-check display-5 text-success mb-2"></i>
                                    <h6 class="fw-bold">Your Bookings</h6>
                                    <p class="text-muted small">Check your upcoming or past bookings.</p>
                                    <a href="{{ route('booking.show') }}" class="btn btn-sm btn-outline-success">View Bookings</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <i class="bi bi-calendar-plus display-5 text-primary mb-2"></i>
                                    <h6 class="fw-bold">New Booking</h6>
                                    <p class="text-muted small">Book a new slot by date and time.</p>
                                    <a href="{{ route('booking.index') }}" class="btn btn-sm btn-outline-primary">Book Now</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <i class="bi bi-person-circle display-5 text-warning mb-2"></i>
                                    <h6 class="fw-bold">Profile</h6>
                                    <p class="text-muted small">Update your profile information.</p>
                                    <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-outline-warning">Edit Profile</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
