<?php

use \App\Library\HttpStatusCodes;

/**
 * Class CommonTests
 * @author Adeyemi Olaoye <yemi@cottacush.com>
 */
class CommonTests
{
    /**
     * @author Adeyemi Olaoye <yemi@cottacush.com>
     * @param ApiTester $I
     */
    public static function assertErrorResponse(ApiTester $I)
    {
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['status' => 'error']);
    }

    /**
     * @author Adeyemi Olaoye <yemi@cottacush.com>
     * @param ApiTester $I
     */
    public static function assertSuccessResponse(ApiTester $I)
    {
        $I->seeResponseCodeIs(HttpStatusCodes::OK_CODE);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['status' => 'success']);
        $I->canSeeResponseJsonMatchesJsonPath('$.data');
    }

    /**
     * Test response JSON data content
     * @author Adeyemi Olaoye <yemi@cottacush.com>
     * @param ApiTester $I
     * @param array $schema
     */
    public static function testResponseSchema(ApiTester $I, array $schema)
    {
        foreach ($schema as $key) {
            $I->canSeeResponseJsonMatchesJsonPath('$.data.' . $key);
        }
    }
}
