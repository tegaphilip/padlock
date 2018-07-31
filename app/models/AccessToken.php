<?php
namespace App\Models;

use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\Traits\AccessTokenTrait;
use League\OAuth2\Server\Entities\Traits\EntityTrait;
use League\OAuth2\Server\Entities\Traits\TokenEntityTrait;

/**
 * @author Tega Oghenekohwo <tega.philip@gmail.com>
 * Class AccessToken
 * @property string client_id
 * @property string access_token
 * @property string expires
 * @property string user_id
 * @property string scope
 * @property int revoked
 * @package App\Models
 */
class AccessToken extends BaseModel implements AccessTokenEntityInterface
{
    use AccessTokenTrait, EntityTrait, TokenEntityTrait;

    public function initialize()
    {
        $this->setSource('oauth_access_tokens');
    }
}
