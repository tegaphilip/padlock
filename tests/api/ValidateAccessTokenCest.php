<?php

class ValidateAccessTokenCest
{
    /**
     * @param ApiTester $I
     * @throws Exception
     */
    public function tryToTest(ApiTester $I)
    {
        $I->sendPOST('/api/v1/oauth/token', ApiTestUtils::tokenRequestSample());

        CommonTests::assertSuccessResponse($I);
        CommonTests::testResponseSchema($I, ['token_type', 'expires_in', 'access_token', 'refresh_token']);

        $data =  $I->grabDataFromResponseByJsonPath('$.data')[0];
        $I->assertEquals('Bearer', $data['token_type']);

        $I->setHeader('Authorization', 'Bearer ' . $data['access_token']);
        $I->sendPOST('/api/v1/oauth/token/validate');
        CommonTests::assertSuccessResponse($I);
    }
}
