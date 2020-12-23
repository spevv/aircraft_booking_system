<?php

namespace App\Http\Controllers;

use App\Http\Requests\SeatsBookingRequest;
use App\Http\Resources\SeatsBookingResource;
use App\Models\Flight;
use App\Models\Passenger;
use App\Services\SeatsBookingService\BookingService;

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
     * @param SeatsBookingRequest $bookingRequest
     * @param $flightId
     *
     * @return SeatsBookingResource
     */
    public function booking(SeatsBookingRequest $bookingRequest, $flightId): SeatsBookingResource
    {
        $passenger = new Passenger(['username' => $bookingRequest->username]); // TODO need some logic for passengers
        $flight = Flight::query()->first(); // TODO use $flightId. register Flight

        // TODO move to ServiceProvider
        $bookingService = new BookingService($flight, $passenger, $bookingRequest->seats_number);
        $suitableSeats = $bookingService->getSuitableSeats();

        // TODO book seats using $suitableSeats

        return new SeatsBookingResource($bookingService->getReservedList());
    }
}
