<?php
namespace App\Models;

use League\OAuth2\Server\Entities\ScopeEntityInterface;

/**
 * @author Tega Oghenekohwo <tega.philip@gmail.com>
 * Class Scope
 * @property int id
 * @property string scope
 * @property int is_default
 * @package App\Models
 */
class Scope extends BaseModel implements ScopeEntityInterface
{
    public function initialize()
    {
        $this->setSource('oauth_scopes');
    }

    /**
     * @return string
     */
    public function getIdentifier()
    {
        return $this->scope;
    }

    /**
     * @param $identifier
     * @return $this
     */
    public function setIdentifier($identifier)
    {
        $this->scope = $identifier;
        return $this;
    }
}
