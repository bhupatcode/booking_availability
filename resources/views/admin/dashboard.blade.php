@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Welcome, Admin!</h2>
        <a href="{{ route('admin.logout') }}" class="btn btn-danger">Logout</a>
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card shadow-sm border-start border-success border-4">
                <div class="card-body">
                    <h5 class="card-title text-success"><i class="bi bi-people-fill me-2"></i>Total Users</h5>
                    <h3 class="fw-bold">{{ $totalUsers }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm border-start border-primary border-4">
                <div class="card-body">
                    <h5 class="card-title text-primary"><i class="bi bi-calendar-check me-2"></i>Total Bookings</h5>
                    <h3 class="fw-bold">{{ $totalBookings }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white fw-semibold">
            <i class="bi bi-table me-2"></i> Users & Their Bookings
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="userBookingTable" class="table table-striped table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>User Name</th>
                            <th>Email</th>
                            <th>Total Bookings</th>
                            <th>Booking Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($userBookings as $index => $user)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->bookings->count() }}</td>
                                <td>
                                    <ul class="list-unstyled small">
                                        @foreach($user->bookings as $booking)
                                            <li>
                                                {{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }} –
                                                {{ ucfirst($booking->booking_type) }}
                                                @if($booking->booking_type == 'half')
                                                    ({{ ucfirst(str_replace('_', ' ', $booking->half_day_type)) }})
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- DataTables JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" />
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function () {
        $('#userBookingTable').DataTable({
            responsive: true,
            pageLength: 10
        });
    });
</script>
@endsection
