<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Collection;

/**
 * Class Flight
 *
 * @property Airplane airplane
 * @property Collection bookings
 *
 * @package App\Models
 */
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

    /**
     * Get reserved aircraft schema
     *
     * @return Collection
     */
    public function getReservedSchema(): Collection
    {
        $reservedSchema = new Collection();
        $this->bookings->each(function ($item) use ($reservedSchema) {
            if ($reservedSchema->get($item->row)) {
                $row = $reservedSchema->pull($item->row);
                $row->addSeat($item->seat, $item->passenger_id);
                $reservedSchema->put($item->row, $row);
            } else {
                $row = new Row($item->row);
                $row->addSeat($item->seat, $item->passenger_id);
                $reservedSchema->put($item->row, $row);
            }
        });

        return $reservedSchema;
    }
}
