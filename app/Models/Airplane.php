<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Class Airplane
 *
 * @property int sits_count
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
        return $this->rowArrangement->reject(function ($value) {
            return $value == self::AISLE;
        });
    }

    /**
     * Get Airplane seats schema
     *
     * @return Collection
     */
    public function schema(): Collection
    {
        $schema = new Collection();
        for ($i = 1; $i <= $this->rows; $i++) {
            $row = [];
            foreach ($this->rowArrangement as $key => $value) {
                $row[$value] = null;

                if ($value == self::AISLE) {
                    $row[$value] = true;
                }
            }

            $schema->put($i, $row);
        }

        return $schema;
    }

    /**
     * @param  Collection  $reserved
     *
     * @return Collection
     */
    public function getAllSeats(Collection $reserved): Collection
    {
        $schema = $this->schema();
        $reserved->each(function ($value, $key) use ($schema) {
            $currentValue = $schema->get($key);
            foreach ($value as $item => $value2) {
                $currentValue[$item] = $value2;
            }

            $schema->put($key, $currentValue);
        });

        return $schema;
    }
}
