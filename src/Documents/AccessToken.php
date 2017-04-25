<?php

namespace Nord\Lumen\OAuth2\Doctrine\ODM\Documents;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\Document(repositoryClass="Nord\Lumen\OAuth2\Doctrine\ODM\Repositories\AccessTokenRepository", collection="oauth_access_tokens")
 */
class AccessToken extends Entity
{

    /**
     * @ODM\Field(type="string")
     * @var string
     */
    protected $token;

    /**
     * @ODM\ReferenceOne(targetDocument="Nord\Lumen\OAuth2\Doctrine\ODM\Documents\Session")
     * @var Session
     */
    protected $session;

    /**
     * @ODM\Field(type="date", name="expire_time")
     * @var \DateTime
     */
    protected $expireTime;


    /**
     * AccessToken constructor.
     *
     * @param string $token
     * @param Session $session
     * @param \DateTime $expireTime
     */
    public function __construct($token, Session $session, \DateTime $expireTime)
    {
        $this->token = $token;
        $this->session = $session;
        $this->expireTime = $expireTime;
    }


    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }


    /**
     * @return \DateTime
     */
    public function getExpireTime()
    {
        return $this->expireTime;
    }

    /**
     * @return Session
     */
    public function getSession()
    {
        return $this->session;
    }
}
