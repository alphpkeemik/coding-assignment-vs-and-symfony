<?php

namespace App\Tests\ModuleName;

use App\ModuleName\ControllerName;
use App\ModuleName\ModelName;
use App\ModuleName\ModuleNameFactory;
use App\Tests\DoctrineTestTrait;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ModuleNameRouteTest extends WebTestCase
{
    use DoctrineTestTrait;

    private $classes = [];

    public function testFunctional(): void
    {
        $client = static::createClient();
        $model = new ModelName();
        $value = uniqid();
        $model->setValue($value);
        $em = $this->doctrine->getManager();
        $em->persist($model);
        $em->flush();
        $em->clear();

        $argument = uniqid();
        $client->request('GET', "/module/route/$argument");

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertSame($data['code'], 200);
        $this->assertSame($data['result']['value'], $value);
    }

    public function testUnitSuccess(): void
    {
        $managerRegistry = $this->createMock(ManagerRegistry::class);
        $objectManager = $this->createMock(ObjectManager::class);
        $objectRepository = $this->createMock(ObjectRepository::class);
        $argument = uniqid();
        $value = uniqid();
        $moduleName = $this->createConfiguredMock(ModuleName::class, [
            'getValue' => $value
        ]);
        $expected = <<<EOD
{"code":200,"result":{"value":"$value"}}
EOD;

        $managerRegistry
            ->expects($this->once())
            ->method('getManagerForClass')
            ->with(ModuleName::class)
            ->willReturn($objectManager);

        $objectManager
            ->expects($this->once())
            ->method('getRepository')
            ->with(ModuleName::class)
            ->willReturn($objectRepository);

        $objectRepository
            ->expects($this->once())
            ->method('findOneBy')
            ->with(['key_in_module' => $argument])
            ->willReturn($moduleName);


        $script = new ControllerName($managerRegistry);
        $return = $script->actionName($argument);
        $this->assertSame(200, $return->getStatusCode());
        $actual = $return->getContent();
        $this->assertSame($expected, $actual);
    }
}