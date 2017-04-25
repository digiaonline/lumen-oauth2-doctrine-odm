<?php

namespace Nord\Lumen\OAuth2\Doctrine\ODM\Repositories;

use Nord\Lumen\OAuth2\Doctrine\ODM\Documents\AccessToken;
use \Doctrine\ODM\MongoDB\DocumentRepository;

class AccessTokenRepository extends DocumentRepository
{

    /**
     * @param string $token
     *
     * @return AccessToken|null|object
     */
    public function findByToken($token)
    {
        return $this->findOneBy(['token' => $token]);
    }
}
