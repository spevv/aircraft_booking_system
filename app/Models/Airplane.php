<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Class Airplane
 *
 * @property Collection rowArrangement
 * @property Collection rowArrangementWithoutAisle
 *
 * @package App\Models
 */
class Airplane extends Model
{
    use HasFactory;

    /**
     * AISLE seats separator
     */
    public const AISLE = '_';

    /**
     * Get rowArrangement as Collection
     *
     * @param $key
     *
     * @return Collection
     */
    public function getRowArrangementAttribute($key): Collection
    {
        return new Collection(explode(' ', $this->attributes['row_arrangement']));
    }

    /**
     * Get rowArrangementWithoutAisle as Collection
     *
     * @param $key
     *
     * @return Collection
     */
    public function getRowArrangementWithoutAisleAttribute($key): Collection
    {
        return $this->rowArrangement->reject(function($value) {
            return $value == self::AISLE;
        });
    }
}
