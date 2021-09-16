<?php

namespace Database\Seeders;

use App\Models\Data;
use App\Models\Meter;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Meter::factory(5)->create();

        foreach (Meter::all() as $meter):

            $timeRead = Carbon::now()->startOfDay()->subWeek()->addDay();

            for ($x = 1; $x <= (48 * 7); $x++):

                if($timeRead > Carbon::now()):
                    break;
                endif;

                Data::create([
                    'meter_id' => $meter->id,
                    'meter_value' => rand(100, 999) / 10,
                    'reading_time' => $timeRead,
                ]);

                $timeRead->addMinutes(30);
            endfor;

        endforeach;
    }
}
