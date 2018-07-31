<?php
namespace App\Models;

use League\OAuth2\Server\Entities\AuthCodeEntityInterface;
use League\OAuth2\Server\Entities\Traits\AuthCodeTrait;
use League\OAuth2\Server\Entities\Traits\EntityTrait;
use League\OAuth2\Server\Entities\Traits\TokenEntityTrait;

/**
 * @author Tega Oghenekohwo <tega.philip@gmail.com>
 * Class AuthCode
 * @property string client_id
 * @property string authorization_code
 * @property string expires
 * @property string user_id
 * @property string scope
 * @property string redirect_url
 * @property int revoked
 * @package App\Models
 */
class AuthCode extends BaseModel implements AuthCodeEntityInterface
{
    use AuthCodeTrait, EntityTrait, TokenEntityTrait;

    public function initialize()
    {
        $this->setSource('oauth_authorization_codes');
    }
}
