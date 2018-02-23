<?php

namespace Entretien\Repository;

use Common\Repository\AbstractRespository;

/**
 * No need to extend EntityRepository for the moment
 */
class CategorieRepository extends AbstractRespository
{

    public function findAllOrderedByOrdre(): array
    {
        return $this->getEntityManager()
            ->createQuery('SELECT c FROM Entretien\Entity\TCategorie c ORDER BY c.ordre ASC')
            ->getArrayResult();
    }

    /**
     * @return array AssociativeArray
     */
    public function findAllOrderedByOrdreWithNativeConnexion(): array
    {
        $sql = 'SELECT * FROM T_CATEGORIE ORDER BY ordre ASC';

        return $this->getEntityManager()->getConnection()->fetchAll($sql);
    }
}