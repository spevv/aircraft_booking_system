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
     * @var Collection
     */
    public $schema;

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
//    public function schema(): Collection
//    {
//        $schema = new Collection();
//        for ($i = 1; $i <= $this->rows; $i++) {
//            $row = [];
//            foreach ($this->rowArrangement as $key => $value) {
//                $row[$value] = null;
//
//                if ($value == self::AISLE) {
//                    $row[$value] = true;
//                }
//            }
//
//            $schema->put($i, $row);
//        }
//
//        return $schema;
//    }

    /**
     * @param  Collection  $reserved
     *
     * @return Collection
     */
//    public function getAllSeats(Collection $reserved): Collection
//    {
//        $reserved->map(function ($value, $key) {
//            $currentValue = $this->schema->get($key);
//            foreach ($value as $item => $value2) {
//                $currentValue[$item] = $value2;
//            }
//
//            $this->schema->put($key, $currentValue);
//        });
//
//        $reserved->each(function ($value, $key){
//            $currentValue = $this->schema->get($key);
//            foreach ($value as $item => $value2) {
//                $currentValue[$item] = $value2;
//            }
//
//            $this->schema->put($key, $currentValue);
//        });
//
//        return $this->schema;
//    }

    /**
     * @return Collection
     */
    public function schema(): Collection
    {
        $schema = new Collection();
        for ($i = 1; $i <= $this->rows; $i++) {
            $row = new Row($i);
            foreach ($this->rowArrangement as $key => $value) {
                if ($value == self::AISLE) {
                    $row->addSeat($value, true);
                } else {
                    $row->addSeat($value, null);
                }
            }

            $schema->put($i, $row);
        }

        return $schema;
    }
//
//    public function schemaNew(): Collection
//    {
//        $schema = new Collection();
//        for ($i = 1; $i <= $this->rows; $i++) {
//            $row = new Row($i);
//            $part = 'left'; // TODO can be more than 2 parts
//            foreach ($this->rowArrangement as $key => $value) {
//                if ($value == self::AISLE) {
//                    $row->addSeat($value, true);
//                    $part = 'right';
//                } else {
//                    $row->addSeat($value, null, $part);
//                }
//            }
//
//            $schema->put($i, $row);
//        }
//
//        return $schema;
//    }

    /**
     * @param  Collection  $reservedSeats
     * @return self
     */
    public function addReservedSeats(Collection $reservedSeats): self
    {
        $this->schema = $this->schema()->map(function ($row, $key) use ($reservedSeats) {
            $currentRow = $reservedSeats->get($key);
            if ($currentRow) {
                $row->loadSeatsToRow($currentRow);
            }

            return $row;
        });

        return $this;
    }

    /**
     * @return Collection
     */
    public function getSeats(): Collection
    {
        return $this->schema;
    }

    /**
     * @return Collection
     */
    public function getSchemaLeft(): Collection
    {
        return $this->schema->map(function (Row $row) {
            return $row->getLeftPart();
        });
    }

    /**
     * @return Collection
     */
    public function getSchemaRight(): Collection
    {
        return $this->schema->map(function (Row $row) {
            return $row->getRightPart();
        });
    }

    /**
     * @return Collection
     */
    public function getSchemaRightReversed(): Collection
    {
        return $this->getSchemaRight()->map(function ($row) {
            return $row->reverse();
        });
    }
}
