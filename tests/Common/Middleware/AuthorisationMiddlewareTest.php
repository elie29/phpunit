<?php
namespace Common\Middleware;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Stub\KsqTestCase;
use Mockery;

class AuthorisationMiddlewareTest extends KsqTestCase
{

    public function testProcessEmptyAuthorisation()
    {
        $response = Mockery::mock(ResponseInterface::class);
        $request = Mockery::mock(ServerRequestInterface::class);

        $delegate = Mockery::mock(DelegateInterface::class);
        $delegate->shouldReceive('process')->andReturn($response);

        $middleware = new AuthorisationMiddleware();
        $res = $middleware->process($request, $delegate);

        assertThat($res, sameInstance($response));
    }
}

