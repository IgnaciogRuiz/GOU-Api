<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Tag;

class TagFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Tag::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
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

        return [
            'name' => $etiquetasPermitidas[random_int(0,9)],
        ];
    }
}
