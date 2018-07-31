<?php

namespace App\Library;

use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\AuthCodeEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;

/**
 * Class OAuthHelper
 * @package App\Library
 */
trait OAuthHelper
{
    /**
     * @param AccessTokenEntityInterface $accessTokenEntity
     * @return array
     */
    public function getScopeNamesFromAccessToken(AccessTokenEntityInterface $accessTokenEntity)
    {
        return $this->scopeToArray($accessTokenEntity->getScopes());
    }

    /**
     * @param AuthCodeEntityInterface $authCodeEntity
     * @return array
     */
    public function getScopeNamesFromAuthCode(AuthCodeEntityInterface $authCodeEntity)
    {
        return $this->scopeToArray($authCodeEntity->getScopes());
    }

    /**
     * @param ScopeEntityInterface[] $scopes
     * @return String[]
     */
    public function scopeToArray(array $scopes)
    {
        $scopeNames = [];
        foreach ($scopes as $scope) {
            $scopeNames[] = $scope->getIdentifier();
        }

        return $scopeNames;
    }
}
