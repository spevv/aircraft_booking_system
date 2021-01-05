<?php

namespace Database\Factories;

use App\Models\Airplane;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class AirplaneFactory
 *
 * @package Database\Factories
 */
class AirplaneFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Airplane::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // TODO change to random aircraft type
        return [
            'aircraft_type' => 'short_range',
            'sits_count' => 156,
            'rows' => 3,
            'row_arrangement' => 'A B C _ D E F'
        ];
    }
}
