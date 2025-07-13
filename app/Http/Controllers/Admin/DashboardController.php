<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
   public function index()
{
    $totalUsers = \App\Models\User::count();
    $totalBookings = \App\Models\Booking::count();

    $userBookings = \App\Models\User::with('bookings')->get();

    return view('admin.dashboard', compact('totalUsers', 'totalBookings', 'userBookings'));
}

}
