<?php
namespace Common\Middleware;

use Common\Service\GsrAuthentication;
use Common\Service\KsqSession;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Stub\KsqTestCase;
use Mockery;

class AuthenticationMiddlewareTest extends KsqTestCase
{

    public function testProcessSessionIsConnected()
    {
        $session = Mockery::mock(KsqSession::class);
        $session->shouldReceive('isConnected')->once()->andReturn(true);

        $container = Mockery::mock(ContainerInterface::class);
        $container->shouldReceive('get')->once()->andReturn($session);

        $response = Mockery::mock(ResponseInterface::class);
        $request = Mockery::mock(ServerRequestInterface::class);

        $delegate = Mockery::mock(DelegateInterface::class);
        $delegate->shouldReceive('process')->andReturn($response);

        $middleware = new AuthenticationMiddleware($container);
        $res = $middleware->process($request, $delegate);

        assertThat($res, sameInstance($response));
    }

    public function testProcessSessionIsNotConnected()
    {
        $session = Mockery::mock(KsqSession::class);
        $session->shouldReceive('isConnected')->once()->andReturn(false);
        $session->shouldReceive('login')->once()->andReturn($session);
        $session->shouldReceive('set')->twice()->andReturn($session);

        $gsr = Mockery::mock(GsrAuthentication::class);
        $gsr->shouldReceive('getPac')->once()->andReturn('pac');
        $gsr->shouldReceive('getConnectionParams')->once()->andReturn([]);

        $container = Mockery::mock(ContainerInterface::class);
        $container->shouldReceive('get')->twice()->andReturn($session, $gsr);

        $response = Mockery::mock(ResponseInterface::class);
        $request = Mockery::mock(ServerRequestInterface::class);

        $delegate = Mockery::mock(DelegateInterface::class);
        $delegate->shouldReceive('process')->andReturn($response);

        $middleware = new AuthenticationMiddleware($container);
        $res = $middleware->process($request, $delegate);

        assertThat($res, sameInstance($response));
    }
}

