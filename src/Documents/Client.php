<?php

namespace Nord\Lumen\OAuth2\Doctrine\ODM\Documents;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\Document(repositoryClass="Nord\Lumen\OAuth2\Doctrine\ODM\Repositories\ClientRepository", collection="oauth_clients")
 */
class Client extends Entity
{

    /**
     * @ODM\Field(type="string")
     * @var string
     */
    protected $key;

    /**
     * @ODM\Field(type="string")
     * @var string
     */
    protected $secret;

    /**
     * @ODM\Field(type="string")
     * @var string
     */
    protected $name;


    /**
     * Client constructor.
     *
     * @param string $key
     * @param string $secret
     * @param string $name
     */
    public function __construct($key, $secret, $name)
    {
        $this->key = $key;
        $this->secret = $secret;
        $this->name = $name;
    }


    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }


    /**
     * @return string
     */
    public function getSecret()
    {
        return $this->secret;
    }


    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
