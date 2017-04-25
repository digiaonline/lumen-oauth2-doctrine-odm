<?php

namespace Nord\Lumen\OAuth2\Doctrine\ODM\Repositories;

use Doctrine\ODM\MongoDB\DocumentRepository;
use Nord\Lumen\OAuth2\Doctrine\ODM\Documents\Client;
use Nord\Lumen\OAuth2\Doctrine\ODM\Documents\Session;

class ClientRepository extends DocumentRepository
{

    /**
     * @param string $key
     *
     * @return Client|null|object
     */
    public function findByKey($key)
    {
        return $this->findOneBy(['key' => $key]);
    }

    /**
     * @param Session $session
     *
     * @return Client|null|object
     *
     */
    public function findBySession(Session $session)
    {
        return $this->findOneBy(['session' => $session]);
    }
}
