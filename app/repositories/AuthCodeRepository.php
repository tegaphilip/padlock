<?php

namespace App\Repositories;

use App\Library\OAuthHelper;
use App\Library\Utils;
use App\Models\AuthCode;
use League\OAuth2\Server\Entities\AuthCodeEntityInterface;
use League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException;
use League\OAuth2\Server\Repositories\AuthCodeRepositoryInterface;

/**
 * Class AuthCodeRepository
 * @package App\Repositories
 */
class AuthCodeRepository extends Repository implements AuthCodeRepositoryInterface
{
    use Utils, OAuthHelper;

    /**
     * Model class name for the concrete implementation
     *
     * @return string
     */
    public function modelName()
    {
        return AuthCode::class;
    }

    /**
     * Creates a new AuthCode
     *
     * @return AuthCodeEntityInterface
     */
    public function getNewAuthCode()
    {
        return new AuthCode();
    }

    /**
     * Persists a new auth code to permanent storage.
     *
     * @param AuthCodeEntityInterface $authCodeEntity
     *
     * @throws UniqueTokenIdentifierConstraintViolationException
     */
    public function persistNewAuthCode(AuthCodeEntityInterface $authCodeEntity)
    {
        $authCode = $authCodeEntity->getIdentifier();
        if ($this->findOne(['authorization_code' => $authCode])) {
            throw UniqueTokenIdentifierConstraintViolationException::create();
        }

        $this->create([
            'authorization_code' => $authCode,
            'expires' => $this->formatDateTime($authCodeEntity->getExpiryDateTime()),
            'scope' => implode(SCOPE_DELIMITER_STRING, $this->getScopeNamesFromAuthCode($authCodeEntity)),
            'client_id' => $authCodeEntity->getClient()->getIdentifier(),
            // I do not understand why redirect_uri isn't saving to the oauth_codes table.. Must be witchcraft
            // switching to redirect_url
            //'redirect_uri' => $authCodeEntity->getRedirectUri(),
            'redirect_url' => $authCodeEntity->getRedirectUri(),
            'user_id' => $authCodeEntity->getUserIdentifier(),
            'revoked' => 0,
        ]);
    }

    /**
     * Revoke an auth code.
     *
     * @param string $codeId
     */
    public function revokeAuthCode($codeId)
    {
        $this->update(['authorization_code' => $codeId], ['revoked' => 1]);
    }

    /**
     * Check if the auth code has been revoked.
     *
     * @param string $codeId
     *
     * @return bool Return true if this code has been revoked
     */
    public function isAuthCodeRevoked($codeId)
    {
        if ($result = $this->findOne(['authorization_code' => $codeId])) {
            return (int)$result->revoked === 1;
        }

        return true;
    }
}
