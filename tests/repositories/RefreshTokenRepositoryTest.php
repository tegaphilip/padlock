<?php
/**
 * Created by PhpStorm.
 * User: tega
 * Date: 30.07.18
 * Time: 16:02
 */

use App\Models\RefreshToken;
use App\Repositories\RefreshTokenRepository;
use Carbon\Carbon;
use League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException;
use PHPUnit\Framework\TestCase;

class RefreshTokenRepositoryTest extends TestCase
{
    /** @var RefreshTokenRepository */
    private $repository;

    /** @var \App\Models\Client */
    private $client;

    public function setUp()
    {
        $this->repository = new RefreshTokenRepository();
        $this->client = new \App\Models\Client();
        $this->client->setIdentifier('test');
    }

    public function tearDown()
    {
        //clear tokens
        $tokens = $this->repository->all();
        /** @var RefreshToken $token */
        foreach ($tokens as $token) {
            $token->delete();
        }
    }

    public function testGetModelName()
    {
        $this->assertEquals($this->repository->modelName(), 'App\Models\RefreshToken');
    }

    public function testGetNewToken()
    {
        $this->assertInstanceOf('App\Models\RefreshToken', $this->repository->getNewRefreshToken());
    }

    public function testPersistNewRefreshToken()
    {
        $token = $this->createNewToken();
        try {
            $this->repository->persistNewRefreshToken($token);
            /** @var RefreshToken $result */
            $result = $this->repository->findOne(['refresh_token' => $token->getIdentifier()]);
            $this->assertEquals($result->refresh_token, $token->getIdentifier());
        } catch (UniqueTokenIdentifierConstraintViolationException $e) {
            $this->fail($e->getMessage());
        }
    }

    /**
     * @expectedException \League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException
     */
    public function testPersistExistingRefreshTokenThrowsException()
    {
        $token = $this->createNewToken();
        $this->repository->persistNewRefreshToken($token);

        $token2 = clone $token;
        $this->repository->persistNewRefreshToken($token2);
    }

    public function testRevokeToken()
    {
        try {
            $token = $this->createNewToken();
            $this->repository->persistNewRefreshToken($token);
            $this->repository->revokeRefreshToken($token->getIdentifier());
            //grab from database
            $result = $this->repository->findOne(['refresh_token' => $token->getIdentifier()]);
            $this->assertTrue((int)$result->revoked === 1);
        } catch (UniqueTokenIdentifierConstraintViolationException $exception) {
            $this->fail($exception->getMessage());
        }
    }

    /**
     * @return RefreshToken
     */
    private function createNewToken()
    {
        $token = new RefreshToken();
        $accessToken = Mockery::mock('App\Models\AccessToken');
        $accessToken->shouldReceive('getClient')->andReturn($this->client);
        $accessToken->shouldReceive('getUserIdentifier')->andReturn(null);

        $token->setClientId($this->client->getIdentifier());
        $token->setExpiryDateTime(Carbon::now());
        $token->setAccessToken($accessToken);
        $token->setIdentifier(bin2hex(openssl_random_pseudo_bytes(25, $strong)));
        return $token;
    }
}
