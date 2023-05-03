<?php

namespace App\Service;

use App\Entity\Creature;
use App\Entity\Weapon;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Serializer\SerializerInterface;

class WeaponService extends BaseService
{
    public function __construct(
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer,
        Security $security
    ){
        parent::__construct($entityManager, $serializer, $security);
        $this->resourceClass = Weapon::class;
    }

    /**
     * @param Weapon $object
     * @return void
     */
    public function remove(object $object): void
    {
        if( !$this->checkAccessRights(Request::METHOD_DELETE) ){
            throw new AccessDeniedException("Insufficient rights to perform this operation");
        }
        $creaturesWithThisWeapon = $this->entityManager->getRepository(Creature::class)->findBy([
            'weapon' => $object->getId()
        ]);

        if (!empty($creaturesWithThisWeapon)) {
            foreach ($creaturesWithThisWeapon as $creature) {
                $creature->setWeapon(null);
                $this->entityManager->persist($creature);
            }
        }
        $this->entityManager->remove($object);
        $this->entityManager->flush();
    }
}