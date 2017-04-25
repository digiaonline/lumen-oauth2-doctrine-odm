<?php

namespace Nord\Lumen\OAuth2\Doctrine\ODM;

use Doctrine\ODM\MongoDB\DocumentManager;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider;
use League\OAuth2\Server\Storage\AccessTokenInterface;
use League\OAuth2\Server\Storage\ClientInterface;
use League\OAuth2\Server\Storage\RefreshTokenInterface;
use League\OAuth2\Server\Storage\ScopeInterface;
use League\OAuth2\Server\Storage\SessionInterface;
use Nord\Lumen\OAuth2\Doctrine\ODM\Storages\AccessTokenStorage;
use Nord\Lumen\OAuth2\Doctrine\ODM\Storages\ClientStorage;
use Nord\Lumen\OAuth2\Doctrine\ODM\Storages\RefreshTokenStorage;
use Nord\Lumen\OAuth2\Doctrine\ODM\Storages\ScopeStorage;
use Nord\Lumen\OAuth2\Doctrine\ODM\Storages\SessionStorage;

class DoctrineServiceProvider extends ServiceProvider
{

    /**
     * @inheritdoc
     */
    public function register()
    {
        $this->registerContainerBindings($this->app);
    }


    /**
     * @param Container $container
     */
    protected function registerContainerBindings(Container $container)
    {
        $documentManager = $container->make(DocumentManager::class);

        $container->bind(AccessTokenStorage::class, function () use ($documentManager) {
            return new AccessTokenStorage($documentManager);
        });

        $container->bind(ClientStorage::class, function () use ($documentManager) {
            return new ClientStorage($documentManager);
        });

        $container->bind(RefreshTokenStorage::class, function () use ($documentManager) {
            return new RefreshTokenStorage($documentManager);
        });

        $container->bind(ScopeStorage::class, function () use ($documentManager) {
            return new ScopeStorage($documentManager);
        });

        $container->bind(SessionStorage::class, function () use ($documentManager) {
            return new SessionStorage($documentManager);
        });

        $container->bind(AccessTokenInterface::class, AccessTokenStorage::class);
        $container->bind(ClientInterface::class, ClientStorage::class);
        $container->bind(RefreshTokenInterface::class, RefreshTokenStorage::class);
        $container->bind(ScopeInterface::class, ScopeStorage::class);
        $container->bind(SessionInterface::class, SessionStorage::class);
    }
}
