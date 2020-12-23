<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Booking extends Model
{
    use HasFactory;

    /**
     * Get Passenger data
     *
     * @return HasOne
     */
    public function passenger(): HasOne
    {
        return $this->hasOne(Passenger::class, 'id', 'passenger_id');
    }

    /**
     * Get Flight data
     *
     * @return HasOne
     */
    public function flight(): HasOne
    {
        return $this->hasOne(Flight::class, 'id', 'flight_id');
    }
}
