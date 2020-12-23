<?php

class BookSitsCest
{
    public function _before(ApiTester $I)
    {
        $I->haveHttpHeader('accept', 'application/json');
        $I->haveHttpHeader('content-type', 'application/json');
    }

    // tests
    public function tryToTest(ApiTester $I)
    {
    }

    // tests
    public function createUserViaAPI(ApiTester $I)
    {
        $I->sendPost('/flights/1/seats/booking', [
            'username' => 'test',
            'seats_number' => 2
        ]);
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); // 200
        $I->seeResponseIsJson();
        dd($I->grabResponse());
        //$I->seeResponseContains('{"result":"ok"}');

    }
}
