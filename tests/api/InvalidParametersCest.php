<?php

class InvalidParametersCest
{
    /**
     * @param ApiTester $I
     * @throws Exception
     */
    public function tryToTestInvalidClient(ApiTester $I)
    {
        // use a wrong client id
        $data = ApiTestUtils::tokenRequestSample();
        $data['client_id'] = 'fake-id';

        $I->sendPOST('/api/v1/oauth/token', $data);

        CommonTests::assertErrorResponse($I);
        $I->seeResponseCodeIs(401);
        $I->assertEquals('invalid_client', $I->grabDataFromResponseByJsonPath('$.code')[0]);

        //use a wrong client secret
        $data = ApiTestUtils::tokenRequestSample();
        $data['client_secret'] = 'abcdegh';

        $I->sendPOST('/api/v1/oauth/token', $data);

        CommonTests::assertErrorResponse($I);
        $I->seeResponseCodeIs(401);
        $I->assertEquals('invalid_client', $I->grabDataFromResponseByJsonPath('$.code')[0]);
    }

    /**
     * @param ApiTester $I
     * @throws Exception
     */
    public function tryToTestInvalidCredentials(ApiTester $I)
    {
        // use a wrong username
        $data = ApiTestUtils::tokenRequestSample();
        $data['username'] = 'invalid';

        $I->sendPOST('/api/v1/oauth/token', $data);

        CommonTests::assertErrorResponse($I);
        $I->seeResponseCodeIs(401);
        $I->assertEquals('invalid_credentials', $I->grabDataFromResponseByJsonPath('$.code')[0]);

        //use a wrong client secret
        $data = ApiTestUtils::tokenRequestSample();
        $data['password'] = 'abcdegh';

        $I->sendPOST('/api/v1/oauth/token', $data);

        CommonTests::assertErrorResponse($I);
        $I->seeResponseCodeIs(401);
        $I->assertEquals('invalid_credentials', $I->grabDataFromResponseByJsonPath('$.code')[0]);
    }

    /**
     * @param ApiTester $I
     * @throws Exception
     */
    public function tryToTestInvalidScope(ApiTester $I)
    {
        $data = ApiTestUtils::tokenRequestSample();
        $data['scope'] = 'wrong-scope';

        $I->sendPOST('/api/v1/oauth/token', $data);

        CommonTests::assertErrorResponse($I);
        $I->seeResponseCodeIs(400);
        $I->assertEquals('invalid_scope', $I->grabDataFromResponseByJsonPath('$.code')[0]);
    }

    /**
     * @param ApiTester $I
     * @throws Exception
     */
    public function tryToTestInvalidGrantType(ApiTester $I)
    {
        $data = ApiTestUtils::tokenRequestSample();
        $data['grant_type'] = 'wrong-grant';

        $I->sendPOST('/api/v1/oauth/token', $data);

        CommonTests::assertErrorResponse($I);
        $I->seeResponseCodeIs(400);
        $I->assertEquals('unsupported_grant_type', $I->grabDataFromResponseByJsonPath('$.code')[0]);
    }

    /**
     * @param ApiTester $I
     * @throws Exception
     */
    public function tryToValidateInvalidAccessToken(ApiTester $I)
    {
        $I->setHeader('Authorization', 'Bearer ' . 'fake-access-token');
        $I->sendPOST('/api/v1/oauth/token/validate');
        CommonTests::assertErrorResponse($I);
        $I->seeResponseCodeIs(401);
        $I->assertEquals('access_denied', $I->grabDataFromResponseByJsonPath('$.code')[0]);
    }
}
