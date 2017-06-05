<?php

namespace Nord\Lumen\OAuth2\Doctrine\ODM\Storages;

use Doctrine\ODM\MongoDB\DocumentManager;
use Nord\Lumen\OAuth2\Doctrine\ODM\Repositories\ClientRepository;
use Nord\Lumen\OAuth2\Doctrine\ODM\Documents\Client;
use Nord\Lumen\OAuth2\Doctrine\ODM\Documents\Session;
use Nord\Lumen\OAuth2\Doctrine\ODM\Repositories\SessionRepository;
use Nord\Lumen\OAuth2\Exceptions\SessionNotFound;
use League\OAuth2\Server\Entity\AccessTokenEntity;
use League\OAuth2\Server\Entity\AuthCodeEntity;
use League\OAuth2\Server\Entity\ScopeEntity;
use League\OAuth2\Server\Entity\SessionEntity;
use League\OAuth2\Server\Storage\SessionInterface;

class SessionStorage extends DoctrineStorage implements SessionInterface
{

    /**
     * @var SessionRepository
     */
    protected $sessionRepository;

    /**
     * @var ClientRepository
     */
    protected $clientRepository;


    /**
     * SessionStorage constructor.
     *
     * @param DocumentManager $documentManager
     */
    public function __construct(DocumentManager $documentManager)
    {
        parent::__construct($documentManager);

        $this->sessionRepository = $this->documentManager->getRepository(Session::class);
        $this->clientRepository = $this->documentManager->getRepository(Client::class);
    }


    /**
     * @inheritdoc
     */
    public function getByAccessToken(AccessTokenEntity $accessToken)
    {
        $session = $this->sessionRepository->findByAccessToken($accessToken->getId());

        if ($session === null) {
            throw new SessionNotFound;
        }

        return $this->createEntity($session);
    }


    /**
     * @inheritdoc
     */
    public function getByAuthCode(AuthCodeEntity $authCode)
    {
        $session = $this->sessionRepository->findByAuthCode($authCode->getId());

        if ($session === null) {
            throw new SessionNotFound();
        }

        return $this->createEntity($session);
    }


    /**
     * @inheritdoc
     */
    public function getScopes(SessionEntity $session)
    {
    }


    /**
     * @inheritdoc
     */
    public function create($ownerType, $ownerId, $clientId, $clientRedirectUri = null)
    {
        $client = $this->clientRepository->findByKey($clientId);

        $session = new Session($ownerType, $ownerId, $client, $clientRedirectUri);

        $this->documentManager->persist($session);
        $this->documentManager->flush($session);

        return $session->getId();
    }


    /**
     * @inheritdoc
     */
    public function associateScope(SessionEntity $session, ScopeEntity $scope)
    {
        throw new \Exception('Not implemented');
    }


    /**
     * @param Session $session
     *
     * @return SessionEntity
     */
    protected function createEntity(Session $session)
    {
        $entity = new SessionEntity($this->server);

        $entity->setId($session->getId());
        $entity->setOwner($session->getOwnerType(), $session->getOwnerId());

        return $entity;
    }
}
