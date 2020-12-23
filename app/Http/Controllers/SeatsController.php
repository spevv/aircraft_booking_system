<?php

namespace App\Http\Controllers;

use App\Http\Requests\SeatsBookingRequest;
use App\Http\Resources\SeatsBookingResource;
use App\Models\Booking;
use App\Models\Flight;
use App\Services\SeatsBookingService\BookingService;
use Database\Factories\BookingFactory;

class SeatsController extends Controller
{

    public function booking(SeatsBookingRequest $bookingRequest): SeatsBookingResource
    {
        //$bookingService = new BookingService();
        //dd('controller');
//        Booking::factory(1)->create();
        //$flight = Flight::query()->where('id',51)->first();
//        dd(Booking::all(), (Flight::query()->first())->bookings);
        //$bookingService = new BookingService();
//        dd('test');

        //return new SeatsBookingResource(['test' => 'test']);
    }
}
