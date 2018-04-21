<?php
namespace Common\Middleware;

use Common\Service\KsqSession;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Stub\KsqTestCase;
use Mockery;

class RouteNotFoundMiddlewareTest extends KsqTestCase
{

    public function testProcessExpectError()
    {
        $session = Mockery::mock(KsqSession::class);
        $session->shouldReceive('destroy')->once();

        $container = Mockery::mock(ContainerInterface::class);
        $container->shouldReceive('get')->andReturn($session);

        $action = new RouteNotFoundMiddleware($container);

        $request = Mockery::mock(ServerRequestInterface::class);
        $delegate = Mockery::mock(DelegateInterface::class);

        /*@var $res \Zend\Diactoros\Response\JsonResponse */
        $res = $action->process($request, $delegate);

        assertThat($res->getPayload(), hasValue('An unexpected error occurred: URL not found'));
    }
}

