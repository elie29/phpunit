<?php
namespace Common\Middleware;

use Common\Service\KsqSession;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Stub\KsqTestCase;
use Mockery;

class SessionMiddlewareTest extends KsqTestCase
{

    public function testProcess()
    {
        $session = Mockery::mock(KsqSession::class);
        $session->shouldReceive('start')->once();

        $container = Mockery::mock(ContainerInterface::class);
        $container->shouldReceive('get')->andReturn($session);

        $action = new SessionMiddleware($container);

        $request = Mockery::mock(ServerRequestInterface::class);
        $response = Mockery::mock(ResponseInterface::class);

        $delegate = Mockery::mock(DelegateInterface::class);
        $delegate->shouldReceive('process')->times(1)->andReturn($response);

        $res = $action->process($request, $delegate);

        assertThat($res, sameInstance($response));
    }
}

