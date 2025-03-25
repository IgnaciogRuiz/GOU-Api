<?php

namespace Database\Seeders;

use App\Models\DriverBloc;
use Illuminate\Database\Seeder;

class DriverBlocSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DriverBloc::factory()->count(5)->create();
    }
}
