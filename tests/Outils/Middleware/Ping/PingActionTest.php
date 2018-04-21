<?php
namespace Outils\Middleware\Ping;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Psr\Http\Message\ServerRequestInterface;
use Stub\KsqTestCase;
use Mockery;

class PingActionTest extends KsqTestCase
{

    public function testProcess()
    {
        $request = Mockery::mock(ServerRequestInterface::class);
        $delegate = Mockery::mock(DelegateInterface::class);

        $middleware = new PingAction();

        /*@var $res \Zend\Diactoros\Response\JsonResponse */
        $res = $middleware->process($request, $delegate);

        assertThat($res->getPayload(), hasKey('ping'));
    }
}

