<?php

namespace App\Http\Controllers;

use App\Http\Requests\SeatsBookingRequest;
use App\Http\Resources\SeatsBookingResource;
use Illuminate\Http\Request;

class SeatsController extends Controller
{

    public function booking(SeatsBookingRequest $bookingRequest): SeatsBookingResource
    {

//        dd('test');

        return new SeatsBookingResource(['test' => 'test']);
    }
}
