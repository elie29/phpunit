<?php

namespace Common\Middleware;

use Common\Service\KsqException;
use Common\Service\KsqSession;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;
use Fig\Http\Message\StatusCodeInterface;

class GenericErrorMiddleware extends AbstractMiddleware
{

    /**
     * Return a message in Json format.
     */
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $this->setHandler();

        $response = $this->getResponse($request, $delegate);

        restore_error_handler();

        return $response;
    }

    private function setHandler()
    {
        set_error_handler(function ($errno, $errstr) {
            //@codeCoverageIgnoreStart
            if (! (error_reporting() & $errno)) {
                // Error is not in mask
                return;
            }
            //@codeCoverageIgnoreEnd
            throw new KsqException($errstr);
        });
    }

    /**
     * Returns JsonResponse with 500 status.
     */
    private function getResponse(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $status = StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR;
        try {
            return $delegate->process($request);
        } catch (\Throwable $e) {
            $exception = $e;
        }
        //@codeCoverageIgnoreStart
        catch (\Exception $e) {
            $exception = $e;
        }
        //@codeCoverageIgnoreEnd

        // Destroy the session when a exception occured!
        $this->container->get(KsqSession::class)->destroy();

        return new JsonResponse(['message' => $exception->getMessage()], $status);
    }

}
