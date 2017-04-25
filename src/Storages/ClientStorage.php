<?php namespace Nord\Lumen\OAuth2\Doctrine\ODM\Storages;

use Doctrine\ODM\MongoDB\DocumentManager;
use Nord\Lumen\OAuth2\Doctrine\ODM\Documents\Client;
use Nord\Lumen\OAuth2\Doctrine\ODM\Documents\Session;
use Nord\Lumen\OAuth2\Doctrine\ODM\Repositories\ClientRepository;
use Nord\Lumen\OAuth2\Doctrine\ODM\Repositories\SessionRepository;
use Nord\Lumen\OAuth2\Exceptions\ClientNotFound;
use League\OAuth2\Server\Entity\ClientEntity;
use League\OAuth2\Server\Entity\SessionEntity;
use League\OAuth2\Server\Storage\ClientInterface;

class ClientStorage extends DoctrineStorage implements ClientInterface
{

    /**
     * @var ClientRepository
     */
    protected $clientRepository;

    /**
     * @var SessionRepository
     */
    protected $sessionRepository;


    /**
     * ClientStorage constructor.
     *
     * @param DocumentManager $documentManager
     */
    public function __construct(DocumentManager $documentManager)
    {
        parent::__construct($documentManager);

        $this->clientRepository  = $this->documentManager->getRepository(Client::class);
        $this->sessionRepository = $this->documentManager->getRepository(Session::class);
    }


    /**
     * @inheritdoc
     */
    public function get($clientId, $clientSecret = null, $redirectUri = null, $grantType = null)
    {
        /** @var Client $client */
        $client = $this->clientRepository->findByKey($clientId);

        if ($client === null) {
            throw new ClientNotFound;
        }

        return $this->createEntity($client);
    }


    /**
     * @inheritdoc
     */
    public function getBySession(SessionEntity $entity)
    {
        /** @var Session $session */
        $session = $this->sessionRepository->find($entity->getId());

        $client = $this->clientRepository->findBySession($session);

        if ($client === null) {
            throw new ClientNotFound;
        }

        return $this->createEntity($client);
    }


    /**
     * @param Client $client
     *
     * @return \League\OAuth2\Server\Entity\ClientEntity
     */
    protected function createEntity(Client $client)
    {
        $entity = new ClientEntity($this->server);

        $entity->hydrate([
            'id'   => $client->getKey(),
            'name' => $client->getName(),
        ]);

        return $entity;
    }
}
