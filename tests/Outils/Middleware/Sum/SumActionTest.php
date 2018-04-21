<?php
namespace Outils\Middleware\Sum;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Psr\Http\Message\ServerRequestInterface;
use Stub\KsqTestCase;
use Mockery;

class SumActionTest extends KsqTestCase
{

    public function testProcess()
    {
        $request = Mockery::mock(ServerRequestInterface::class);
        $request->shouldReceive('getParsedBody')->once()->andReturn([
            'a' => 10,
            'b' => -2
        ]);

        $delegate = Mockery::mock(DelegateInterface::class);

        $middleware = new SumAction();

        /*@var $res \Zend\Diactoros\Response\JsonResponse */
        $res = $middleware->process($request, $delegate);

        $payload = $res->getPayload();
        assertThat($payload, hasKey('SUM'));
        assertThat($payload['SUM'], equalTo(8));
    }
}

