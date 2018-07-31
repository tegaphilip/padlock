<?php
namespace App\Models;

use League\OAuth2\Server\Entities\ClientEntityInterface;

/**
 * @author Tega Oghenekohwo <tega.philip@gmail.com>
 * Class Client
 * @property string client_id
 * @property string|string[] redirect_uri
 * @property string name
 * @property string client_secret
 * @property string expires
 * @property string user_id
 * @property string scope
 * @property string grant_types
 * @package App\Models
 */
class Client extends BaseModel implements ClientEntityInterface
{
    public function initialize()
    {
        $this->setSource('oauth_clients');
    }

    /**
     * @return string
     */
    public function getIdentifier()
    {
        return $this->client_id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string|string[]
     */
    public function getRedirectUri()
    {
        return $this->redirect_uri;
    }

    /**
     * @param $identifier
     * @return $this
     */
    public function setIdentifier($identifier)
    {
        $this->client_id = $identifier;
        return $this;
    }
}
