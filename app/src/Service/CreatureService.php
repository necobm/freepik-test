<?php

namespace App\Service;

use App\Entity\Creature;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Serializer\SerializerInterface;

class CreatureService extends BaseService
{
    public function __construct(
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer,
        Security $security
    ){
        parent::__construct($entityManager, $serializer, $security);
        $this->resourceClass = Creature::class;
    }


}