<?php
namespace Outils\Middleware\Sum;

use Assert\Assert;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

class SumAction implements MiddlewareInterface
{

    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $post = $request->getParsedBody();

        // POST input validation
        Assert::that($post)
            ->keyIsset('a')
            ->keyIsset('b')
            ->count(2) // exactly 2 POST keys
            ->all()
            ->integerish(); // positive/negative integer

        // POST data is valid
        $response = new JsonResponse([
            'SUM' => $post['a'] + $post['b']
        ]);

        // Add some headers
        return $response->withHeader('X-Processed-Timestamp', time())->withAddedHeader('X-Auth', uniqid());
    }
}

