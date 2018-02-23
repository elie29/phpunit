<?php

namespace Entretien\Middleware;

use DI\FactoryInterface;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Expressive\Application;

class EntretienMiddleware implements MiddlewareInterface
{

    /**
     * @param \DI\FactoryInterface in order to use make and not get.
     */
    private $container;

    public function __construct(FactoryInterface $container)
    {
        $this->container = $container;
    }

    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        /* @var $app \Zend\Expressive\Application */
        $app = $this->container->make(Application::class);

        require 'config/entretien.routes.php';

        return $app->process($request, $delegate);
    }

}
