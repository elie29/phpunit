<?php
namespace Stub;

use Doctrine\ORM\EntityManagerInterface;

final class KsqTestHelper
{

    public static function getEntityManager(): EntityManagerInterface
    {
        static $i = null;
        if (null === $i) {
            /*@var $helper \Symfony\Component\Console\Helper\HelperSet */
            $helper = require BE_PATH . '/cli-config.php';
            $i = $helper->get('em')->getEntityManager();
        }
        return $i;
    }
}

