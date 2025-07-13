<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::where('user_id', auth()->id())->latest()->get();
        return view('booking.index', compact('bookings'));
    }
    public function show(Request $request)
    {
        $query = Booking::where('user_id', auth()->id());

        if ($request->booking_type) {
            $query->where('booking_type', $request->booking_type);
        }

        if ($request->start_date) {
            $query->whereDate('booking_date', '>=', $request->start_date);
        }

        if ($request->end_date) {
            $query->whereDate('booking_date', '<=', $request->end_date);
        }

        $bookings = $query->latest()->get();

        return view('booking.show', compact('bookings'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'booking_date'   => 'required|date',
            'booking_type'   => ['required', Rule::in(['full', 'half', 'custom'])],
            'half_day_type'  => 'required_if:booking_type,half|nullable|string',
            'start_time'     => 'required_if:booking_type,custom|nullable|date_format:H:i',
            'end_time'       => 'required_if:booking_type,custom|nullable|date_format:H:i|after:start_time',
        ]);

        $userId       = Auth::id();
        $bookingDate  = $request->booking_date;
        $bookingType  = $request->booking_type;
        $startTime    = $request->start_time;
        $endTime      = $request->end_time;

        $data = [
            'user_id'       => $userId,
            'booking_date'  => $bookingDate,
            'booking_type'  => $bookingType,
        ];

        // Full day already booked?
        $fullDayExists = Booking::where('booking_date', $bookingDate)
            ->where('booking_type', 'full')
            ->exists();

        if ($fullDayExists) {
            return back()->withErrors(['error' => 'This date is fully booked already.']);
        }

        // Prevent full-day booking if any slot exists
        if ($bookingType === 'full') {
            $anyBooking = Booking::where('booking_date', $bookingDate)->exists();
            if ($anyBooking) {
                return back()->withErrors(['error' => 'Cannot book full day. Time slots already booked.']);
            }
        }

        // Half Day Booking
        if ($bookingType === 'half') {
            $data['half_day_type'] = $request->half_day_type;

            if ($request->half_day_type === 'first_half') {
                $data['start_time'] = '08:00:00';
                $data['end_time']   = '13:00:00';
            } elseif ($request->half_day_type === 'second_half') {
                $data['start_time'] = '13:00:00';
                $data['end_time']   = '18:00:00';
            }
        }

        // Custom Time Booking
        if ($bookingType === 'custom') {
            $data['start_time'] = $startTime;
            $data['end_time']   = $endTime;
        }

        // Check time overlap (for half and custom)
        if (in_array($bookingType, ['half', 'custom'])) {
            $checkStart = $data['start_time'];
            $checkEnd   = $data['end_time'];

            $conflictExists = Booking::where('booking_date', $bookingDate)
                ->whereNotNull('start_time')
                ->whereNotNull('end_time')
                ->where(function ($query) use ($checkStart, $checkEnd) {
                    $query->where('start_time', '<', $checkEnd)
                        ->where('end_time', '>', $checkStart);
                })
                ->exists();

            if ($conflictExists) {
                return back()->withErrors(['error' => 'This time slot is already booked.']);
            }
        }

        Booking::create($data);

        return redirect()->route('booking.index')->with('success', 'Booking confirmed!');
    }

    public function checkAvailabilityLogic(Request $request)
    {
        $date = $request->booking_date;
        $type = $request->booking_type;

        $existingBookings = Booking::where('booking_date', $date)->get();

        if ($type === 'full') {
            return $existingBookings->isEmpty();
        }

        if ($type === 'half') {
            if ($existingBookings->where('booking_type', 'full')->count()) return false;
            return !$existingBookings->where('booking_type', 'half')
                ->where('half_day_type', $request->half_day_type)->count();
        }

        if ($type === 'custom') {
            $start = $request->start_time;
            $end   = $request->end_time;

            foreach ($existingBookings as $booking) {
                if ($booking->booking_type === 'full') return false;

                if ($booking->booking_type === 'half') {
                    if ($request->half_day_type === 'first_half') {
                        $data['start_time'] = '08:00:00';
                        $data['end_time']   = '14:00:00'; // updated
                    } elseif ($request->half_day_type === 'second_half') {
                        $data['start_time'] = '14:00:00'; // updated
                        $data['end_time']   = '20:00:00'; // updated
                    }
                }

                if ($booking->booking_type === 'custom') {
                    if ($start < $booking->end_time && $end > $booking->start_time) {
                        return false;
                    }
                }
            }
        }

        return true;
    }
}
