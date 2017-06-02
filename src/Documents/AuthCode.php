<?php

namespace Nord\Lumen\OAuth2\Doctrine\ODM\Documents;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\Document(repositoryClass="Nord\Lumen\OAuth2\Doctrine\ODM\Repositories\AuthCodeRepository", collection="oauth_auth_codes")
 */
class AuthCode extends Entity
{

    /**
     * @ODM\Field(type="string", name="auth_code")
     * @var string
     */
    protected $authCode;

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
     * @ODM\Field(type="string", name="client_redirect_uri")
     * @var string
     */
    protected $redirectUri;

    /**
     * AccessToken constructor.
     *
     * @param string $authCode
     * @param Session $session
     * @param string $redirectUri
     * @param \DateTime $expireTime
     */
    public function __construct($authCode, Session $session, $redirectUri, \DateTime $expireTime)
    {
        $this->authCode = $authCode;
        $this->session = $session;
        $this->redirectUri = $redirectUri;
        $this->expireTime = $expireTime;
    }


    /**
     * @return string
     */
    public function getAuthCode()
    {
        return $this->authCode;
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

    /**
     * @return string
     */
    public function getRedirectUri()
    {
        return $this->redirectUri;
    }
}
