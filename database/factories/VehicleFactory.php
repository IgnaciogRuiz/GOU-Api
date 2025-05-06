<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Vehicle;

class VehicleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Vehicle::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $brandsAndModels = [
            "Toyota" => ["Corolla", "Hilux", "Yaris"],
            "Ford" => ["Focus", "Ranger", "EcoSport"],
            "Chevrolet" => ["Onix", "Cruze", "Tracker"],
            "Volkswagen" => ["Golf", "Polo", "Amarok"],
            "Renault" => ["Kangoo", "Sandero", "Duster"],
            "Peugeot" => ["208", "308", "Partner"],
            "Fiat" => ["Cronos", "Toro", "Strada"],
            "Honda" => ["Civic", "HR-V", "Fit"],
            "Nissan" => ["Frontier", "Versa", "Kicks"],
            "Jeep" => ["Renegade", "Compass", "Wrangler"]
        ];

        $brand = array_rand($brandsAndModels);
        $model = $brandsAndModels[$brand][array_rand($brandsAndModels[$brand])];
        
        return [
            'user_id' => User::factory(),
            'brand' => $brand,
            'model' => $model,
            'year' => fake()->numberBetween(2000, 2025),
            'license_plate' => fake()->regexify('[A-Za-z0-9]{8}'),
            'dnrpa_approved' => true,
        ];
    }
}
