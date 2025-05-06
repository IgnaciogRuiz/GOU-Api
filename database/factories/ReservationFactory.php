<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Reservation;
use App\Models\Trip;
use App\Models\User;
use App\Models\Vehicle;



class ReservationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Reservation::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        //creamos un usuario (el que va a viajar)
        $usuario = User::factory()->create();
        
        //Creamos un viaje
        $trip = Trip::factory()->create();

        $cant_etiquetas = random_int(0,9);
        $allows = [];
        for ($i=1; $i<$cant_etiquetas; $i++) {
            $fakeid = random_int(1,10);
            if ( !in_array($fakeid, $allows)) {
               array_push($allows, $fakeid);  
            }
        }
        
        $trip->tags()->sync($allows);

        $estado=["pending","in_progress","completed","canceled"];
        $status=random_int(0,3);

        return [
            'user_id' => $usuario,
            'trip_id' => $trip,
            'status' => $estado[$status],
            'reservation_date' => fake()->dateTime(),
        ];
    }
}
