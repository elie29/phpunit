<?php

use Common\Middleware\GenericErrorMiddleware;
use Common\Service\EntityManagerFactory;
use Common\Service\FileDebugStack;
use Common\Service\GsrAuthentication;
use Common\Service\KsqSession;
use Doctrine\Common\Cache\ArrayCache;
use Doctrine\Common\Cache\Cache;
use Doctrine\DBAL\Logging\SQLLogger;
use Doctrine\ORM\EntityManagerInterface;
use Entretien\Repository\CategorieRepository;
use Middlewares\Whoops;
use Zend\Expressive\Application;
use Zend\Expressive\Container\ApplicationFactory;
use Zend\Expressive\Router\FastRouteRouterFactory;
use Zend\Expressive\Router\RouterInterface;
use function DI\autowire;
use function DI\factory;
use function DI\get;

return [
    'config' => [
        'router' => [
            'fastroute' => [
                // Enable caching support: MUST MERGE ALL MODULES MIDDLEWARE IN ONE FILE
                'cache_enabled' => !DEV_MODE,
                // Cache file path
                'cache_file' => BE_PATH . '/cache/fastroute.php.cache'
            ]
        ],
        // EntityManager params
        'em' => [
            'dev_mode' => DEV_MODE,
            'paths' => [realpath(BE_PATH . '/src')],
            'proxy' => BE_PATH . '/cache'
        ]
    ],
    Cache::class => DEV_MODE ? get(ArrayCache::class) : function() {
        // Change it to memcached later
        return require BE_PATH . '/config/cache-definition-file.php';
    },
    SQLLogger::class => DEV_MODE ? get(FileDebugStack::class): null,
    RouterInterface::class => factory(FastRouteRouterFactory::class),
    Application::class => factory(ApplicationFactory::class),
    'HandleExceptionMiddleware' => DEV_MODE ? get(Whoops::class) : get(GenericErrorMiddleware::class),
    EntityManagerInterface::class => factory(EntityManagerFactory::class),
    // Add all classes to the compilation file
    GsrAuthentication::class => autowire(),
    KsqSession::class => autowire(),
    CategorieRepository::class => autowire()
];
