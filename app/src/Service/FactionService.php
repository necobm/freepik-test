<?php

namespace App\Service;

use App\Entity\Faction;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class FactionService extends BaseService
{
    public function __construct(
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer,
    ){
        parent::__construct($entityManager, $serializer);
        $this->resourceClass = Faction::class;
    }
}