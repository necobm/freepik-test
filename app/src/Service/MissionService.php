<?php

namespace App\Service;

use App\Entity\Mission;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Serializer\SerializerInterface;

class MissionService extends BaseService
{
    public function __construct(
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer,
        Security $security
    ){
        parent::__construct($entityManager, $serializer, $security);
        $this->resourceClass = Mission::class;
    }

    /**
     * @param Mission $object
     * @return void
     */
    public function remove(object $object): void
    {
        if( !$this->checkAccessRights(Request::METHOD_DELETE) ){
            throw new AccessDeniedException("Insufficient rights to perform this operation");
        }
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