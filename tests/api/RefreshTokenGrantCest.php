<?php

class RefreshTokenGrantCest
{
    /**
     * @param ApiTester $I
     * @throws Exception
     */
    public function tryToTest(ApiTester $I)
    {
        // get access token and refresh token at first
        $I->sendPOST('/api/v1/oauth/token', [
            'client_id' => 'test',
            'client_secret' => 'secret',
            'grant_type' => 'password',
            'username' => 'abc',
            'password' => 'abc',
        ]);

        CommonTests::assertSuccessResponse($I);
        CommonTests::testResponseSchema($I, ['token_type', 'expires_in', 'access_token', 'refresh_token']);

        $data =  $I->grabDataFromResponseByJsonPath('$.data')[0];
        $I->assertEquals('Bearer', $data['token_type']);

        //use the refresh token to get another access token
        $I->sendPOST('/api/v1/oauth/token/', [
            'client_id' => 'test',
            'client_secret' => 'secret',
            'grant_type' => 'refresh_token',
            'refresh_token' => $data['refresh_token']
        ]);

        CommonTests::assertSuccessResponse($I);
        CommonTests::testResponseSchema($I, ['token_type', 'expires_in', 'access_token', 'refresh_token']);

        $new =  $I->grabDataFromResponseByJsonPath('$.data')[0];
        $I->assertEquals('Bearer', $new['token_type']);
    }
}
