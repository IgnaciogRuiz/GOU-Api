<?php

namespace Database\Seeders;

use App\Models\Allows;
use Illuminate\Database\Seeder;

class AllowsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Allows::factory()->count(5)->create();
    }
}
