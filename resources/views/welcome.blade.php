<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel Booking System') }}</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>

    <!-- Header/Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">BookingSystem</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav align-items-center">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('dashboard') }}"><i class="bi bi-house-door-fill me-1"></i> Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('booking.index') }}"><i class="bi bi-calendar-plus me-1"></i> Booking</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('profile.edit') }}"><i class="bi bi-person-circle me-1"></i> Profile</a>
                        </li>
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-outline-light btn-sm ms-3">Logout</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a href="{{ route('login') }}" class="btn btn-outline-light me-2">Login</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a href="{{ route('register') }}" class="btn btn-light">Register</a>
                            </li>
                        @endif
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Carousel -->
    <div id="mainCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="3000">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQHVWQrC7jWBx0GygPCJwmTtL7zUpSBSQAeyw&s" class="d-block w-100" style="max-height: 500px; object-fit: cover;" alt="Booking Slide 1">
                <div class="carousel-caption d-none d-md-block">
                    <h3>Easy Online Booking</h3>
                    <p>Book your slot anytime, anywhere.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT7QhZWmwhZllwJn1dZ6yU-D2thzsfgw6esZhxF86NC2V-MYwvvzyhHllQHD8xx56O2Vl8&usqp=CAU" class="d-block w-100" style="max-height: 500px; object-fit: cover;" alt="Booking Slide 2">
                <div class="carousel-caption d-none d-md-block">
                    <h3>Flexible Time Options</h3>
                    <p>Choose full day, half day, or custom time slots.</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </button>
    </div>

    <!-- Welcome Section -->
    <section class="py-5 bg-light text-center">
        <div class="container">
            <h2 class="fw-bold mb-3">Welcome to the Booking Management System</h2>
            <p class="text-muted">Manage your schedule with ease. Track your bookings, make new reservations, and stay organized with our user-friendly system.</p>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-light text-center py-3">
        <div class="container">
            <small>&copy; {{ date('Y') }} BookingSystem. All rights reserved.</small>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
