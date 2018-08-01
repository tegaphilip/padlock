<?php
namespace App\Models;

use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;
use League\OAuth2\Server\Entities\Traits\EntityTrait;
use League\OAuth2\Server\Entities\Traits\RefreshTokenTrait;

/**
 * @author Tega Oghenekohwo <tega.philip@gmail.com>
 * Class RefreshToken
 * @property string client_id
 * @property string refresh_token
 * @property string expires
 * @property string user_id
 * @property string scope
 * @property int revoked
 * @package App\Models
 */
class RefreshToken extends BaseModel implements RefreshTokenEntityInterface
{
    use RefreshTokenTrait, EntityTrait;

    public function initialize()
    {
        $this->setSource('oauth_refresh_tokens');
    }

    /**
     * @param $clientId
     * @return $this
     */
    public function setClientId($clientId)
    {
        $this->client_id = $clientId;
        return $this;
    }
}
