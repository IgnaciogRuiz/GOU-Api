<?php

namespace Database\Seeders;

use App\Models\;
use Illuminate\Database\Seeder;

class Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Models::factory()->count(5)->create();
    }
}
