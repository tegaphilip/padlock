<?php
/**
 * Created by PhpStorm.
 * User: tega
 * Date: 30.07.18
 * Time: 16:02
 */

use App\Models\AccessToken;
use App\Repositories\AccessTokenRepository;
use Carbon\Carbon;
use League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException;
use PHPUnit\Framework\TestCase;

class AccessTokenRepositoryTest extends TestCase
{
    /** @var AccessTokenRepository */
    private $repository;

    /** @var \App\Models\Client */
    private $client;

    public function setUp()
    {
        $this->repository = new AccessTokenRepository();
        $this->client = new \App\Models\Client();
        $this->client->setIdentifier('test');
    }

    public function tearDown()
    {
        //clear tokens
        $allAccessTokens = $this->repository->all();
        /** @var AccessToken $accessToken */
        foreach ($allAccessTokens as $accessToken) {
            $accessToken->delete();
        }
    }

    public function testGetModelName()
    {
        $this->assertEquals($this->repository->modelName(), 'App\Models\AccessToken');
    }

    public function testGetNewToken()
    {
        $clientEntityInterface = Mockery::mock('League\OAuth2\Server\Entities\ClientEntityInterface');
        $token = $this->repository->getNewToken($clientEntityInterface, []);
        $this->assertInstanceOf('App\Models\AccessToken', $token);
    }


    public function testPersistNewAccessToken()
    {
        $token = $this->createNewAccessToken();
        try {
            $this->repository->persistNewAccessToken($token);
            /** @var AccessToken $result */
            $result = $this->repository->findOne(['access_token' => $token->getIdentifier()]);
            $this->assertEquals($result->access_token, $token->getIdentifier());
        } catch (UniqueTokenIdentifierConstraintViolationException $exception) {
            $this->fail($exception->getMessage());
        }
    }

    /**
     * @expectedException \League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException
     */
    public function testPersistExistingAccessToken()
    {
        $token = $this->createNewAccessToken();
        $this->repository->persistNewAccessToken($token);

        $token2 = clone $token;
        $this->repository->persistNewAccessToken($token2);
    }

    public function testRevokeToken()
    {
        try {
            $accessToken = $this->createNewAccessToken();
            $this->repository->persistNewAccessToken($accessToken);
            $this->repository->revokeAccessToken($accessToken->getIdentifier());
            //grab from database
            $token = $this->repository->findOne(['access_token' => $accessToken->getIdentifier()]);
            $this->assertTrue((int)$token->revoked === 1);
        } catch (UniqueTokenIdentifierConstraintViolationException $exception) {
            $this->fail($exception->getMessage());
        }
    }

    /**
     * @return AccessToken
     */
    private function createNewAccessToken()
    {
        $token = new AccessToken();

        $token->setClient($this->client);
        $token->setExpiryDateTime(Carbon::now());
        $token->setIdentifier(bin2hex(openssl_random_pseudo_bytes(25, $strong)));

        return $token;
    }
}
