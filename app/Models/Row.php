<?php

namespace App\Models;

use Illuminate\Support\Collection;

/**
 * Class Row
 * @package App\Models
 */
class Row
{
    /**
     * @var Collection
     */
    private $seats;
    /**
     * @var string
     */
    private $ident;

    /**
     * Row constructor.
     *
     * @param string $ident
     */
    public function __construct(string $ident)
    {
        $this->ident = $ident;
        $this->seats = new Collection();
    }

    /**
     * Add seat
     *
     * @param string $ident
     * @param $status
     */
    public function addSeat(string $ident, $status)
    {
        // TODO check if free
        $this->seats->add(
            new Seat($ident, $status)
        );
    }

    /**
     * Get seats
     *
     * @return Collection
     */
    public function getSeats(): Collection
    {
        return $this->seats;
    }

    /**
     * Load seats to row
     *
     * @param Row $newRow
     *
     * @return $this
     */
    public function loadSeatsToRow(Row $newRow): self
    {
        $this->seats = $this->seats->map(function ($item) use ($newRow) {
            return $newRow->seats->where('ident', $item->ident)->first() ?? $item;
        });

        return $this;
    }

    /**
     * Get left part
     *
     * @return Collection
     */
    public function getLeftPart(): Collection
    {
        return $this->seats->slice(0, $this->getKeyAisle());
    }

    /**
     * Get right part
     *
     * @return Collection
     */
    public function getRightPart(): Collection
    {
        return $this->seats->slice($this->getKeyAisle()+1);
    }

    /**
     * Get aisle key
     *
     * @return int
     */
    private function getKeyAisle(): int
    {
        return $this->seats->where('ident', Airplane::AISLE)->keys()->first();
    }

    /**
     * Get count of free seats of left part
     *
     * @return int
     */
    private function countFreeLeft(): int
    {
        return $this->getLeftPart()->where('status', null)->count();
    }

    /**
     * Get count of free seats of right part
     *
     * @return int
     */
    private function countFreeRight(): int
    {
        return $this->getRightPart()->where('status', null)->count();
    }

    /**
     * Has seats in row
     *
     * @param int $count
     *
     * @return bool
     */
    public function hasSeats(int $count): bool
    {
        return $this->hasSeatsInLeft($count) || $this->hasSeatsInRight($count);
    }

    /**
     * Has seats in left
     *
     * @param int $count
     *
     * @return bool
     */
    public function hasSeatsInLeft(int $count): bool
    {
        return $count <= $this->countFreeLeft();
    }

    /**
     * Has seats in right
     *
     * @param int $count
     *
     * @return bool
     */
    public function hasSeatsInRight(int $count): bool
    {
        return $count <= $this->countFreeRight();
    }
}
