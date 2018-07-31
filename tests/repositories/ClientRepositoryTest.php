<?php
/**
 * Created by PhpStorm.
 * User: tega
 * Date: 30.07.18
 * Time: 16:02
 */

use App\Repositories\ClientRepository;
use PHPUnit\Framework\TestCase;

class ClientRepositoryTest extends TestCase
{
    /** @var ClientRepository */
    private $repository;

    public function setUp()
    {
        $this->repository = new ClientRepository();
    }

    public function testGetModelName()
    {
        $this->assertEquals($this->repository->modelName(), 'App\Models\Client');
    }

    public function testGetClientEntity()
    {
        $this->assertInstanceOf(
            'League\OAuth2\Server\Entities\ClientEntityInterface',
            $this->repository->getClientEntity('test', null, 'secret')
        );
    }

    public function testValidateGrant()
    {
        $this->assertTrue($this->repository->validateGrant('password,client_credentials', 'password'));
        $this->assertFalse($this->repository->validateGrant('password,client_credentials', 'implicit'));
    }
}
