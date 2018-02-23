<?php

namespace Common\Service;

use Doctrine\Common\EventManager;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\Common\Annotations\CachedReader;
use Doctrine\DBAL\Event\Listeners\OracleSessionInit;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\ORM\Tools\Setup;
use Psr\Container\ContainerInterface;
use Assert\Assertion;
use Doctrine\Common\Cache\Cache;
use Doctrine\DBAL\Logging\SQLLogger;

/**
 * Create and return an instance of EntityManager.
 *
 * Container should have the following parameters:
 * <code>
   $config = [
     'em' => [
         'dev_mode' => true|false,
         'paths' => full path to Entity folder,
         'proxy' => full path to a cache folder
     ]
   ]
 * </code>
 */
class EntityManagerFactory
{

    public function __invoke(ContainerInterface $container)
    {
        $config = $this->getConfig($container);
        $db = $container->get(KsqSession::class)->get('connection.params');

        $eventManager = new EventManager();
        $eventManager->addEventSubscriber(new OracleSessionInit());

        return EntityManager::create($db, $config, $eventManager);
    }

    /**
     * Create configuration object.
     */
    private function getConfig(ContainerInterface $container)
    {
        $config = $container->has('config') ? $container->get('config') : [];
        Assertion::keyIsset($config, 'em');

        $config = $config['em'];
        $cache = $container->get(Cache::class);

        $reader = new CachedReader(new AnnotationReader(), $cache, $config['dev_mode']);
        $driver = new AnnotationDriver($reader, $config['paths']);

        $config = Setup::createConfiguration($config['dev_mode'], $config['proxy'], $cache);
        $config->setMetadataDriverImpl($driver);
        $config->setSQLLogger($container->get(SQLLogger::class));

        AnnotationRegistry::registerLoader('class_exists');

        return $config;
    }

}
