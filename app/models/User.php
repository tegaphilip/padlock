<?php
namespace App\Models;

use League\OAuth2\Server\Entities\UserEntityInterface;

/**
 * @author Tega Oghenekohwo <tega.philip@gmail.com>
 * Class User
 * @property string username
 * @property string password
 * @property string scope
 * @property int id
 * @package App\Models
 */
class User extends BaseModel implements UserEntityInterface
{
    public function initialize()
    {
        $this->setSource('oauth_users');
    }

    public function getIdentifier()
    {
        return $this->id;
    }
}
