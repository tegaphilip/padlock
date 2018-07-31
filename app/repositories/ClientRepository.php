<?php

namespace App\Repositories;

use App\Models\Client;
use League\OAuth2\Server\Repositories\ClientRepositoryInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;

/**
 * Class ClientRepository
 * @package App\Repositories
 */
class ClientRepository extends Repository implements ClientRepositoryInterface
{
    /**
     * Model class name for the concrete implementation
     *
     * @return string
     */
    public function modelName()
    {
        return Client::class;
    }

    /**
     * Get a client.
     *
     * @param string      $clientIdentifier   The client's identifier
     * @param null|string $grantType          The grant type used (if sent)
     * @param null|string $clientSecret       The client's secret (if sent)
     * @param bool        $mustValidateSecret If true the client must attempt to validate the secret if the client
     *                                        is confidential
     *
     * @return ClientEntityInterface
     */
    public function getClientEntity(
        $clientIdentifier,
        $grantType = null,
        $clientSecret = null,
        $mustValidateSecret = true
    ) {
        /** @var Client $client */
        $client = $this->findOne(['client_id' => $clientIdentifier]);
        if (empty($client)) {
            return null;
        }


        if ($mustValidateSecret && $client->client_secret !== $clientSecret) {
            return null;
        }

        //check grant types
        if (!empty($grantType) && !$this->validateGrant($client->grant_types, $grantType)) {
            return null;
        }

        return $client;
    }

    /**
     * @param string|null $clientGrants a comma, separated list of grant types
     * @param string|null $sentGrant
     * @return bool
     */
    public function validateGrant($clientGrants, $sentGrant)
    {
        if (empty($clientGrants)) {
            // no grant saved for this client in database, we assume all fine
            return true;
        }

        $clientGrants = explode(',', $clientGrants);
        array_walk($clientGrants, function (&$item) {
            return trim($item);
        });

        if (in_array($sentGrant, $clientGrants)) {
            return true;
        }

        return false;
    }
}
