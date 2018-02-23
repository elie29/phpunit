<?php

namespace Common\Middleware;

use Common\Service\KsqSession;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Psr\Http\Message\ServerRequestInterface;

class SessionMiddleware extends AbstractMiddleware
{

    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        /* @var KsqSession $session */
        $session = $this->container->get(KsqSession::class);

        $session->start();

        return $delegate->process($request);
    }
}
