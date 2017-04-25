<?php namespace Nord\Lumen\OAuth2\Doctrine\ODM\Storages;

use Doctrine\ODM\MongoDB\DocumentManager;
use League\OAuth2\Server\Entity\RefreshTokenEntity;
use League\OAuth2\Server\Storage\RefreshTokenInterface;
use Nord\Lumen\OAuth2\Doctrine\ODM\Documents\AccessToken;
use Nord\Lumen\OAuth2\Doctrine\ODM\Documents\RefreshToken;
use Nord\Lumen\OAuth2\Doctrine\ODM\Repositories\AccessTokenRepository;
use Nord\Lumen\OAuth2\Doctrine\ODM\Repositories\RefreshTokenRepository;
use Nord\Lumen\OAuth2\Exceptions\RefreshTokenNotFound;

class RefreshTokenStorage extends DoctrineStorage implements RefreshTokenInterface
{

    /**
     * @var RefreshTokenRepository
     */
    protected $refreshTokenRepository;

    /**
     * @var AccessTokenRepository
     */
    protected $accessTokenRepository;


    /**
     * RefreshTokenStorage constructor.
     *
     * @param DocumentManager $documentManager
     */
    public function __construct(DocumentManager $documentManager)
    {
        parent::__construct($documentManager);

        $this->refreshTokenRepository = $this->documentManager->getRepository(RefreshToken::class);
        $this->accessTokenRepository = $this->documentManager->getRepository(AccessToken::class);
    }


    /**
     * @inheritdoc
     */
    public function get($token)
    {
        $refreshToken = $this->refreshTokenRepository->findByToken($token);

        if ($refreshToken === null) {
            throw new RefreshTokenNotFound;
        }

        return $this->createEntity($refreshToken);
    }


    /**
     * @inheritdoc
     */
    public function create($token, $expireTime, $accessToken)
    {
        $refreshToken = new RefreshToken(
            $token,
            $this->accessTokenRepository->findByToken($accessToken),
            (new \DateTime())->setTimestamp($expireTime)
        );

        $this->documentManager->persist($refreshToken);
        $this->documentManager->flush($refreshToken);

        return $this->createEntity($refreshToken);
    }


    /**
     * @inheritdoc
     */
    public function delete(RefreshTokenEntity $token)
    {
        $refreshToken = $this->refreshTokenRepository->findByToken($token->getId());

        if ($refreshToken === null) {
            throw new RefreshTokenNotFound;
        }

        $this->documentManager->remove($refreshToken);
        $this->documentManager->flush($refreshToken);
    }


    /**
     * @param RefreshToken $refreshToken
     *
     * @return RefreshTokenEntity
     */
    protected function createEntity(RefreshToken $refreshToken)
    {
        $entity = new RefreshTokenEntity($this->server);

        $entity->setId($refreshToken->getToken());
        $entity->setAccessTokenId($refreshToken->getAccessToken()->getToken());
        $entity->setExpireTime($refreshToken->getExpireTime()->getTimestamp());

        return $entity;
    }
}
