<?php

namespace App\Service;

use App\Entity\Creature;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class CreatureService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private SerializerInterface $serializer
    ){}

    /**
     * @return Creature[]
     */
    public function getAllCreatures(): array
    {
        return $this->entityManager->getRepository(Creature::class)->findAll();
    }

    /**
     * @param int $creatureId
     * @return Creature|null
     */
    public function getCreature(int $creatureId): ?Creature
    {
        return $this->entityManager->find(Creature::class, $creatureId);
    }

    /**
     * @param string $creatureData
     * @return Creature
     * @throws \Exception
     */
    public function createCreatureFromJson(string $creatureData): Creature
    {
        /** @var Creature $creature */
        $creature = $this->serializer->deserialize($creatureData, Creature::class, 'json');

        if (!$creature instanceof Creature) {
            throw new \Exception("Failed decoding JSON into a Creature object");
        }

        $this->entityManager->persist($creature);
        $this->entityManager->flush();
        return $creature;
    }

    /**
     * @param Creature $faction
     * @return array
     */
    public function transformCreatureToArray(Creature $creature): array
    {
        $creatureData = $this->serializer->serialize($creature, 'json');
        $creatureData = json_decode($creatureData, true);
        return $creatureData !== false ? $creatureData : [];
    }
}