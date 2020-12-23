<?php

namespace App\Http\Controllers;

use App\Http\Requests\SeatsBookingRequest;
use Illuminate\Http\Request;

class SeatsController extends Controller
{

    public function booking(SeatsBookingRequest $bookingRequest)
    {
        dd('test');
    }
}
