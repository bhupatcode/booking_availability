@extends('layouts.app')

@section('content')
<div class="container py-4">
        @include('components.back-button') <!-- ✅ Back Button -->
<form method="GET" action="{{ route('booking.show') }}" class="row g-3 mb-4">
    <div class="col-md-3">
        <label>Booking Type</label>
        <select name="booking_type" class="form-select">
            <option value="">All</option>
            <option value="full" {{ request('booking_type') == 'full' ? 'selected' : '' }}>Full Day</option>
            <option value="half" {{ request('booking_type') == 'half' ? 'selected' : '' }}>Half Day</option>
            <option value="custom" {{ request('booking_type') == 'custom' ? 'selected' : '' }}>Custom</option>
        </select>
    </div>

    <div class="col-md-3">
        <label>Start Date</label>
        <input type="date" name="start_date" value="{{ request('start_date') }}" class="form-control">
    </div>

    <div class="col-md-3">
        <label>End Date</label>
        <input type="date" name="end_date" value="{{ request('end_date') }}" class="form-control">
    </div>

    <div class="col-md-3 d-flex align-items-end">
        <button class="btn btn-primary me-2">Filter</button>
        <a href="{{ route('booking.index') }}" class="btn btn-secondary">Reset</a>
    </div>
</form>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold"><i class="bi bi-calendar-check-fill text-primary me-2"></i>My Bookings</h3>
        <a href="{{ route('booking.store') }}" class="btn btn-success btn-sm">
            <i class="bi bi-plus-circle me-1"></i> New Booking
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($bookings->isEmpty())
        <div class="alert alert-info">
            <i class="bi bi-info-circle-fill me-2"></i> You have no bookings yet.
        </div>
    @else
        <div class="table-responsive">

            <table class="table table-striped table-hover align-middle shadow-sm rounded">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Half Day</th>
                        <th>Start</th>
                        <th>End</th>
                        <th>Booked At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bookings as $index => $booking)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <span class="fw-semibold">{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}</span>
                            </td>
                            <td>
                                @if ($booking->booking_type === 'full')
                                    <span class="badge bg-primary">Full Day</span>
                                @elseif ($booking->booking_type === 'half')
                                    <span class="badge bg-warning text-dark">Half Day</span>
                                @else
                                    <span class="badge bg-info text-dark">Custom</span>
                                @endif
                            </td>
                            <td>
                                @if ($booking->booking_type === 'half')
                                    <span class="text-capitalize">{{ str_replace('_', ' ', $booking->half_day_type) }}</span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>
                                {{ $booking->start_time ?? '—' }}
                            </td>
                            <td>
                                {{ $booking->end_time ?? '—' }}
                            </td>
                            <td>
                                <small class="text-muted">
                                    {{ $booking->created_at->format('d M Y, h:i A') }}
                                </small>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
