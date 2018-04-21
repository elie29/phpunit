<?php
namespace Common\Service;

use Doctrine\ORM\EntityManager;
use Entretien\Entity\TCategorie;
use Mockery;
use Psr\Container\ContainerInterface;
use Stub\KsqTestCase;
use Doctrine\Common\Cache\ArrayCache;

class EntityManagerFactoryTest extends KsqTestCase
{

    /**
     * @expectedException Exception
     */
    public function testInvokeWithEmptyContainerAndThrowException()
    {
        $factory = new EntityManagerFactory();
        $container = Mockery::mock(ContainerInterface::class);
        $container->shouldReceive('has')->once()->andReturn(false);

        // Invoke factory object
        $factory($container);
    }

    public function testInvokeWithInMemoryDBDevMode()
    {
        $em = $this->getEntityManager();

        assertThat($em, notNullValue());
        assertThat($em, is(anInstanceOf(EntityManager::class)));
    }

    public function testInvokeAndGetRepositoryWithEM()
    {
        $em = $this->getEntityManager();

        $cn = $em->getRepository(TCategorie::class)->getClassName();

        assertThat($cn, is(TCategorie::class));
    }

    /**
     * @return EntityManager
     */
    private function getEntityManager()
    {
        $factory = new EntityManagerFactory();

        $session = Mockery::mock(KsqSession::class);
        $session->shouldReceive('get')->andReturn(['url' => 'sqlite::memory:']);

        $container = Mockery::mock(ContainerInterface::class);
        $container->shouldReceive('has')->once()->andReturn(true);
        $container->shouldReceive('get')->times(4)->andReturn($this->getConfig(), new ArrayCache(), null, $session);

        // Invoke the factory
        return $factory($container);
    }

    private function getConfig()
    {
        $config = [
            'em' => [
                'dev_mode' => true,
                'paths' => [BE_PATH . '/src'],
                'proxy' => null
            ]
        ];

        return $config;
    }
}

