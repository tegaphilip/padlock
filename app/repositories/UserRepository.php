<?php

namespace App\Repositories;

use App\Models\User;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\UserEntityInterface;
use League\OAuth2\Server\Repositories\UserRepositoryInterface;

/**
 * Class UserRepository
 * @package App\Repositories
 */
class UserRepository extends Repository implements UserRepositoryInterface
{
    /**
     * Model class name for the concrete implementation
     *
     * @return string
     */
    public function modelName()
    {
        return User::class;
    }

    /**
     * Get a user entity.
     *
     * @param string                $username
     * @param string                $password
     * @param string                $grantType    The grant type used
     * @param ClientEntityInterface $clientEntity
     *
     * @return UserEntityInterface
     */
    public function getUserEntityByUserCredentials(
        $username,
        $password,
        $grantType,
        ClientEntityInterface $clientEntity
    ) {
        $user = $this->findOne(['username' => $username, 'password' => $password]);

        return $user;
    }
}
