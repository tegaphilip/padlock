<?php
/**
 * Created by PhpStorm.
 * User: tega
 * Date: 30.07.18
 * Time: 16:02
 */

use App\Repositories\ScopeRepository;
use PHPUnit\Framework\TestCase;

class ScopeRepositoryTest extends TestCase
{
    /** @var ScopeRepository */
    private $repository;

    /** @var \App\Models\Client */
    private $client;

    public function setUp()
    {
        $this->repository = new ScopeRepository();
        $this->client = new \App\Models\Client();
        $this->client->setIdentifier('test');
    }

    public function testGetModelName()
    {
        $this->assertEquals($this->repository->modelName(), 'App\Models\Scope');
    }

    public function getScopeEntityByIdentifier()
    {
        $this->assertInstanceOf(
            'League\OAuth2\Server\Entities\ScopeEntityInterface',
            $this->repository->getScopeEntityByIdentifier('profile')
        );
    }

    public function testFinalizeScopes()
    {
        //invalid scopes are removed
        $this->repository->finalizeScopes()
    }
}
