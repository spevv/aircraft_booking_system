<?php

use App\Models\Flight;
use App\Models\Booking;
use App\Models\Passenger;
use Illuminate\Support\Facades\Artisan;
use Codeception\Util\HttpCode;

/**
 * Class BookingSeatsCest
 */
class BookingSeatsCest
{
    /**
     * @var Flight
     */
    private $flight;

    public function _before(ApiTester $I)
    {
        // TODO move to BasicCest
        Artisan::call('migrate:refresh');
        //Artisan::call('db:seed'); // fake data
        $this->flight = Flight::factory()->create();

        $I->haveHttpHeader('accept', 'application/json');
        $I->haveHttpHeader('content-type', 'application/json');
    }

    /**
     * Store seats
     *
     * TODO move to BasicCest
     *
     * @param  array  $seats
     */
    private function bookSeats(array $seats)
    {
        foreach ($seats as $seat) {
            $row = preg_replace("/\D/", "", $seat);
            $seat = preg_replace("/\d/", "", $seat);

            Booking::factory()->create([
                'flight_id'    => $this->flight->id,
                'row'          => $row,
                'seat'         => $seat,
                'passenger_id' => Passenger::factory(),
            ]);
        }
    }

    public function tryEmptyName(ApiTester $I)
    {
        $I->sendPost("/flights/{$this->flight->id}/seats/booking", [
            'username'     => '',
            'seats_number' => 1,
        ]);
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY); // 422
        $I->seeResponseIsJson();
    }

    public function tryWithoutName(ApiTester $I)
    {
        $I->sendPost("/flights/{$this->flight->id}/seats/booking", [
            'seats_number' => 1,
        ]);
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY); // 422
        $I->seeResponseIsJson();
    }

    public function tryWithoutSeatsNumber(ApiTester $I)
    {
        $I->sendPost("/flights/{$this->flight->id}/seats/booking", [
            'username' => 'test',
        ]);
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY); // 422
        $I->seeResponseIsJson();
    }

    public function tryBigNumber(ApiTester $I)
    {
        $I->sendPost("/flights/{$this->flight->id}/seats/booking", [
            'username'     => 'test',
            'seats_number' => 8,
        ]);
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY); // 422
        $I->seeResponseIsJson();
    }

    public function tryBook1Seat(ApiTester $I)
    {
        $I->sendPost("/flights/{$this->flight->id}/seats/booking", [
            'username'     => 'test',
            'seats_number' => 1,
        ]);
        $I->seeResponseCodeIs(HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContains('{"data":["1A"]}');
    }

    public function tryBook2Seats(ApiTester $I)
    {
        $I->sendPost("/flights/{$this->flight->id}/seats/booking", [
            'username'     => 'test',
            'seats_number' => 2,
        ]);
        $I->seeResponseCodeIs(HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContains('{"data":["1A","1B"]}');
    }

    public function tryBook2SeatsFromRight(ApiTester $I)
    {
        $this->bookSeats(['1A']);
        $I->sendPost("/flights/{$this->flight->id}/seats/booking", [
            'username'     => 'test',
            'seats_number' => 2,
        ]);
        $I->seeResponseCodeIs(HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContains('{"data":["1A","1E","1F"]}');
    }

    public function tryBook2SeatsFromRight2(ApiTester $I)
    {
        $this->bookSeats(['1A', '1B', '1E', '1F']);
        $I->sendPost("/flights/{$this->flight->id}/seats/booking", [
            'username'     => 'test',
            'seats_number' => 2,
        ]);
        $I->seeResponseCodeIs(HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseContains('{"data":["1A","1B","1E","1F","2A","2B"]}');
    }
}
