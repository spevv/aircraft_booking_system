<?php

namespace Database\Factories;

use App\Models\Airplane;
use App\Models\Flight;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class FlightFactory
 *
 * @package Database\Factories
 */
class FlightFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Flight::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'airplane_id' => Airplane::factory(),
            'flight_date' => $this->faker->dateTimeBetween('now', '+30 days'),
        ];
    }
}
