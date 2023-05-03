<?php

namespace Service;

use App\Entity\Creature;
use App\Entity\Faction;
use App\Service\BaseService;
use App\Service\CreatureService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Serializer\SerializerInterface;

class CreatureServiceTest extends TestCase
{
    private CreatureService $creatureService;
    private MockObject $entityManager;
    private MockObject $serializer;
    private MockObject $security;

    protected function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->serializer = $this->createMock(SerializerInterface::class);
        $this->security = $this->createMock(Security::class);
    }

    public function testGetAllReturnsArrayOfObjects()
    {
        $creature1 = $this->createMock(Creature::class);
        $creature2 = $this->createMock(Creature::class);

        $repository = $this->createMock(EntityRepository::class);
        $repository->expects($this->once())
            ->method('findAll')
            ->willReturn([$creature1, $creature2]);
        $this->entityManager->expects($this->once())
            ->method('getRepository')
            ->willReturn($repository);

        $this->creatureService = new CreatureService($this->entityManager, $this->serializer, $this->security);

        $result = $this->creatureService->getAll();

        $this->assertIsArray($result);
        $this->assertCount(2, $result);
        $this->assertInstanceOf(Creature::class, $result[0]);
        $this->assertInstanceOf(Creature::class, $result[1]);
    }

    public function testGetOneReturnsObject()
    {
        $creature = $this->createMock(Creature::class);
        $this->entityManager
            ->method('find')
            ->willReturn($creature);

        $this->creatureService = new CreatureService($this->entityManager, $this->serializer, $this->security);

        $result = $this->creatureService->getOne(1);
        $this->assertInstanceOf(Creature::class, $result);
    }

    public function testCreateObjectFromJsonReturnsObject()
    {
        $validJson = '{
            "name": "Saruman",
            "age": 203,
            "mission": 2
        }';
        $creature = new Creature();
        $this->serializer->method('deserialize')->willReturn($creature);

        $creatureService = new CreatureService($this->entityManager, $this->serializer, $this->security);

        $object = $creatureService->createObjectFromJson($validJson);

        $this->assertInstanceOf(Creature::class, $object);

    }

    /**
     * @return void
     * @dataProvider createObjectFromJsonDataProvider
     */
    public function testCreateObjectFromJsonThrowsException(int $step, string $json, object $object)
    {
        $this->expectException(\Exception::class);
        switch ($step) {
            case 1:
                $this->expectExceptionMessage("Failed decoding JSON into an object");
                break;
            case 2:
                $this->expectExceptionMessage("Invalid JSON format");
                break;
        }

        $this->serializer->method('deserialize')->willReturn($object);

        $creatureService = new CreatureService($this->entityManager, $this->serializer, $this->security);

        $object = $creatureService->createObjectFromJson($json);
    }

    public function testUpdateObjectFromJsonReturnsObject()
    {
        $validJson = '{
            "name": "Saruman",
            "age": 203,
            "mission": 2
        }';
        $creature = new Creature();
        $this->serializer->method('deserialize')->willReturn($creature);

        $creatureService = new CreatureService($this->entityManager, $this->serializer, $this->security);

        $object = $creatureService->updateObjectFromJson($validJson, $creature);

        $this->assertInstanceOf(Creature::class, $object);
    }

    /**
     * @return void
     * @dataProvider createObjectFromJsonDataProvider
     */
    public function testUpdateObjectFromJsonThrowsException(int $step, string $json, object $object)
    {
        $this->expectException(\Exception::class);
        switch ($step) {
            case 1:
                $this->expectExceptionMessage("Failed decoding JSON into an object");
                break;
            case 2:
                $this->expectExceptionMessage("Invalid JSON format");
                break;
        }

        $this->serializer->method('deserialize')->willReturn($object);

        $creatureService = new CreatureService($this->entityManager, $this->serializer, $this->security);

        $object = $creatureService->updateObjectFromJson($json, $object);
    }

    public function testTransformObjectToArrayReturnsValidArray()
    {
        $validJson = '{
            "name": "Saruman",
            "age": 203,
            "mission": 2
        }';
        $this->serializer->method('serialize')->willReturn($validJson);

        $creatureService = new CreatureService($this->entityManager, $this->serializer, $this->security);

        $arrayData = $creatureService->transformObjectToArray(new Creature());

        $this->assertIsArray($arrayData);
        $this->assertNotEmpty($arrayData);
        $this->assertArrayHasKey('name', $arrayData);
        $this->assertArrayHasKey('age', $arrayData);
        $this->assertArrayHasKey('mission', $arrayData);
    }

    public function testTransformObjectToArrayReturnsEmptyArray()
    {
        $invalidJson = '
            "name": "Saruman",
            "age": 203,
            "mission": 2,
        }';
        $this->serializer->method('serialize')->willReturn($invalidJson);

        $creatureService = new CreatureService($this->entityManager, $this->serializer, $this->security);

        $arrayData = $creatureService->transformObjectToArray(new Creature());

        $this->assertIsArray($arrayData);
        $this->assertEmpty($arrayData);
    }

    /**
     * @param int $step
     * @param bool $isAdmin
     * @return void
     * @dataProvider checkAccessRightsDataProvider
     */
    public function testRemove(int $step, bool $isAdmin)
    {
        switch ($step) {
            case 1:
                $this->security->method('isGranted')->willReturn($isAdmin);
                $creatureService = new CreatureService($this->entityManager, $this->serializer, $this->security);
                $creatureService->remove(new Creature());
                $this->expectNotToPerformAssertions();
                break;
            case 2:
                $this->expectException(AccessDeniedException::class);
                $this->security->method('isGranted')->willReturn($isAdmin);
                $creatureService = new CreatureService($this->entityManager, $this->serializer, $this->security);
                $creatureService->remove(new Creature());
                break;
        }
    }



    public static function createObjectFromJsonDataProvider(): array
    {
        return [
            [
                'step' => 1,
                'json' => '{
                    "name": "Saruman",
                    "age": 203,
                    "mission": 2
                }',
                'object' => new Faction()
            ],
            [
                'step' => 2,
                'json' => '
                    "name": "Saruman",
                    "age": 203,
                    "mission": 2,
                }',
                'object' => new Creature()
            ],
        ];
    }

    public static function checkAccessRightsDataProvider(): array
    {
        return [
            [
                'step' => 1,
                'isAdmin' => true
            ],
            [
                'step' => 2,
                'isAdmin' => false
            ]
        ];
    }
}