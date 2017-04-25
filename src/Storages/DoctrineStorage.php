<?php namespace Nord\Lumen\OAuth2\Doctrine\ODM\Storages;

use Doctrine\ODM\MongoDB\DocumentManager;
use League\OAuth2\Server\Storage\AbstractStorage;

abstract class DoctrineStorage extends AbstractStorage
{

    /**
     * @var DocumentManager
     */
    protected $documentManager;


    /**
     * DoctrineStorage constructor.
     *
     * @param DocumentManager $documentManager
     */
    public function __construct(DocumentManager $documentManager)
    {
        $this->documentManager = $documentManager;
    }
}
