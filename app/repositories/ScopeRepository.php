<?php

namespace App\Repositories;

use App\Models\Client;
use App\Models\Scope;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Repositories\ScopeRepositoryInterface;

/**
 * Class ClientRepository
 * @package App\Repositories
 */
class ScopeRepository extends Repository implements ScopeRepositoryInterface
{
    /**
     * Model class name for the concrete implementation
     *
     * @return string
     */
    public function modelName()
    {
        return Scope::class;
    }

    /**
     * {@inheritdoc}
     */
    public function getScopeEntityByIdentifier($identifier)
    {
        /** @var Scope $scope */
        $scope = $this->findOne(['scope' => $identifier]);

        return $scope;
    }

    /**
     * Given a client, grant type and optional user identifier validate the set of scopes requested are valid and
     * optionally append additional scopes or remove requested scopes.
     *
     * @param ScopeEntityInterface[] $scopes
     * @param string $grantType
     * @param ClientEntityInterface $clientEntity
     * @param null|string $userIdentifier
     *
     * @return ScopeEntityInterface[]
     */
    public function finalizeScopes(
        array $scopes,
        $grantType,
        ClientEntityInterface $clientEntity,
        $userIdentifier = null
    ) {
        //we will ignore $userIdentifier as we do not plan to give user based scopes but client based scopes only
        // the implementation of this part should totally depend on whoever uses this library
        // no need to remove invalid scopes (scopes that do not exist in the database)
        // because they will be validated by the league library

        /** @var Client $client */
        $client = (new ClientRepository())->findOne(['client_id' => $clientEntity->getIdentifier()]);
        $clientScopes = empty($clientScope) ? null : $client->scope;

        //if scope was not saved for client or * was saved, ignore and return all scopes
        if (empty($clientScopes) || $clientScopes === '*') {
            //grant all scopes
            return $scopes;
        }

        //scopes of client from database
        $clientScopes = array_map('trim', explode(SCOPE_DELIMITER_STRING, $clientScopes));

        //remove any scope requested but not associated to client
        $result = [];
        foreach ($scopes as $scope) {
            if (!in_array($scope->getIdentifier(), $clientScopes)) {
                continue;
            }

            $result[] = $scope;
        }

        //include scope not requested but associated to client (optional)
        if ($this->getConfig()->oauth->always_include_client_scopes) {
            $includedScopes = array_map(function (Scope $scope) {
                return $scope->getIdentifier();
            }, $result);

            $excludedScopes = array_diff($clientScopes, $includedScopes);
            array_walk($excludedScopes, function ($scopeIdentifier) use (&$result) {
                $result[] = $this->getScopeEntityByIdentifier($scopeIdentifier);
            });
        }

        return $result;
    }
}
