<?php

namespace Common\Middleware;

use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Container\ContainerInterface;

abstract class AbstractMiddleware implements MiddlewareInterface
{

    /**
     * @param \Psr\Container\ContainerInterface
     */
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

}

