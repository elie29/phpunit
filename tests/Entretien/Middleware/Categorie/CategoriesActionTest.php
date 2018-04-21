<?php
namespace Entretien\Middleware\Categorie;

use Doctrine\ORM\EntityManagerInterface;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Stub\KsqTestCase;
use Mockery;

class CategoriesActionTest extends KsqTestCase
{

    public function testProcess()
    {
        $em = Mockery::mock(EntityManagerInterface::class);
        $em->shouldReceive('findAllOrderedByOrdreWithNativeConnexion')->andReturn([]);

        $container = Mockery::mock(ContainerInterface::class);
        $container->shouldReceive('get')
            ->once()
            ->andReturn($em);

        $request = Mockery::mock(ServerRequestInterface::class);
        $delegate = Mockery::mock(DelegateInterface::class);

        $middleware = new CategoriesAction($container);
        /*@var $res \Zend\Diactoros\Response\JsonResponse */
        $res = $middleware->process($request, $delegate);

        assertThat($res->getPayload(), hasKey('categories'));
    }
}