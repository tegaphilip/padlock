<?php

namespace App\Repositories;

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

        $clientScope = $clientEntity->scope;

        //if scope was not saved for client or * was saved , ignore and return all scopes
        if (empty($clientScope) || $clientScope === '*') {
            //grant all scopes
            return $scopes;
        }

        $clientScopes = array_map('trim', explode(SCOPE_DELIMITER_STRING, $clientScope));

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
