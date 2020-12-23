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

    /**
     * Get reserved seats
     *
     * @return Collection
     */
    public function getReservedSeats(): Collection;

    /**
     * Reserved list short format
     *
     * @return Collection
     */
    public function getReservedList(): Collection;
}
