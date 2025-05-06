<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Trip;
use App\Models\Vehicle;
use App\Models\Payment;

class TripFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Trip::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $localidades = [
            "Córdoba", "Villa Carlos Paz", "Río Cuarto", "Villa María", "San Francisco",
            "Jesús María", "Alta Gracia", "Villa Allende", "La Calera", "Cosquín",
            "Villa Dolores", "Río Tercero", "Bell Ville", "Villa del Rosario", "Villa General Belgrano",
            "Capilla del Monte", "Dean Funes", "La Falda", "Cruz del Eje", "Arroyito",
            "Monte Cristo", "Colonia Caroya", "Laboulaye", "Corral de Bustos", "Las Varillas",
            "Villa Nueva", "Morteros", "Leones", "Oncativo", "Marcos Juárez",
            "La Carlota", "Villa Cura Brochero", "Santa Rosa de Calamuchita", "Embalse", "Las Perdices",
            "Villa del Totoral", "Río Segundo", "La Cumbre", "San Marcos Sierras", "Bialet Massé",
            "Unquillo", "Malvinas Argentinas", "Mina Clavero", "Tanti", "Oliva",
            "Villa Rumipal", "Villa Yacanto", "Villa Giardino", "Almafuerte", "Sampacho",
            "Santa María de Punilla", "Salsipuedes", "Monte Maíz", "San Basilio", "General Deheza",
            "General Cabrera", "Devoto", "Las Higueras", "Huinca Renancó", "Las Acequias",
            "James Craik", "Justiniano Posse", "Villa Huidobro", "Vicuña Mackenna", "Del Campillo",
            "Balnearia", "Colonia Tirolesa", "Villa Quillinzo", "Charras", "Inriville",
            "San José de la Dormida", "Cañada de Gómez", "La Para", "Villa Los Aromos", "Pilar",
            "Los Cóndores", "Santa Eufemia", "Villa de Soto", "Pampayasta", "Villa El Chacay",
            "El Fortín", "Manfredi", "Serrano", "Pozo del Molle", "La Puerta",
            "Wenceslao Escalante", "Sacanta", "Ticino", "Villa del Dique", "Charbonier",
            "Los Cocos", "Villa Tulumba", "Villa Sarmiento", "Las Tapias", "El Tío",
            "Etruria", "Pascanas", "Carnerillo", "Cavanagh", "Colazo",
            "Villa Reducción", "Achiras", "Sebastián Elcano", "El Brete", "Obispo Trejo"
        ];

        $precio = fake()->randomFloat(2, 0, 99999.99);

        return [
            'vehicle_id' => Vehicle::factory(),
            'origin' => $localidades[random_int(0, 99)],
            'destination' => $localidades[random_int(0, 99)],
            'date' => fake()->dateTime(),
            'available_seats' => fake()->numberBetween(1, 7),
            'price' => $precio,
        ];
    }
}
