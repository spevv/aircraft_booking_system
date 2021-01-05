<?php

namespace App\Services\SeatsBookingService;

use Illuminate\Support\Collection;

/**
 * Interface BookingServiceInterface
 *
 * @package App\Services\SeatsBookingService
 */
interface BookingServiceInterface
{
    /**
     * Get suitable seats
     *
     * @return Collection
     */
    public function getSuitableSeats(): Collection;
}
