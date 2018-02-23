<?php

namespace Common\Middleware;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;
use Common\Service\KsqSession;
use Fig\Http\Message\StatusCodeInterface;

class RouteNotFoundMiddleware extends AbstractMiddleware
{

    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $response = ['message' => 'An unexpected error occurred: URL not found'];

        $this->container->get(KsqSession::class)->destroy();

        return new JsonResponse($response, StatusCodeInterface::STATUS_NOT_FOUND);
    }

}

