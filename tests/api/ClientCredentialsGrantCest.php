<?php

class ClientCredentialsGrantCest
{
    /**
     * @param ApiTester $I
     * @throws Exception
     */
    public function tryToTest(ApiTester $I)
    {
        $I->sendPOST('/api/v1/oauth/token', [
            'client_id' => 'test',
            'client_secret' => 'secret',
            'grant_type' => 'client_credentials'
        ]);

        CommonTests::assertSuccessResponse($I);
        CommonTests::testResponseSchema($I, ['token_type', 'expires_in', 'access_token']);

        $data =  $I->grabDataFromResponseByJsonPath('$.data')[0];
        $I->assertEquals('Bearer', $data['token_type']);
    }
}
