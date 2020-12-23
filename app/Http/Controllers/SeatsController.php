<?php

namespace App\Http\Controllers;

use App\Http\Requests\SeatsBookingRequest;
use App\Http\Resources\SeatsBookingResource;
use App\Services\SeatsBookingService\BookingService;

class SeatsController extends Controller
{

    public function booking(SeatsBookingRequest $bookingRequest): SeatsBookingResource
    {
        $bookingService = new BookingService();
//        dd('test');

        return new SeatsBookingResource(['test' => 'test']);
    }
}
