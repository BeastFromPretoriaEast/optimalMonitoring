<?php

namespace Database\Seeders;

use App\Models\Meter;
use Illuminate\Database\Seeder;

class MeterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Meter::factory()->count(5)->create();
    }
}
