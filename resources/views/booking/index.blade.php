@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Book a Slot</h4>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                                @include('components.back-button') <!-- ✅ Back Button -->

                        <form action="{{ route('booking.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="booking_date" class="form-label">Date:</label>
                                <input type="date" id="booking_date" name="booking_date" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="booking_type" class="form-label">Type:</label>
                                <select name="booking_type" id="booking_type" class="form-select" required>
                                    <option value="full">Full Day</option>
                                    <option value="half">Half Day</option>
                                    <option value="custom">Custom Time</option>
                                </select>
                            </div>

                            <div id="half_day_section" class="mb-3" style="display:none;">
                                <label for="half_day_type" class="form-label">Half Day Type:</label>
                                <select name="half_day_type" class="form-select">
                                    <option value="first_half">First Half (08:00 – 14:00)</option>
                                    <option value="second_half">Second Half (14:00 – 20:00)</option>
                                </select>
                            </div>

                            <div id="custom_time_section" class="row g-3 mb-3" style="display:none;">
                                <div class="col-md-6">
                                    <label for="start_time" class="form-label">Start Time:</label>
                                    <input type="time" name="start_time" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label for="end_time" class="form-label">End Time:</label>
                                    <input type="time" name="end_time" class="form-control">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-success w-100">Book</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('booking_type').addEventListener('change', function () {
            let type = this.value;
            document.getElementById('half_day_section').style.display = type === 'half' ? 'block' : 'none';
            document.getElementById('custom_time_section').style.display = type === 'custom' ? 'flex' : 'none';
        });
    </script>
@endsection
