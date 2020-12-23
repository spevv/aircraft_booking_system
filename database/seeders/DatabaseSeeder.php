<?php

namespace Database\Seeders;

use App\Models\Booking;
use Illuminate\Database\Seeder;

/**
 * Class DatabaseSeeder
 *
 * @package Database\Seeders
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Booking::factory(10)->create();
        // \App\Models\User::factory(10)->create();
    }
}
