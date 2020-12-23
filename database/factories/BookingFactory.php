<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\Flight;
use App\Models\Passenger;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class BookingFactory
 *
 * @package Database\Factories
 */
class BookingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Booking::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $flight = Flight::factory()->create();

        return [
            'flight_id' => $flight->id,
            'row' => $this->faker->numberBetween(1, $flight->airplane->sits_count),
            'seat' => $this->faker->randomElement($flight->airplane->rowArrangementWithoutAisle->toArray()),
            'passenger_id' => Passenger::factory(),
        ];
    }
}
