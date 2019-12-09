<?php

namespace App\Tests;

use App\Kernel;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\SchemaTool;
use Psr\Container\ContainerInterface;

/**
 * @author mati.andreas@ambientia.ee
 */
trait DoctrineTestTrait
{
    /**
     * @var ManagerRegistry
     */
    private $doctrine;

    public static function setUpBeforeClass()
    {
        putenv('SYMFONY_DEPRECATIONS_HELPER=weak');

        parent::setUpBeforeClass();
        $doctrine = self::createDoctrine();

        $em = $doctrine->getManager();
        $s = new SchemaTool($em);
        $s->updateSchema($em->getMetadataFactory()->getAllMetadata(), false);
    }

    private static function createDoctrine(): ManagerRegistry
    {
        $container = self::createContainer();
        $doctrine = $container->get('doctrine');

        return $doctrine;
    }

    private static function createContainer(): ContainerInterface
    {
        $kernel = new Kernel('test', false);
        $kernel->boot();
        $container = $kernel->getContainer();

        return $container;
    }

    protected function setUp()
    {
        parent::setUp();
        $container = static::createContainer();
        $this->doctrine = $container->get('doctrine');
        $this->clearDoctrine();
    }


    protected function tearDown()
    {
        $this->clearDoctrine();
        parent::tearDown();
    }

    protected function clearDoctrine(): void
    {
        $em = $this->doctrine->getManager();
        foreach ($this->classes as $class) {
            foreach (
                $em
                    ->getRepository($class)
                    ->findAll() as $entity
            ) {
                $em->remove($entity);
            }
        }
        $em->flush();
        $em->clear();
    }

}