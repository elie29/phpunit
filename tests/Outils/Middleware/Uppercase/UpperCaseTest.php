<?php
namespace Outils\Middleware\Uppercase;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Psr\Http\Message\ServerRequestInterface;
use Stub\KsqTestCase;
use Mockery;

class UpperCaseTest extends KsqTestCase
{

    public function testProcess()
    {
        $request = Mockery::mock(ServerRequestInterface::class);
        $request->shouldReceive('getAttribute')->withArgs(['name'])->once()->andReturn('test');

        $delegate = Mockery::mock(DelegateInterface::class);

        $middleware = new UppercaseAction();

        /*@var $res \Zend\Diactoros\Response\JsonResponse */
        $res = $middleware->process($request, $delegate);

        $payload = $res->getPayload();
        assertThat($payload, hasKey('name'));
        assertThat($payload['name'], equalTo('TEST'));
    }
}

