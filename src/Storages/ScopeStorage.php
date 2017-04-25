<?php namespace Nord\Lumen\OAuth2\Doctrine\ODM\Storages;

use Doctrine\ODM\MongoDB\DocumentManager;
use Nord\Lumen\OAuth2\Doctrine\Repositories\ScopeRepository;
use League\OAuth2\Server\Storage\ScopeInterface;

class ScopeStorage extends DoctrineStorage implements ScopeInterface
{

    /**
     * @var ScopeRepository
     */
    protected $repository;


    /**
     * ScopeStorage constructor.
     *
     * @param DocumentManager $documentManager
     */
    public function __construct(DocumentManager $documentManager)
    {
        parent::__construct($documentManager);
    }


    /**
     * @inheritdoc
     */
    public function get($scope, $grantType = null, $clientId = null)
    {
        throw new \Exception('Not implemented');
    }
}
