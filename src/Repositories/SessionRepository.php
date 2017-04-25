<?php

namespace Nord\Lumen\OAuth2\Doctrine\ODM\Repositories;

use Doctrine\ODM\MongoDB\DocumentRepository;
use Nord\Lumen\OAuth2\Doctrine\ODM\Documents\AccessToken;
use Nord\Lumen\OAuth2\Doctrine\ODM\Documents\Session;

class SessionRepository extends DocumentRepository
{

    /**
     * @param string $accessToken
     *
     * @return Session|null
     */
    public function findByAccessToken($accessToken)
    {
        // We need to query the access token instead of the session, because there's no reference from session to access token.
        $qb = $this->getDocumentManager()->createQueryBuilder(AccessToken::class);
        $qb->field('token')->equals($accessToken);
        /** @var AccessToken $accessTokenDocument */
        $accessTokenDocument = $qb->getQuery()->getSingleResult();

        return $accessTokenDocument instanceof AccessToken ? $accessTokenDocument->getSession() : null;
    }
}
