<?php

namespace App\Services\SeatsBookingService;

use App\Models\Flight;
use App\Models\Passenger;
use App\Models\Row;
use http\Exception\RuntimeException;
use Illuminate\Support\Collection;

class BookingService implements BookingServiceInterface
{
    /**
     * @var Flight
     */
    private Flight $flight;

    /**
     * @var Passenger $passenger
     */
    private Passenger $passenger;

    /**
     * @var int $seatsNumber
     */
    private int $seatsNumber;

    /**
     * @var int $countOfReservedSeats
     */
    private int $countOfReservedSeats;

    /**
     * @var int $countOfFreeSeats
     */
    private int $countOfFreeSeats;

    /**
     * @var Collection $allSeats
     */
    private Collection $allSeats;

    /**
     * BookingService constructor.
     * @param  Flight  $flight
     * @param  Passenger  $passenger
     * @param  int  $seatsNumber
     */
    public function __construct(Flight $flight, Passenger $passenger, int $seatsNumber)
    {
        $this->flight = $flight;
        $this->passenger = $passenger;
        $this->seatsNumber = $seatsNumber;

        $this->countOfReservedSeats = $this->flight->bookings()->count();
        $this->countOfFreeSeats = $this->flight->airplane->sits_count - $this->countOfReservedSeats;
        //$this->allSeats = $this->getSeats();
    }

    /**
     * Get suitable seats
     *
     * @return Collection
     */
    public function getSuitableSeats(): Collection
    {
        if ($this->countOfFreeSeats < $this->seatsNumber) {
            throw new RuntimeException('Not enough seats.'); // TODO move to validation layer
        }

        //$allSeats = $this->getSeats();
        $leftPart = $this->flight->airplane->getSchemaLeft();
        $rightPart = $this->flight->airplane->getSchemaRightReversed();

        $seatsFromLeftPart = $this->findInPart($leftPart);
        $seatsFromRightPart = $this->findInPart($rightPart);

        return $this->getBetterResult($seatsFromLeftPart, $seatsFromRightPart);
    }

    /**
     * TODO move find{number}Seats methods to classes like Find1Seat->find(). use interface and inheritance
     * TODO don't use switch
     *
     * @param $part
     *
     * @return Collection
     */
    private function findInPart($part): Collection
    {
        $seats = new Collection();
        switch ($this->seatsNumber) {
            case 1:
                $seats = $this->find1Seat($part);
                break;
            case 2:
                $seats = $this->find2Seats($part);
                break;
//            case 3:
//                $seats = $this->find3Seats($leftPart);
//                break;
//            case 4:
//                $seats = $this->find4Seats($leftPart);
//                break;
//            case 5:
//                $seats = $this->find5Seats($leftPart);
//                break;
//            case 6:
//                $seats = $this->find6Seats($leftPart);
//                break;
//            case 7:
//                $seats = $this->find7Seats($leftPart);
//                break;
//            default:
//                $seats = '';
        }

        return $seats;
    }

    /**
     * Get all seats (free and reserved)
     *
     * @return Collection
     */
    private function getSeats(): Collection
    {
        return $this->flight->airplane->getSeats();
    }

    /**
     * @param  Collection  $seats
     * @return Collection
     */
    private function find1Seat(Collection $seats): Collection
    {
        $seat = $this->getFirstOneFree($seats);

        if ($seat->isEmpty()) {
            $seat = $this->getPossibleOneFree($seats);
        }

        return $seat;
    }

    /**
     * @param  Collection  $seats
     * @return Collection
     */
    private function find2Seats(Collection $seats): Collection
    {
        $bookSeats = $this->getFirstPossible2Free($seats);

        if ($bookSeats->isEmpty()) {
            $bookSeats = $this->getPossible2Free($seats);
        }

        return $bookSeats;
    }

    private function find3Seats(Collection $seats): Collection
    {
        // (3+2)
        // (2+3)
        // 1 (5)
    }

