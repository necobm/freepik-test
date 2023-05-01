<?php

namespace App\Service;

use App\Entity\Faction;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class FactionService
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private SerializerInterface $serializer
    ){}

    /**
     * @return array
     */
    public function getAllFactions(): array
    {
        return $this->entityManager->getRepository(Faction::class)->findAll();
    }

    /**
     * @param int $factionId
     * @return Faction|null
     */
    public function getFaction(int $factionId): ?Faction
    {
        return $this->entityManager->find(Faction::class, $factionId);
    }

    /**
     * @param string $factionData
     * @return Faction
     * @throws \Exception
     */
    public function createFactionFromJson(string $factionData): Faction
    {
        /** @var Faction $faction */
        $faction = $this->serializer->deserialize($factionData, Faction::class, 'json');

        if (!$faction instanceof Faction) {
            throw new \Exception("Failed decoding JSON into Faction object");
        }

        $this->entityManager->persist($faction);
        $this->entityManager->flush();
        return $faction;
    }

    /**
     * @param Faction $faction
     * @return array
     */
    public function transformFactionToArray(Faction $faction): array
    {
        $factionData = $this->serializer->serialize($faction, 'json');
        $factionData = json_decode($factionData, true);
        return $factionData !== false ? $factionData : [];
    }
}