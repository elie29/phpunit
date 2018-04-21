<?php

namespace Entretien\Middleware\Categorie;

use Common\Middleware\AbstractMiddleware;
use Entretien\Repository\CategorieRepository;
use Interop\Http\ServerMiddleware\DelegateInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\JsonResponse;

class CategoriesAction extends AbstractMiddleware
{

    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        /*@var $repo \Entretien\Repository\TCategorieRepository */
        $repo = $this->container->get(CategorieRepository::class);

        $result = $repo->findAllOrderedByOrdreWithNativeConnexion();

        return new JsonResponse(['categories' => $result]);
    }

}

