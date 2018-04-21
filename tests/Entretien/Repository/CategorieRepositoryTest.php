<?php
namespace Entretien\Repository;

use Stub\KsqTestCase;
use Stub\KsqTestHelper;

/**
 * CategorieRepository test case.
 */
class CategorieRepositoryTest extends KsqTestCase
{

    private $repo;

    protected function setUp()
    {
        $this->repo = new CategorieRepository(KsqTestHelper::getEntityManager());
    }

    /**
     * Tests TCategorieRepository->findAllOrderedByOrdre()
     */
    public function testFindAllOrderedByOrdre()
    {
        $response = $this->repo->findAllOrderedByOrdre();

        assertThat($response, notNullValue());
    }

    /**
     * Tests TCategorieRepository->findAllOrderedByOrdreWithNativeConnexion()
     */
    public function testFindAllOrderedByOrdreWithNativeConnexion()
    {
        $response = $this->repo->findAllOrderedByOrdreWithNativeConnexion();

        assertThat($response, notNullValue());
    }

}

