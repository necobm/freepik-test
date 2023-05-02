<?php

namespace App\Service;

use App\Entity\Creature;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class CreatureService extends BaseService
{
    public function __construct(
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer
    ){
        parent::__construct($entityManager, $serializer);
        $this->resourceClass = Creature::class;
    }


}