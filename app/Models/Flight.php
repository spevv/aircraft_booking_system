<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Flight extends Model
{
    use HasFactory;

    /**
     * Get Airplane data
     *
     * @return HasOne
     */
    public function airplane(): HasOne
    {
        return $this->hasOne(Airplane::class, 'id', 'airplane_id');
    }

    /**
     * Get bookings data
     *
     * @return HasMany
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'flight_id', 'id');
    }
}
