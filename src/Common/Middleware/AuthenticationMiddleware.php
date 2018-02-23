<?php

namespace Common\Middleware;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Psr\Http\Message\ServerRequestInterface;
use Common\Service\KsqSession;
use Common\Service\GsrAuthentication;

class AuthenticationMiddleware extends AbstractMiddleware
{

    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        /* @var KsqSession $session */
        $session = $this->container->get(KsqSession::class);

        if (!$session->isConnected()) {
            /* @var GsrAuthentication $gsr */
            $gsr = $this->container->get(GsrAuthentication::class);

            $session
                ->login()
                ->set('gsr.pac', $gsr->getPac())
                ->set('connection.params', $gsr->getConnectionParams());
        }

        return $delegate->process($request);
    }

}

