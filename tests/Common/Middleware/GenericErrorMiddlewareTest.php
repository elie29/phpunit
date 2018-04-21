<?php
namespace Common\Middleware;

use Common\Service\KsqException;
use Common\Service\KsqSession;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Stub\GenericTriggerError;
use Stub\KsqTestCase;
use Mockery;

class GenericErrorMiddlewareTest extends KsqTestCase
{

    private $container;

    protected function setUp()
    {
        parent::setUp();

        $session = Mockery::mock(KsqSession::class);
        $session->shouldReceive('destroy')->atMost(1);
        $this->container = Mockery::mock(ContainerInterface::class);
        $this->container->shouldReceive('get')->andReturn($session);
    }

    public function testProcessWithNoError()
    {
        $auth = new GenericErrorMiddleware($this->container);

        $request = Mockery::mock(ServerRequestInterface::class);
        $response = Mockery::mock(ResponseInterface::class);

        $delegate = Mockery::mock(DelegateInterface::class);
        $delegate->shouldReceive('process')
            ->times(1)
            ->andReturn($response);

        $res = $auth->process($request, $delegate);

        assertThat($res, sameInstance($response));
    }

    public function testProcessExpectDelegationException()
    {
        $action = new GenericErrorMiddleware($this->container);

        $request = Mockery::mock(ServerRequestInterface::class);

        $delegate = Mockery::mock(DelegateInterface::class);
        $delegate->shouldReceive('process')
            ->once()
            ->andThrows(KsqException::class, 'Mock Exception');

        /*@var $res \Zend\Diactoros\Response\JsonResponse */
        $res = $action->process($request, $delegate);

        assertThat($res->getPayload(), hasValue('Mock Exception'));
    }

    public function testProcessTriggerError()
    {
        $action = new GenericErrorMiddleware($this->container);

        $request = Mockery::mock(ServerRequestInterface::class);
        $delegate = new GenericTriggerError();

        /*@var $res \Zend\Diactoros\Response\JsonResponse */
        $res = $action->process($request, $delegate);

        assertThat($res->getPayload(), hasValue('stubing error handler'));
    }
}

