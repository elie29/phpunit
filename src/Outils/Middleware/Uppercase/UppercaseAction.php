<?php
namespace Outils\Middleware\Uppercase;

use Assert\Assertion;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

class UppercaseAction implements MiddlewareInterface
{

    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $name = $request->getAttribute('name');
        Assertion::notBlank($name);

        return new JsonResponse([
            'name' => strtoupper($name)
        ]);
    }
}

