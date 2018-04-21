<?php
namespace Entretien\Middleware;

use DI\FactoryInterface;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Psr\Http\Message\ServerRequestInterface;
use Stub\KsqTestCase;
use Zend\Expressive\Application;
use Mockery;

class EntretienMiddlewareTest extends KsqTestCase
{

    public function testProcess()
    {
        $application = Mockery::mock(Application::class);
        $application->shouldReceive('pipeDispatchMiddleware')->once();
        $application->shouldReceive('pipeRoutingMiddleware')->once();
        $application->shouldReceive('process')->once()->andReturn('application');
        $application->shouldReceive('get'); // used in entretien.routes.php

        $container = Mockery::mock(FactoryInterface::class);
        $container->shouldReceive('make')->andReturn($application);

        $api = new EntretienMiddleware($container);

        $request = Mockery::mock(ServerRequestInterface::class);
        $delegate = Mockery::mock(DelegateInterface::class);

        $actual = $api->process($request, $delegate);

        assertThat($actual, is('application'));
    }
}

