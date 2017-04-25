<?php namespace Nord\Lumen\OAuth2\Doctrine\ODM\Documents;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\Document(repositoryClass="Nord\Lumen\OAuth2\Doctrine\Repositories\RefreshTokenRepository", collection="oauth_refresh_tokens")
 */
class RefreshToken extends Entity
{

    /**
     * @ODM\Field(type="string")
     * @var string
     */
    protected $token;

    /**
     * @ODM\ReferenceOne(name="access_token", targetEntity="Nord\Lumen\OAuth2\Doctrine\ODM\Documents\AccessToken",
     *     cascade="remove")
     * @var AccessToken
     */
    protected $accessToken;

    /**
     * @ODM\Field(type="date", name="expire_time")
     * @var \DateTime
     */
    protected $expireTime;


    /**
     * RefreshToken constructor.
     *
     * @param string $token
     * @param AccessToken $accessToken
     * @param \DateTime $expireTime
     */
    public function __construct($token, AccessToken $accessToken, \DateTime $expireTime)
    {
        $this->token = $token;
        $this->accessToken = $accessToken;
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
     * @return AccessToken
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }


    /**
     * @return \DateTime
     */
    public function getExpireTime()
    {
        return $this->expireTime;
    }
}
