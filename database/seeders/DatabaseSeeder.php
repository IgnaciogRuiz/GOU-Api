<?php

namespace Database\Seeders;

use App\Models\Rating;
use App\Models\Reservation;
use App\Models\Trip;
use App\Models\User;
use App\Models\Tag;
use App\Models\Vehicle;
use App\Models\Commission;
use App\Models\Payment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $ignacio = User::create([
            'dni' => 46767790,
            'profile_photo' => 'photos/nacho.png',
            'firstname' => 'Ignacio',
            'lastname' => 'Ruiz',
            'email' => fake()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'password' => bcrypt('password'),
            'validated' => fake()->boolean(),
            'cvu' => fake()->regexify('[0-9]{22}'),
            'pending_balance' => 0,
        ]);

        $marco = User::create([
            'dni' => 95934473,
            'profile_photo' => 'photos/marco.jpg',
            'firstname' => 'Marco',
            'lastname' => 'Taliente',
            'email' => fake()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'password' => bcrypt('password'),
            'validated' => fake()->boolean(),
            'cvu' => fake()->regexify('[0-9]{22}'),
            'pending_balance' => 0,
        ]);


        // Ignacio es conductor (tiene vehículos y trips)
        $tripDeIgnacio = Trip::factory()->create([
            'vehicle_id' => Vehicle::factory()->create([
                'user_id' => $ignacio->id,
            ])->id,
        ]);

        $etiquetasPermitidas = [
            "comer",
            "fumar",
            "escuchar música",
            "usar GPS",
            "hablar (manos libres)",
            "llevar mascotas",
            "tomar bebidas sin alcohol",
            "cargar el celular",
            "usar aire acondicionado",
            "viajar con acompañantes"
        ];

        foreach ($etiquetasPermitidas as $etiqueta) {
            Tag::create(['name' => $etiqueta]);
        }

        // Ignacio como conductor: 2 trips
        $vehicleIgnacio = Vehicle::factory()->create(['user_id' => $ignacio->id]);

        $trip1Ignacio = Trip::factory()->create(['vehicle_id' => $vehicleIgnacio->id]);
        $trip2Ignacio = Trip::factory()->create(['vehicle_id' => $vehicleIgnacio->id]);

        // Marco como pasajero en un trip de Ignacio
        Reservation::create([
            'user_id' => $marco->id,
            'trip_id' => $trip1Ignacio->id,
            'status' => 'completed',
        ]);

        // Marco como conductor: 1 trip
        $vehicleMarco = Vehicle::factory()->create(['user_id' => $marco->id]);
        $tripMarco = Trip::factory()->create(['vehicle_id' => $vehicleMarco->id]);

        // Ignacio como pasajero en un trip de Marco
        Reservation::create([
            'user_id' => $ignacio->id,
            'trip_id' => $tripMarco->id,
            'status' => 'completed',
        ]);

        // Marco como pasajero en 2 trips más (en total 3 reservas como pasajero)
        $otroTrip1 = Trip::factory()->create(['vehicle_id' => Vehicle::factory()->create()->id]);
        $otroTrip2 = Trip::factory()->create(['vehicle_id' => Vehicle::factory()->create()->id]);

        Reservation::create([
            'user_id' => $marco->id,
            'trip_id' => $otroTrip1->id,
            'status' => 'completed',
        ]);

        Reservation::create([
            'user_id' => $marco->id,
            'trip_id' => $otroTrip2->id,
            'status' => 'completed',
        ]);

        Reservation::factory()->count(15)->create();

        $reservations = Reservation::get();

        foreach ($reservations as $reserv) {
            if ($reserv->status !== 'canceled') {
                $trip = Trip::find($reserv->trip_id); //viaje
                if ($trip->available_seats > 0) { //descontar seats
                    $trip->available_seats = max(0, $trip->available_seats - 1);
                    $trip->save();
                }
                $vehicle = Vehicle::find($trip->vehicle_id); //vehiculo
                $driver = User::find($vehicle->user_id); //el conductor del vehiculo
                $comision = Commission::orderBy('id', 'desc')->first(); //la commission de la empresa
                $precio = $trip->price; //precio del viaje
                $user = User::find($reserv->user_id); //el usuario que reservo

                // Creamos el pago
                $payment = Payment::create([
                    'transaction' => fake()->regexify('[0-9]{10}'),
                    'reservation_id' => $reserv->id,
                    'amount' => $precio,
                    'payment_method' => fake()->randomElement(["cash", "mercadopago"]),
                    'status' => fake()->randomElement(["pending", "completed", "failed"]),
                ]);

                // Si es efectivo, actualizamos el saldo pendiente del conductor
                if ($payment->payment_method === "cash") {
                    $comision_value = $comision->value ?? 0.10; // por si no hay comisión en DB
                    $deuda = $precio * $comision_value;

                    $driver->update([
                        'pending_balance' => $driver->pending_balance + $deuda,
                    ]);
                }

                if (random_int(0, 2)) {
                    Rating::create([
                        'trip_id' => $trip->id,
                        'user_id' => $user->id,
                        'driver_id' => $driver->id,
                        'rating' => fake()->numberBetween(0, 10),
                        'comment' => fake()->realText(100, 1),
                    ]);
                }
            }
        }


        $this->call([
            DriverBlockSeeder::class,
            ChatSeeder::class,
            MessageSeeder::class,
        ]);
    }
}
