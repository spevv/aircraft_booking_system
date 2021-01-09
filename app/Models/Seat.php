<?php

namespace App\Models;

/**
 * Class Seat
 * @package App\Models
 */
class Seat
{
    /**
     * @var string
     */
    public $ident;

    /**
     * @var mixed
     */
    public $status;

    /**
     * Seat constructor.
     *
     * @param string $ident
     * @param $status
     */
    public function __construct(string $ident, $status)
    {
        $this->ident = $ident;
        $this->status = $status;
    }

    /**
     * Is it aisle
     *
     * @return bool
     */
    public function isAisle(): bool
    {
        return $this->ident == Airplane::AISLE;
    }
}
