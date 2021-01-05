<?php

namespace App\Models;

use Illuminate\Support\Collection;

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

    public function __construct(string $ident)
    {
        $this->ident = $ident;
        $this->seats = new Collection();

    }

    public function addSeat(string $ident, $status)
    {
        // TODO check if free
        $this->seats->add(
            new Seat($ident, $status)
        );
    }

    /**
     * @return Collection
     */
    public function getSeats(): Collection
    {
        return $this->seats;
    }

    /**
     * @param  Row  $newRow
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
     * @return Collection
     */
    public function getLeftPart(): Collection
    {
        return $this->seats->slice(0, $this->getKeyAisle());
    }

    /**
     * @return Collection
     */
    public function getRightPart(): Collection
    {
        return $this->seats->slice($this->getKeyAisle()+1);
    }

    /**
     * @return int
     */
    private function getKeyAisle(): int
    {
        return $this->seats->where('ident', Airplane::AISLE)->keys()->first();
    }

    /**
     * @return int
     */
    private function countFreeLeft(): int
    {
        return $this->getLeftPart()->where('status', null)->count();
    }

    /**
     * @return int
     */
    private function countFreeRight(): int
    {
        return $this->getRightPart()->where('status', null)->count();
    }

    /**
     * @param  int  $count
     * @return bool
     */
    public function hasSeats(int $count)
    {
        return $this->hasSeatsInLeft($count) || $this->hasSeatsInRight($count);
    }

    /**
     * @param  int  $count
     * @return bool
     */
    public function hasSeatsInLeft(int $count): bool
    {
        return $count <= $this->countFreeLeft();
    }

    /**
     * @param  int  $count
     * @return bool
     */
    public function hasSeatsInRight(int $count): bool
    {
        return $count <= $this->countFreeRight();
    }
}
