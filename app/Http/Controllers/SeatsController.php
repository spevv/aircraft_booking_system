<?php

namespace App\Http\Controllers;

use App\Http\Requests\SeatsBookingRequest;
use App\Http\Resources\SeatsBookingResource;
use App\Models\Booking;
use App\Models\Flight;
use App\Models\Passenger;
use App\Services\SeatsBookingService\BookingService;
use Illuminate\Support\Collection;

/**
 * Class SeatsController
 *
 * @package App\Http\Controllers
 */
class SeatsController extends Controller
{

    /**
     * Book seats
     *
     * @param  SeatsBookingRequest  $bookingRequest
     * @param $flightId
     *
     * @return SeatsBookingResource
     */
    public function booking(SeatsBookingRequest $bookingRequest, $flightId): SeatsBookingResource
    {
        $passenger = Passenger::query()->firstOrCreate(['username' => $bookingRequest->username]); // TODO need some logic for passengers
        $flight = Flight::query()->firstOrCreate(['id' => $flightId]); // TODO use $flightId. register Flight in Provider

        Booking::firstOrCreate([
            'flight_id' => $flight->id,
            'row' => 1,
            'seat' => 'A',
            'passenger_id' => 2
        ]);

//        Booking::firstOrCreate([
//            'flight_id' => $flight->id,
//            'row' => 1,
//            'seat' => 'B',
//            'passenger_id' => 2
//        ]);

        $reserved = $flight->getReservedSchema();
        $flight->airplane->addReservedSeats($reserved);

        // TODO move to ServiceProvider
        $bookingService = new BookingService($flight, $passenger, $bookingRequest->seats_number);
        $suitableSeats = $bookingService->getSuitableSeats();

        $this->reserveSeats($suitableSeats, $flight, $passenger);

        return new SeatsBookingResource($this->getReservedList($flight));
    }

    /**
     * @param  Collection  $seats
     * @param  Flight  $flight
     * @param  Passenger  $passenger
     */
    private function reserveSeats(Collection $seats, Flight $flight, Passenger $passenger)
    {
        // TODO use Flight relation for booking
        $seats->each(function ($values, $key) use ($flight, $passenger) {
            foreach ($values as $value) {
                Booking::query()->create([
                    'flight_id' => $flight->id,
                    'row' => $key,
                    'seat' => $value,
                    'passenger_id' => $passenger->id
                ]);
            }
        });
    }

    /**
     * TODO move view logic to Resource
     *
     * @param  Flight  $flight
     * @return Collection
     */
    private function getReservedList(Flight $flight): Collection
    {
        $list = new Collection();
        $flight->refresh()->bookings->each(function ($seat) use ($list) {
            $list->add($seat['row'].$seat['seat']);
        });

        return $list;

    }
}
