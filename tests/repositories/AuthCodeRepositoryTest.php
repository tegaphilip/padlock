<?php
/**
 * Created by PhpStorm.
 * User: tega
 * Date: 30.07.18
 * Time: 16:02
 */

use App\Models\AuthCode;
use App\Repositories\AuthCodeRepository;
use Carbon\Carbon;
use League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException;
use PHPUnit\Framework\TestCase;

class AuthCodeRepositoryTest extends TestCase
{
    /** @var AuthCodeRepository */
    private $repository;

    /** @var \App\Models\Client */
    private $client;

    public function setUp()
    {
        $this->repository = new AuthCodeRepository();
        $this->client = new \App\Models\Client();
        $this->client->setIdentifier('test');
    }

    public function tearDown()
    {
        //clear tokens
        $authCodes = $this->repository->all();
        /** @var AuthCode $code */
        foreach ($authCodes as $code) {
            $code->delete();
        }
    }

    public function testGetModelName()
    {
        $this->assertEquals($this->repository->modelName(), 'App\Models\AuthCode');
    }

    public function testGetNewAuthCode()
    {
        $this->assertInstanceOf('App\Models\AuthCode', $this->repository->getNewAuthCode());
    }

    public function testPersistNewAuthCode()
    {
        $code = $this->createNewAuthCode();
        try {
            $this->repository->persistNewAuthCode($code);
            /** @var AuthCode $result */
            $result = $this->repository->findOne(['authorization_code' => $code->getIdentifier()]);
            $this->assertEquals($result->authorization_code, $code->getIdentifier());
        } catch (UniqueTokenIdentifierConstraintViolationException $e) {
            $this->fail($e->getMessage());
        }
    }

    /**
     * @expectedException \League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException
     */
    public function testPersistExistingAuthCode()
    {
        $code = $this->createNewAuthCode();
        $this->repository->persistNewAuthCode($code);

        $code2 = clone $code;
        $this->repository->persistNewAuthCode($code2);
    }

    public function testRevokeToken()
    {
        try {
            $code = $this->createNewAuthCode();
            $this->repository->persistNewAuthCode($code);
            $this->repository->revokeAuthCode($code->getIdentifier());
            //grab from database
            $token = $this->repository->findOne(['authorization_code' => $code->getIdentifier()]);
            $this->assertTrue((int)$token->revoked === 1);
        } catch (UniqueTokenIdentifierConstraintViolationException $exception) {
            $this->fail($exception->getMessage());
        }
    }

    /**
     * @return AuthCode
     */
    private function createNewAuthCode()
    {
        $code = new AuthCode();

        $code->setClient($this->client);
        $code->setExpiryDateTime(Carbon::now());
        $code->setIdentifier(bin2hex(openssl_random_pseudo_bytes(25, $strong)));
        return $code;
    }
}
