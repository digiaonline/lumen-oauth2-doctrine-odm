<?php

namespace Nord\Lumen\OAuth2\Doctrine\ODM\Documents;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\Document(repositoryClass="Nord\Lumen\OAuth2\Doctrine\ODM\Repositories\SessionRepository", collection="oauth_sessions")
 */
class Session extends Entity
{
    const OWNER_TYPE_USER = 'user';
    const OWNER_TYPE_CLIENT = 'client';

    /**
     * @ODM\Field(type="string", name="owner_type")
     * @var string
     */
    protected $ownerType = self::OWNER_TYPE_USER;

    /**
     * @ODM\Field(type="string", name="owner_id")
     * @var string
     */
    protected $ownerId;

    /**
     * @ODM\ReferenceOne(targetDocument="Nord\Lumen\OAuth2\Doctrine\ODM\Documents\Client")
     * @var Client
     */
    protected $client;

    /**
     * @ODM\Field(type="string", name="client_redirect_uri", nullable=true)
     * @var string
     */
    protected $clientRedirectUri;


    /**
     * Session constructor.
     *
     * @param string $ownerType
     * @param string $ownerId
     * @param Client $client
     * @param string|null $clientRedirectUri
     */
    public function __construct($ownerType, $ownerId, Client $client, $clientRedirectUri = null)
    {
        $this->ownerType = $ownerType;
        $this->ownerId = $ownerId;
        $this->client = $client;
        $this->clientRedirectUri = $clientRedirectUri;
    }


    /**
     * @return string
     */
    public function getOwnerType()
    {
        return $this->ownerType;
    }


    /**
     * @return string
     */
    public function getOwnerId()
    {
        return $this->ownerId;
    }
    /**
     * @return string
     */
    public function getClientRedirectUri()
    {
        return $this->clientRedirectUri;
    }
}
