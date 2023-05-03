<?php

namespace App\Service;

use App\Entity\Faction;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Serializer\SerializerInterface;

class FactionService extends BaseService
{
    public function __construct(
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer,
        Security $security
    ){
        parent::__construct($entityManager, $serializer, $security);
        $this->resourceClass = Faction::class;
    }
}