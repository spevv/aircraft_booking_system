<?php

namespace App\Services\SeatsBookingService;

use App\Models\Flight;
use App\Models\Passenger;
use http\Exception\RuntimeException;
use Illuminate\Support\Collection;

class BookingService implements BookingServiceInterface
{
    /**
     * @var Flight
     */
    private Flight $flight;

    /**
     * @var Passenger $passenger
     */
    private Passenger $passenger;

    /**
     * @var int $seatsNumber
     */
    private int $seatsNumber;

    /**
     * @var int $countOfReservedSeats
     */
    private int $countOfReservedSeats;

    /**
     * @var int $countOfFreeSeats
     */
    private int $countOfFreeSeats;

    /**
     * @var Collection $allSeats
     */
    private Collection $allSeats;

    /**
     * BookingService constructor.
     * @param Flight $flight
     * @param Passenger $passenger
     * @param int $seatsNumber
     */
    public function __construct(Flight $flight, Passenger $passenger, int $seatsNumber)
    {
        $this->flight = $flight;
        $this->passenger = $passenger;
        $this->seatsNumber = $seatsNumber;

        $this->countOfReservedSeats = $this->flight->bookings()->count();
        $this->countOfFreeSeats = $this->flight->airplane->sits_count - $this->countOfReservedSeats;

        $this->allSeats = $this->getAllSeats();
    }

    /**
     * Get suitable seats
     *
     * @return Collection
     */
    public function getSuitableSeats(): Collection
    {
        if($this->countOfFreeSeats < $this->seatsNumber) {
            throw new RuntimeException('Not enough seats.'); // TODO move to validation layer
        }

        $allSeats = $this->getAllSeats();

        // TODO return first free seats
        $count = $this->seatsNumber;
        for ($i = $count; $i >= 0; $i--)
        {
            $allSeats->each(function ($row) {

            });
        }

        return new Collection();
    }

    /**
     * Get all seats (free and reserved)
     *
     * @return Collection
     */
    private function getAllSeats(): Collection
    {
        $reservedSeats = $this->getReservedSeats();

        return $this->flight->airplane->getAllSeats($reservedSeats);
    }

    /**
     * Get reserved seats
     *
     * @return Collection
     */
    public function getReservedSeats(): Collection
    {
        $reservedSchema = new Collection();
        $this->flight->bookings->each(function ($item) use ($reservedSchema) {
            $reservedSchema->put($item->row, [$item->seat => $item->passenger_id]);
        });

        return $reservedSchema;
    }

    /**
     * Get reserved list
     *
     * @return Collection
     */
    public function getReservedList(): Collection
    {
        $list = new Collection();
        $this->getReservedSeats()->each(function ($row, $rowNumber) use ($list) {
            $list->add(array_key_first($row) . $rowNumber);
        });

        return $list;
    }
}
