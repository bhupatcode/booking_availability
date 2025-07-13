<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class BookingSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 1000) as $i) {
            $type = $faker->randomElement(['full', 'half', 'custom']);
            $halfType = null;
            $start = null;
            $end = null;

            if ($type === 'half') {
                $halfType = $faker->randomElement(['first_half', 'second_half']);
                $start = $halfType === 'first_half' ? '08:00:00' : '14:00:00';
                $end = $halfType === 'first_half' ? '14:00:00' : '18:00:00';
            } elseif ($type === 'full') {
                $start = '09:00:00';
                $end = '18:00:00';
            } elseif ($type === 'custom') {
                // Generate a custom time between 08:00 to 17:00 with at least 1 hour gap
                $start = $faker->time('H:i:s', '17:00:00');
                $startCarbon = \Carbon\Carbon::createFromFormat('H:i:s', $start);
                $endCarbon = $startCarbon->copy()->addHours(rand(1, 3));
                $end = $endCarbon->format('H:i:s');
            }

            Booking::create([
                'user_id'        => $faker->numberBetween(1, 200),
                'booking_date'   => $faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
                'booking_type'   => $type,
                'half_day_type'  => $halfType,
                'start_time'     => $start,
                'end_time'       => $end,
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);
        }
    }
}
