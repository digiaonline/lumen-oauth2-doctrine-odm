<?php

namespace Nord\Lumen\OAuth2\Doctrine\ODM\Storages;

use Doctrine\ODM\MongoDB\DocumentManager;
use Nord\Lumen\OAuth2\Doctrine\ODM\Documents\AccessToken;
use Nord\Lumen\OAuth2\Doctrine\ODM\Documents\Session;
use Nord\Lumen\OAuth2\Doctrine\ODM\Repositories\AccessTokenRepository;
use Nord\Lumen\OAuth2\Doctrine\ODM\Repositories\SessionRepository;
use Nord\Lumen\OAuth2\Exceptions\AccessTokenNotFound;
use League\OAuth2\Server\Entity\AccessTokenEntity;
use League\OAuth2\Server\Entity\ScopeEntity;
use League\OAuth2\Server\Exception\AccessDeniedException;
use League\OAuth2\Server\Storage\AccessTokenInterface;

class AccessTokenStorage extends DoctrineStorage implements AccessTokenInterface
{

    /**
     * @var AccessTokenRepository
     */
    protected $accessTokenRepository;

    /**
     * @var SessionRepository
     */
    protected $sessionRepository;


    /**
     * AccessTokenStorage constructor.
     *
     * @param DocumentManager $documentManager
     */
    public function __construct(DocumentManager $documentManager)
    {
        parent::__construct($documentManager);

        $this->accessTokenRepository = $this->documentManager->getRepository(AccessToken::class);
        $this->sessionRepository = $this->documentManager->getRepository(Session::class);
    }


    /**
     * @inheritdoc
     */
    public function get($token)
    {
        $accessToken = $this->accessTokenRepository->findByToken($token);

        if ($accessToken === null) {
            throw new AccessDeniedException;
        }

        return $this->createEntity($accessToken);
    }


    /**
     * @inheritdoc
     */
    public function getScopes(AccessTokenEntity $token)
    {
    }


    /**
     * @inheritdoc
     */
    public function create($token, $expireTime, $sessionId)
    {
        /** @var Session $session */
        $session = $this->sessionRepository->find($sessionId);

        $accessToken = new AccessToken($token, $session, (new \DateTime())->setTimestamp($expireTime));

        $this->documentManager->persist($accessToken);
        $this->documentManager->flush($accessToken);
    }


    /**
     * @inheritdoc
     */
    public function associateScope(AccessTokenEntity $token, ScopeEntity $scope)
    {
        throw new \Exception('Not implemented');
    }


    /**
     * @inheritdoc
     */
    public function delete(AccessTokenEntity $token)
    {
        $accessToken = $this->accessTokenRepository->findByToken($token->getId());

        if ($accessToken === null) {
            throw new AccessTokenNotFound;
        }

        $this->documentManager->remove($accessToken);
        $this->documentManager->flush($accessToken);
    }


    /**
     * @param AccessToken $accessToken
     *
     * @return AccessTokenEntity
     */
    protected function createEntity(AccessToken $accessToken)
    {
        $entity = new AccessTokenEntity($this->server);

        $entity->setId($accessToken->getToken());
        $entity->setExpireTime($accessToken->getExpireTime()->getTimestamp());

        return $entity;
    }
}