    private function find4Seats(Collection $seats): Collection
    {
        // (3+2)
        // (2+3)
        // 1 (5)
    }

    private function find5Seats(Collection $seats): Collection
    {
        // (3+2)
        // (2+3)
        // 1 (5)
    }

    private function find6Seats(Collection $seats): Collection
    {
        // 3 (2)
        // 2 (3)
        // 1 (6)
    }

    private function find7Seats(Collection $seats): Collection
    {
        // 3 (2)
        // 2 (3)
        // 1 (6)
    }

    /**
     * @param  Collection  $seats
     * @return Collection
     */
    private function getFirstOneFree(Collection $seats): Collection
    {
        $seat = new Collection();
        $seats->each(function ($row, $rowNumber) use ($seat) {
            $first = $row->first();
            if (is_null($first->status)) {
                $seat->put($rowNumber, [$first->ident]);
                return false;
            }

            if ($seat->isNotEmpty()) {
                return false;
            }
        });

        return $seat;
    }

    /**
     * @param  Collection  $seats
     * @return Collection
     */
    private function getPossibleOneFree(Collection $seats): Collection
    {
        $seat = new Collection();
        $seats->each(function ($row, $rowNumber) use ($seat) {
            foreach ($row as $key => $value) {
                if (is_null($value->status)) {
                    $seat->put($rowNumber, [$value->ident]);
                    break;
                }
            }

            if ($seat->isNotEmpty()) {
                return false;
            }
        });

        return $seat;
    }

    /**
     * @param  Collection  $seats
     * @return Collection
     */
    private function getFirstPossible2Free(Collection $seats): Collection
    {
        $bookSeats = new Collection();
        $seats->each(function ($row, $rowNumber) use ($bookSeats) {
            $previousFree = false;
            foreach ($row as $key => $value) {
                if (is_null($value->status)) {
                    if ($previousFree) {
                        $bookSeats->put($rowNumber, [$previousFree['ident'], $value->ident]);
                        break;
                    }

                    $previousFree = ['rowNumber' => $rowNumber, 'ident' => $value->ident];
                } else {
                    break;
                }
            }

            if ($bookSeats->isNotEmpty()) {
                return false;
            }
        });

        return $bookSeats;
    }

    /**
     * @param  Collection  $seats
     * @return Collection
     */
    private function getPossible2Free(Collection $seats): Collection
    {
        $bookSeats = new Collection();
        $seats->each(function ($row, $rowNumber) use ($bookSeats) {
            $previousFree = false;
            foreach ($row as $key => $value) {
                if (is_null($value->status) && $previousFree) {
                    if ($previousFree['rowNumber'] == $rowNumber) {
                        $bookSeats->put($rowNumber, [$previousFree['ident'], $value->ident]);
                    } else {
                        $bookSeats->put($previousFree['rowNumber'], [$previousFree['ident']]);
                        $bookSeats->put($rowNumber, [$value->ident]);
                    }

                    break;
                }

                if (is_null($value->status) && ($previousFree == false)) {
                    $previousFree = ['rowNumber' => $rowNumber, 'ident' => $value->ident];
                }
            }

            if ($bookSeats->isNotEmpty()) {
                return false;
            }
        });

        return $bookSeats;
    }

    /**
     * @param  Collection  $leftPart
     * @param  Collection  $rightPart
     *
     * @return Collection
     */
    private function getBetterResult(Collection $leftPart, Collection $rightPart): Collection
    {
        $seats = $leftPart;
        if ($leftPart->count() == 0) {
            $seats = $rightPart;
        }

        if (($rightPart->count() != 0) && ($rightPart->count() < $leftPart->count())) {
            $seats = $rightPart;
        }

        if (
            ($leftPart->count() == $rightPart->count()) &&
            ($leftPart->take(1)->keys()->first() > $rightPart->take(1)->keys()->first())
        ) {
            $seats = $rightPart;
        }

        return $seats;
    }
}
