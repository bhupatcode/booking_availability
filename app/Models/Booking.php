<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'booking_date',
        'booking_type',
        'half_day_type',
        'start_time',
        'end_time',
    ];
}
