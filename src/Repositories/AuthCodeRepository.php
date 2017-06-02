<?php

namespace Nord\Lumen\OAuth2\Doctrine\ODM\Repositories;

use \Doctrine\ODM\MongoDB\DocumentRepository;

class AuthCodeRepository extends DocumentRepository
{

    /**
     * @param string $code
     *
     * @return AuthCode|null|object
     */
    public function findByAuthCode($code)
    {
        return $this->findOneBy(['auth_code' => $code]);
    }
}
