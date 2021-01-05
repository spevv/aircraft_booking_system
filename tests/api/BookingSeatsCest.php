<?php

use Illuminate\Support\Facades\Artisan;
use Codeception\Util\HttpCode;

// TODO test with faker data
class BookingSeatsCest
{
    public function _before(ApiTester $I)
    {
        // TODO move to BasicCest
        Artisan::call('migrate:refresh');
        Artisan::call('db:seed');

        $I->haveHttpHeader('accept', 'application/json');
        $I->haveHttpHeader('content-type', 'application/json');
    }
/*
    public function tryEmptyName(ApiTester $I)
    {
        $I->sendPost('/flights/1/seats/booking', [
            'username' => '',
            'seats_number' => 1
        ]);
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY); // 422
        $I->seeResponseIsJson();
    }

    public function tryWithoutName(ApiTester $I)
    {
        $I->sendPost('/flights/1/seats/booking', [
            'seats_number' => 1
        ]);
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY); // 422
        $I->seeResponseIsJson();
    }

    public function tryWithoutSeatsNumber(ApiTester $I)
    {
        $I->sendPost('/flights/1/seats/booking', [
            'username' => 'test',
        ]);
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY); // 422
        $I->seeResponseIsJson();
    }

    public function tryBigNumber(ApiTester $I)
    {
        $I->sendPost('/flights/1/seats/booking', [
            'username' => 'test',
            'seats_number' => 8
        ]);
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY); // 422
        $I->seeResponseIsJson();
    }

    public function tryBook1Seat(ApiTester $I)
    {
        $I->sendPost('/flights/1/seats/booking', [
            'username' => 'test',
            'seats_number' => 1
        ]);
        $I->seeResponseCodeIs(HttpCode::OK); // 200
        $I->seeResponseIsJson();
    }
*/
    public function tryBook2Seats(ApiTester $I)
    {
        $I->sendPost('/flights/1/seats/booking', [
            'username' => 'test',
            'seats_number' => 1
        ]);
        $I->seeResponseCodeIs(HttpCode::OK); // 200
        $I->seeResponseIsJson();
        dd($I->grabResponse());
        //$I->seeResponseContains('{"result":"ok"}');
    }
}
