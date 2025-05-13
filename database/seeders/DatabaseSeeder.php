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

        User::create([
            'dni' => 46767790,
            'firstname' => 'Ignacio',
            'lastname' => 'Ruiz',
            'email' => fake()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'password' => bcrypt('password'),
            'validated' => fake()->boolean(),
            'cvu' => fake()->regexify('[0-9]{22}'),
            'pending_balance' => 0,
        ]);

        User::create([
            'dni' => 95934473,
            'firstname' => 'Marco',
            'lastname' => 'Taliente',
            'email' => fake()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'password' => bcrypt('password'),
            'validated' => fake()->boolean(),
            'cvu' => fake()->regexify('[0-9]{22}'),
            'pending_balance' => 0,
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

        Reservation::factory()->count(15)->create();

        $reservations = Reservation::get();

        foreach ($reservations as $reserv) {
            if ($reserv->status !== 'canceled') {
                $trip = Trip::find($reserv->trip_id); //viaje
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
                    'payment_date' => now(),
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
                        'rating_date' => fake()->dateTime(),
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
