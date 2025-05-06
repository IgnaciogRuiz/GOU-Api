<?php

namespace Database\Seeders;

use App\Models\DriverBlock;
use Illuminate\Database\Seeder;

class DriverBlockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DriverBlock::factory()->count(5)->create();
    }
}
