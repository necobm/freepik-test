<?php

namespace App\Service;

use App\Entity\Mission;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class MissionService extends BaseService
{
    public function __construct(
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer,
    ){
        parent::__construct($entityManager, $serializer);
        $this->resourceClass = Mission::class;
    }

    /**
     * @param Mission $object
     * @return void
     */
    public function remove(object $object): void
    {
        if (!empty($object->getCreatures())) {
            foreach ($object->getCreatures() as $creature) {
                $creature->setMission(null);
                $this->entityManager->persist($creature);
            }
        }
        $this->entityManager->remove($object);
        $this->entityManager->flush();
    }
}