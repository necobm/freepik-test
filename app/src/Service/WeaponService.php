<?php

namespace App\Service;

use App\Entity\Faction;
use App\Entity\Weapon;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class WeaponService extends BaseService
{
    public function __construct(
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer,
    ){
        parent::__construct($entityManager, $serializer);
        $this->resourceClass = Weapon::class;
    }
}