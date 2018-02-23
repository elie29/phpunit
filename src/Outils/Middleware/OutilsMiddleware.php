<?php
namespace Outils\Middleware;

use DI\FactoryInterface;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Expressive\Application;

class OutilsMiddleware implements MiddlewareInterface
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
        /* @var \Zend\Expressive\Application $app */
        $app = $this->container->make(Application::class);

        require 'config/outils.routes.php';

        return $app->process($request, $delegate);
    }
}

