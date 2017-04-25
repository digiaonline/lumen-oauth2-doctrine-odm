<?php
namespace Nord\Lumen\OAuth2\Doctrine\ODM\Repositories;

use Doctrine\ODM\MongoDB\DocumentRepository;
use Nord\Lumen\OAuth2\Doctrine\ODM\Documents\RefreshToken;

class RefreshTokenRepository extends DocumentRepository
{

    /**
     * @param string $token
     *
     * @return array|RefreshToken|null|object
     */
    public function findByToken($token)
    {
        $qb = $this->createQueryBuilder();
        $qb->addAnd($qb->expr()->field('token')->equals($token));
        $qb->addAnd($qb->expr()->field('expire_time')->gte(new \DateTime()));

        return $qb->getQuery()->getSingleResult();
    }
}
