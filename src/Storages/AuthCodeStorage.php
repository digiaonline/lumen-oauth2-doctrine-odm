<?php

namespace Nord\Lumen\OAuth2\Doctrine\ODM\Storages;

use Doctrine\ODM\MongoDB\DocumentManager;
use League\OAuth2\Server\Entity\AuthCodeEntity;
use League\OAuth2\Server\Entity\ScopeEntity;
use League\OAuth2\Server\Storage\AuthCodeInterface;
use Nord\Lumen\OAuth2\Doctrine\ODM\Documents\AuthCode;
use Nord\Lumen\OAuth2\Doctrine\ODM\Documents\Session;
use Nord\Lumen\OAuth2\Doctrine\ODM\Repositories\AuthCodeRepository;

class AuthCodeStorage extends DoctrineStorage implements AuthCodeInterface
{
    /**
     * @var AuthCodeRepository
     */
    protected $authCodeRepository;

    /**
     * @var SessionRepository
     */
    protected $sessionRepository;

    /**
     * AuthCodeStorage constructor.
     *
     * @param DocumentManager $documentManager
     */
    public function __construct(DocumentManager $documentManager)
    {
        parent::__construct($documentManager);

        $this->authCodeRepository = $this->documentManager->getRepository(AuthCode::class);
        $this->sessionRepository  = $this->documentManager->getRepository(Session::class);
    }

    /**
     * Get the auth code
     *
     * @param string $code
     *
     * @return \League\OAuth2\Server\Entity\AuthCodeEntity | null
     */
    public function get($code)
    {
        $authCode = $this->authCodeRepository->findByAuthCode($code);
        if ($authCode instanceof AuthCode) {
            $entity = new AuthCodeEntity($this->server);
            $entity->setId($authCode->getAuthCode());
            $entity->setRedirectUri($authCode->getRedirectUri());
            $entity->setExpireTime($authCode->getExpireTime()->getTimestamp());

            return $entity;
        }

        return null;
    }

    /**
     * Create an auth code.
     *
     * @param string $token The token ID
     * @param integer $expireTime Token expire time
     * @param integer $sessionId Session identifier
     * @param string $redirectUri Client redirect uri
     *
     * @return void
     */
    public function create($token, $expireTime, $sessionId, $redirectUri)
    {
        /** @var Session $session */
        $session = $this->sessionRepository->find($sessionId);

        $authCode = new AuthCode($token, $session, $redirectUri, (new \DateTime())->setTimestamp($expireTime));

        $this->documentManager->persist($authCode);
        $this->documentManager->flush($authCode);
    }

    /**
     * Get the scopes for an access token
     *
     * @param \League\OAuth2\Server\Entity\AuthCodeEntity $token The auth code
     *
     * @return \League\OAuth2\Server\Entity\ScopeEntity[] Array of \League\OAuth2\Server\Entity\ScopeEntity
     */
    public function getScopes(AuthCodeEntity $token)
    {
        // TODO: Implement getScopes() method.
    }

    /**
     * Associate a scope with an acess token
     *
     * @param \League\OAuth2\Server\Entity\AuthCodeEntity $token The auth code
     * @param \League\OAuth2\Server\Entity\ScopeEntity $scope The scope
     *
     * @return void
     */
    public function associateScope(AuthCodeEntity $token, ScopeEntity $scope)
    {
        // TODO: Implement associateScope() method.
    }

    /**
     * Delete an access token
     *
     * @param \League\OAuth2\Server\Entity\AuthCodeEntity $token The access token to delete
     *
     * @return void
     */
    public function delete(AuthCodeEntity $token)
    {
        $authCode = $this->authCodeRepository->findByAuthCode($token->getId());
        if ($authCode instanceof AuthCode) {
            $this->documentManager->remove($authCode);
            $this->documentManager->flush($authCode);
        }
    }
}
