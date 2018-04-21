<?php
namespace Outils\Middleware;

use DI\FactoryInterface;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Psr\Http\Message\ServerRequestInterface;
use Stub\KsqTestCase;
use Zend\Expressive\Application;
use Mockery;

class OutilsMiddlewareTest extends KsqTestCase
{

    public function testProcess()
    {
        $application = Mockery::mock(Application::class);
        $application->shouldReceive('pipeDispatchMiddleware')->once();
        $application->shouldReceive('pipeRoutingMiddleware')->once();
        $application->shouldReceive('process')->once()->andReturn('outils');
        $application->shouldReceive('get'); // used in outlis.routes.php
        $application->shouldReceive('post');

        $container = Mockery::mock(FactoryInterface::class);
        $container->shouldReceive('make')->andReturn($application);

        $api = new OutilsMiddleware($container);

        $request = Mockery::mock(ServerRequestInterface::class);
        $delegate = Mockery::mock(DelegateInterface::class);

        $actual = $api->process($request, $delegate);

        assertThat($actual, is('outils'));
    }
}

